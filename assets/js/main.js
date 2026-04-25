(function() {
    'use strict';
    
    // ユーティリティ: スロットリング関数
    function throttle(func, delay) {
        let timeoutId;
        let lastExec = 0;
        
        return function(...args) {
            const elapsed = Date.now() - lastExec;
            
            const execute = () => {
                lastExec = Date.now();
                func.apply(this, args);
            };
            
            clearTimeout(timeoutId);
            
            if (elapsed > delay) {
                execute();
            } else {
                timeoutId = setTimeout(execute, delay - elapsed);
            }
        };
    }
    
    // ユーティリティ: GA4イベント送信（存在する場合のみ）
    function sendToGA4(eventName, eventParams = {}) {
        // GA4が読み込まれているか確認
        if (typeof gtag === 'function') {
            // gtag APIを使用（推奨方法）
            gtag('event', eventName, eventParams);
        } else if (typeof dataLayer !== 'undefined' && Array.isArray(dataLayer)) {
            // dataLayerに直接push（フォールバック）
            dataLayer.push({
                event: eventName,
                ...eventParams
            });
        } else {
            // GA4が読み込まれていない場合はコンソールに警告（開発環境のみ）
            if (window.location.hostname === 'localhost' || window.location.hostname.includes('local')) {
                console.info('GA4 not loaded. Event:', eventName, eventParams);
            }
        }
    }
    
    // ページ読み込み前にハッシュスクロールを準備（ブラウザのデフォルト動作を防止）
    if (window.location.hash) {
        window.history.scrollRestoration = 'manual';
        // ブラウザのデフォルトスクロールを防止
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
    }

    // メイン初期化
    document.addEventListener('DOMContentLoaded', () => {
        initStickyHeader();
        initFrontPageIntroDetails();
        initMobileMenu();
        initHashScroll(); // ページ読み込み時のハッシュスクロール
        initImageLoading(); // LCP対象画像は待たずに状態反映

        // パフォーマンス最適化（特にモバイル）
        // - TBT低減のため「必須以外」はアイドル時に初期化する
        const runWhenIdle = (fn, timeout = 1500) => {
            try {
                if ('requestIdleCallback' in window) {
                    window.requestIdleCallback(() => {
                        try { fn(); } catch (_) {}
                    }, { timeout });
                } else {
                    setTimeout(() => {
                        try { fn(); } catch (_) {}
                    }, 120);
                }
            } catch (_) {}
        };

        runWhenIdle(initFadeInAnimation, 1200);
        runWhenIdle(initSmoothScroll, 1200);
        runWhenIdle(initMicroInteractions, 1600);
        runWhenIdle(initScrollProgress, 1800);
        runWhenIdle(initScrollTracking, 2000);
        runWhenIdle(initSNSShareMenu, 2200);
        runWhenIdle(initEbooksLangSwitch, 2200);
        runWhenIdle(initLinkTracking, 2500);
        runWhenIdle(initPrefetch, 2800);
    });
    
    // ブラウザのBack-Forward Cache対応
    window.addEventListener('pageshow', (event) => {
        if (event.persisted) {
            const siteBody = document.querySelector('.site-body');
            if (siteBody) siteBody.classList.add('loaded');
        }
    });
    
    // ===== フェードインアニメーション =====
    function initFadeInAnimation() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const fadeInObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, observerOptions);
        
        const fadeElements = document.querySelectorAll(
            '.nav-card, .intro-feature, .about-section, .work-item, .project-section, .intro-container, .search-form-section, .search-result-item, .no-results'
        );
        
        fadeElements.forEach((el, index) => {
            // ファーストビューの要素は即座に表示（ちらつき防止）
            const rect = el.getBoundingClientRect();
            const isInViewport = rect.top < window.innerHeight && rect.bottom > 0;
            
            if (isInViewport) {
                // ファーストビューはアニメーションなしで即表示
                el.classList.add('is-visible');
            } else {
                // スクロールで表示される要素のみフェードイン
                el.classList.add('fade-in-element');
                el.style.transitionDelay = `${index * 0.05}s`;
                fadeInObserver.observe(el);
            }
        });
    }
    
    // ===== 画像の最適化と遅延読み込み（BEM対応） =====
    function initImageLoading() {
        // ファーストビュー画像の優先読み込み
        const heroImages = document.querySelectorAll('.hero-section .image, .page-header .image');
        heroImages.forEach(img => {
            img.setAttribute('loading', 'eager');
            img.setAttribute('fetchpriority', 'high');
            img.classList.add('image--eager');
            if (img.complete && img.naturalHeight !== 0) {
                img.classList.add('is-loaded');
            }
        });
        
        // 遅延読み込み画像の読み込み完了監視
        const lazyImages = document.querySelectorAll('.image--lazy');
        lazyImages.forEach(img => {
            if (img.complete && img.naturalHeight !== 0) {
                img.classList.add('is-loaded');
            } else {
                img.addEventListener('load', function() {
                    this.classList.add('is-loaded');
                }, { once: true });
            }
        });
        
        // data-src属性を使った遅延読み込み
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                            
                            img.addEventListener('load', () => {
                                img.classList.add('is-loaded');
                            }, { once: true });
                        }
                        
                        observer.unobserve(img);
                    }
                });
            }, {
                rootMargin: '50px 0px',
                threshold: 0.01
            });
            
            document.querySelectorAll('.image[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }
    
    // ===== 追従ヘッダー =====
    function initStickyHeader() {
        const headerShell = document.querySelector('.site-header-shell');
        const siteNav = document.querySelector('.site-nav');
        if (!headerShell) return;

        const root = document.documentElement;
        const desktopMedia = window.matchMedia ? window.matchMedia('(min-width: 901px)') : null;
        let desktopNavThreshold = 0;
        const getAdminOffset = () => document.body.classList.contains('admin-bar') ? 32 : 0;
        const getStickyElement = () => {
            if (desktopMedia && desktopMedia.matches && siteNav) {
                return siteNav;
            }

            return headerShell;
        };

        const updateStickyHeaderHeight = () => {
            const stickyElement = getStickyElement();
            const height = stickyElement ? Math.ceil(stickyElement.getBoundingClientRect().height) : 0;
            root.style.setProperty('--site-header-height', `${height}px`);
        };

        const syncDesktopFixedNav = () => {
            if (!desktopMedia || !siteNav) return;

            if (!desktopMedia.matches) {
                siteNav.classList.remove('is-desktop-fixed');
                headerShell.classList.remove('has-fixed-nav');
                return;
            }

            const shouldFix = window.scrollY >= desktopNavThreshold;
            siteNav.classList.toggle('is-desktop-fixed', shouldFix);
            headerShell.classList.toggle('has-fixed-nav', shouldFix);
        };

        const measureDesktopNav = () => {
            if (!desktopMedia || !siteNav) {
                updateStickyHeaderHeight();
                return;
            }

            if (!desktopMedia.matches) {
                siteNav.classList.remove('is-desktop-fixed');
                headerShell.classList.remove('has-fixed-nav');
                updateStickyHeaderHeight();
                return;
            }

            siteNav.classList.remove('is-desktop-fixed');
            headerShell.classList.remove('has-fixed-nav');
            desktopNavThreshold = Math.max(0, window.scrollY + siteNav.getBoundingClientRect().top - getAdminOffset());
            updateStickyHeaderHeight();
            syncDesktopFixedNav();
        };

        measureDesktopNav();
        window.addEventListener('load', measureDesktopNav, { once: true });
        window.addEventListener('resize', throttle(measureDesktopNav, 100));
        window.addEventListener('scroll', throttle(syncDesktopFixedNav, 20), { passive: true });

        if ('ResizeObserver' in window) {
            const resizeObserver = new ResizeObserver(measureDesktopNav);
            resizeObserver.observe(headerShell);
            if (siteNav) {
                resizeObserver.observe(siteNav);
            }
        }

        if (desktopMedia && typeof desktopMedia.addEventListener === 'function') {
            desktopMedia.addEventListener('change', measureDesktopNav);
        }
    }

    function getStickyHeaderOffset() {
        const rootStyles = getComputedStyle(document.documentElement);
        const cssOffset = parseFloat(rootStyles.getPropertyValue('--site-header-height')) || 0;
        return cssOffset + 12;
    }

    function initFrontPageIntroDetails() {
        const details = document.querySelector('.site-intro__details');
        if (!details || !window.matchMedia) return;

        const mobileMedia = window.matchMedia('(max-width: 768px)');
        const syncDetailsState = () => {
            details.open = !mobileMedia.matches;
        };

        syncDetailsState();

        if (typeof mobileMedia.addEventListener === 'function') {
            mobileMedia.addEventListener('change', syncDetailsState);
        } else {
            window.addEventListener('resize', throttle(syncDetailsState, 120));
        }
    }

    // ===== モバイルメニュー =====
    function initMobileMenu() {
        const menuToggle = document.querySelector('.menu-toggle');
        const siteNav = document.querySelector('.site-nav');
        const siteBody = document.querySelector('.site-body');
        const mobileNavBreakpoint = 900;
        
        if (!menuToggle || !siteNav || !siteBody) return;
        
        // メニューのトグル
        menuToggle.addEventListener('click', function() {
            const isOpen = this.classList.toggle('active');
            siteNav.classList.toggle('is-open');
            
            this.setAttribute('aria-expanded', isOpen);
            this.setAttribute('aria-label', isOpen ? 'メニューを閉じる' : 'メニューを開く');
            
            if (window.innerWidth <= mobileNavBreakpoint) {
                siteBody.style.overflow = isOpen ? 'hidden' : '';
            }

            requestAnimationFrame(() => {
                window.dispatchEvent(new Event('resize'));
            });
        });
        
        // メニューリンクをクリックしたら閉じる（モバイルのみ）
        siteNav.addEventListener('click', (event) => {
            const link = event.target.closest('a');
            if (!link) return;

            if (window.innerWidth <= mobileNavBreakpoint && menuToggle.classList.contains('active')) {
                menuToggle.click();
            }
        });
        
        // リサイズ時の処理
        window.addEventListener('resize', throttle(() => {
            if (window.innerWidth > mobileNavBreakpoint) {
                menuToggle.classList.remove('active');
                siteNav.classList.remove('is-open');
                menuToggle.setAttribute('aria-expanded', 'false');
                siteBody.style.overflow = '';
            }
        }, 250));
    }
    
    // ===== マイクロインタラクション（リップルエフェクト） =====
    function initMicroInteractions() {
        const buttons = document.querySelectorAll('.nav-card-link, .project-demo-btn');
        
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function(e) {
                createRipple(e, this);
            });
        });
        
        function createRipple(event, element) {
            const circle = document.createElement('span');
            // getBoundingClientRect()を1回だけ呼ぶ（強制リフロー削減）
            const rect = element.getBoundingClientRect();
            const diameter = Math.max(rect.width, rect.height);
            const radius = diameter / 2;
            
            // cssTextで一括設定（パフォーマンス最適化）
            circle.style.cssText = `width:${diameter}px;height:${diameter}px;left:${event.clientX - rect.left - radius}px;top:${event.clientY - rect.top - radius}px`;
            circle.classList.add('ripple');
            
            const existingRipple = element.querySelector('.ripple');
            if (existingRipple) {
                existingRipple.remove();
            }
            
            element.appendChild(circle);
        }
    }
    
    // ===== スムーズスクロール =====
    function getAnchorTargetFromHash(hash) {
        if (!hash) return null;

        // hash: "#section" も "section" も受ける
        const raw = hash.charAt(0) === '#' ? hash.slice(1) : hash;
        if (!raw) return null;

        // まずは id を最優先（CSSセレクタ制約の影響を受けない）
        // decodeURIComponent は %E3%... のようなケースに対応
        let decoded = raw;
        try { decoded = decodeURIComponent(raw); } catch (_) {}

        const byId = document.getElementById(decoded) || document.getElementById(raw);
        if (byId) return byId;

        // fallback: querySelector（idが特殊文字の場合は CSS.escape が必要）
        try {
            if (window.CSS && typeof window.CSS.escape === 'function') {
                const esc = window.CSS.escape(decoded);
                return document.querySelector('#' + esc);
            }
        } catch (_) {}

        return null;
    }

    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href !== '') {
                    e.preventDefault();
                    const target = getAnchorTargetFromHash(href);
                    if (target) {
                        scrollToTarget(target);
                    }
                }
            });
        });
    }
    
    // ===== ページ読み込み時のハッシュジャンプ =====
    function initHashScroll() {
        // URLにハッシュがある場合（例: #demo-video）
        if (!window.location.hash) return;
        
        const hash = window.location.hash;
        
        // 複数のタイミングで試行（確実に実行するため）
        const tryScroll = () => {
            const target = getAnchorTargetFromHash(hash);
            
            if (target) {
                const headerOffset = getStickyHeaderOffset();
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                // 即座にジャンプ
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'auto'
                });
                
                return true; // 成功
            }
            
            return false; // 失敗
        };
        
        // 1回目: DOMContentLoaded直後
        if (!tryScroll()) {
            // 2回目: 少し待ってリトライ
            setTimeout(() => {
                if (!tryScroll()) {
                    // 3回目: さらに待ってリトライ
                    setTimeout(tryScroll, 300);
                }
            }, 100);
        }
        
        // 4回目: 画像などすべて読み込み後
        window.addEventListener('load', () => {
            setTimeout(tryScroll, 100);
        }, { once: true });
    }
    
    // ===== ターゲット要素へのスクロール（クリック時用） =====
    function scrollToTarget(target) {
        const headerOffset = getStickyHeaderOffset();
        const elementPosition = target.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
        
        // クリック時はスムーススクロール
        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
        });
    }
    
    // ===== スクロールプログレスバー =====
    function initScrollProgress() {
        const progressBar = document.querySelector('.scroll-progress-bar');
        if (!progressBar) return;
        
        // 初回計算をキャッシュ（強制リフロー削減）
        let cachedScrollHeight = 0;
        let cachedClientHeight = 0;
        
        const recalculateDimensions = () => {
            cachedScrollHeight = document.documentElement.scrollHeight;
            cachedClientHeight = document.documentElement.clientHeight;
        };
        
        // 初回とリサイズ時のみ計算
        recalculateDimensions();
        window.addEventListener('resize', throttle(recalculateDimensions, 500));
        
        const updateProgress = throttle(() => {
            const windowHeight = cachedScrollHeight - cachedClientHeight;
            const scrolled = (window.scrollY / windowHeight) * 100;
            progressBar.style.width = scrolled + '%';
        }, 100);
        
        window.addEventListener('scroll', updateProgress, { passive: true });
    }
    
    // ===== スクロール深度トラッキング =====
    function initScrollTracking() {
        const scrollTracked = { 25: false, 50: false, 75: false, 100: false };
        
        // ディメンションをキャッシュ（強制リフロー削減）
        let cachedScrollHeight = 0;
        
        const recalculateScrollHeight = () => {
            cachedScrollHeight = document.documentElement.scrollHeight - window.innerHeight;
        };
        
        // 初回とリサイズ時のみ計算
        recalculateScrollHeight();
        window.addEventListener('resize', throttle(recalculateScrollHeight, 500));
        
        const trackScroll = throttle(() => {
            const scrollPercent = (window.scrollY / cachedScrollHeight) * 100;
            
            Object.keys(scrollTracked).forEach(threshold => {
                if (!scrollTracked[threshold] && scrollPercent >= threshold) {
                    scrollTracked[threshold] = true;
                    // GA4推奨形式: scroll イベント
                    sendToGA4('scroll', {
                        percent_scrolled: parseInt(threshold),
                        page_location: window.location.href,
                        page_title: document.title
                    });
                }
            });
        }, 500);
        
        window.addEventListener('scroll', trackScroll, { passive: true });
    }
    
    // ===== SNSドロップダウンメニュー（複数対応） =====
    function initSNSShareMenu() {
        const wrappers = document.querySelectorAll('.sns-share-menu-wrapper');
        if (!wrappers || wrappers.length === 0) return;
        
        const closeAll = () => {
            wrappers.forEach(wrapper => {
                wrapper.classList.remove('active');
                const toggle = wrapper.querySelector('.sns-share-menu-toggle');
                if (toggle) toggle.setAttribute('aria-expanded', 'false');
            });
        };
        
        wrappers.forEach(wrapper => {
            const toggle = wrapper.querySelector('.sns-share-menu-toggle');
            if (!toggle) return;
            
            toggle.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                const isActive = wrapper.classList.toggle('active');
                
                // 他のドロップダウンは閉じる
                wrappers.forEach(w => {
                    if (w !== wrapper) {
                        w.classList.remove('active');
                        const t = w.querySelector('.sns-share-menu-toggle');
                        if (t) t.setAttribute('aria-expanded', 'false');
                    }
                });
                
                toggle.setAttribute('aria-expanded', isActive);
            });
        });
        
        // 外側クリックで閉じる（どのwrapper外でも閉じる）
        document.addEventListener('click', (e) => {
            const clickedInside = Array.from(wrappers).some(w => w.contains(e.target));
            if (!clickedInside) closeAll();
        });
        
        // Escapeキーで閉じる（開いているものだけ）
        document.addEventListener('keydown', (e) => {
            if (e.key !== 'Escape') return;
            const active = Array.from(wrappers).find(w => w.classList.contains('active'));
            if (!active) return;
            
            active.classList.remove('active');
            const toggle = active.querySelector('.sns-share-menu-toggle');
            if (toggle) {
                toggle.setAttribute('aria-expanded', 'false');
                toggle.focus();
            }
        });
    }

    // ===== 電子書籍の言語切替（URL変更なし） =====
    function initEbooksLangSwitch() {
        const scopes = document.querySelectorAll('.ebooks-lang-scope[data-ebooks-lang]');
        if (!scopes || scopes.length === 0) return;
        
        const setCookie = (lang) => {
            const maxAge = 60 * 60 * 24 * 365; // 1 year
            const secure = window.location.protocol === 'https:' ? '; Secure' : '';
            document.cookie = `mytheme_ebooks_lang=${encodeURIComponent(lang)}; Path=/; Max-Age=${maxAge}; SameSite=Lax${secure}`;
        };

        const syncAllScopes = (lang) => {
            scopes.forEach(scope => {
                scope.setAttribute('data-ebooks-lang', lang);

                const buttons = scope.querySelectorAll('.ebooks-lang-switch__btn[data-ebooks-lang]');
                buttons.forEach(button => {
                    const isActive = button.getAttribute('data-ebooks-lang') === lang;
                    button.classList.toggle('is-active', isActive);
                    button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
                });
            });
        };

        scopes.forEach(scope => {
            const buttons = scope.querySelectorAll('.ebooks-lang-switch__btn[data-ebooks-lang]');
            if (!buttons || buttons.length === 0) return;
            
            buttons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const lang = btn.getAttribute('data-ebooks-lang');
                    if (!lang) return;
                    setCookie(lang);
                    syncAllScopes(lang);
                });
            });
        });
    }
    
    // ===== リンクトラッキング =====
    function initLinkTracking() {
        // 全リンクに個別リスナーを大量登録せず、1本の委譲リスナーで処理する
        document.addEventListener('click', function(event) {
            const target = event.target;
            if (!target) return;

            const link = target.closest('a');
            if (link) {
                const href = link.getAttribute('href') || '';
                if (href.startsWith('http') && !link.href.includes(window.location.hostname)) {
                    sendToGA4('click', {
                        link_domain: new URL(link.href).hostname,
                        link_url: link.href,
                        link_text: link.textContent.trim(),
                        outbound: true
                    });
                }

                if (link.classList.contains('work-link')) {
                    const workItem = link.closest('.work-item');
                    const projectName = workItem?.querySelector('.work-title')?.textContent || 'Unknown Project';
                    sendToGA4('select_content', {
                        content_type: 'project',
                        item_id: link.href,
                        item_name: projectName
                    });
                }

                if (link.closest('.site-nav')) {
                    sendToGA4('navigation_click', {
                        link_text: link.textContent.trim(),
                        link_url: link.href,
                        link_domain: window.location.hostname
                    });
                }
            }

            const demoButton = target.closest('.project-demo-btn');
            if (demoButton) {
                sendToGA4('demo_click', {
                    button_text: demoButton.textContent.trim(),
                    page_location: window.location.href
                });
            }
        }, { passive: true });
    }
    
    // ===== プリフェッチ =====
    function initPrefetch() {
        if (!('link' in document.createElement('link'))) return;
        const siteBody = document.querySelector('.site-body');

        // 低速回線・データ節約ではプリフェッチしない（体感速度/通信量の悪化を避ける）
        const conn = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
        if (conn) {
            if (conn.saveData) return;
            const type = conn.effectiveType || '';
            if (type === 'slow-2g' || type === '2g' || type === '3g') return;
        }
        
        const prefetched = new Set();
        const MAX_PREFETCH = 8;

        function prefetchPage(url) {
            if (!url || prefetched.has(url) || prefetched.size >= MAX_PREFETCH) return;
            const link = document.createElement('link');
            link.rel = 'prefetch';
            link.href = url;
            document.head.appendChild(link);
            prefetched.add(url);
        }

        // 内部リンクのホバーで軽くプリフェッチ（委譲）
        document.addEventListener('mouseenter', function(e) {
            const link = e.target && e.target.closest ? e.target.closest('a') : null;
            if (!link || !link.href) return;
            if (!link.href.startsWith(window.location.origin)) return;
            prefetchPage(link.href);
        }, true);

        // 内部リンククリック時（委譲）
        document.addEventListener('click', function(e) {
            const link = e.target && e.target.closest ? e.target.closest('a') : null;
            if (!link || !link.href) return;
            const isInternal =
                link.href.startsWith(window.location.origin) ||
                link.getAttribute('href')?.startsWith('/') ||
                link.getAttribute('href')?.startsWith('./') ||
                link.getAttribute('href')?.startsWith('../');

            if (isInternal && link.target !== '_blank' && !link.hasAttribute('download')) {
                if (siteBody) siteBody.classList.remove('loaded');
            }
        }, { passive: true });
    }

})();
