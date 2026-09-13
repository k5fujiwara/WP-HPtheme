(function () {
  const root = document.querySelector('[data-subject-quiz], [data-science-quiz]');
  if (!root) return;
  const cfg = window.mythemeQuiz || window.mythemeScienceQuiz;
  if (!cfg) return;
  const setupEl = root.querySelector('[data-sq-setup]');
  const playEl = root.querySelector('[data-sq-play]');
  const resultEl = root.querySelector('[data-sq-result]');
  const gradesEl = root.querySelector('[data-sq-grades]');
  const unitsEl = root.querySelector('[data-sq-units]');
  const countsEl = root.querySelector('[data-sq-counts]');
  const hintEl = root.querySelector('[data-sq-pool-hint]');
  const startBtn = root.querySelector('[data-sq-start]');
  const questionEl = root.querySelector('[data-sq-question]');
  const choicesEl = root.querySelector('[data-sq-choices]');
  const progressEl = root.querySelector('[data-sq-progress]');
  const contextEl = root.querySelector('[data-sq-context]');
  const feedbackEl = root.querySelector('[data-sq-feedback]');
  const stampEl = root.querySelector('[data-sq-stamp]');
  const nextBtn = root.querySelector('[data-sq-next]');
  const scoreEl = root.querySelector('[data-sq-score]');
  const reviewEl = root.querySelector('[data-sq-review]');
  const retryBtn = root.querySelector('[data-sq-retry]');
  const againBtn = document.querySelector('[data-sq-again]');
  const marks = ['ア', 'イ', 'ウ', 'エ'];
  const waitEl = document.createElement('div');
  waitEl.className = 'sq-wait';
  waitEl.hidden = true;
  waitEl.setAttribute('role', 'status');
  waitEl.setAttribute('aria-live', 'polite');
  waitEl.innerHTML = '<span class="sq-wait__spin" aria-hidden="true"></span><span class="sq-wait__label"></span>';
  const waitLabel = waitEl.querySelector('.sq-wait__label');

  const state = {
    catalog: null,
    grade: '',
    unit: '',
    count: 10,
    session: '',
    waiting: false,
    finishedCurrent: false,
  };

  function adBoxVisible(box) {
    if (!box || box.hidden) return false;
    var style = window.getComputedStyle(box);
    if (style.display === 'none' || style.visibility === 'hidden') return false;
    return box.getBoundingClientRect().width > 0;
  }

  function markFilledAds() {
    document.querySelectorAll('[data-sq-ad]').forEach(function (box) {
      var iframe = box.querySelector('iframe');
      var filled = !!(iframe && iframe.offsetHeight > 40);
      box.classList.toggle('is-filled', filled);
    });
    var bottom = root.querySelector('.sq-ad--bottom');
    root.classList.toggle('has-bottom-ad', !!(bottom && bottom.classList.contains('is-filled')));
  }

  function requestAd() {
    document.querySelectorAll('[data-sq-ad]').forEach(function (box) {
      var ins = box.querySelector('ins.adsbygoogle');
      if (!adBoxVisible(box)) {
        if (ins && !ins.getAttribute('data-adsbygoogle-status')) ins.remove();
        return;
      }
      if (!ins) {
        ins = document.createElement('ins');
        ins.className = 'adsbygoogle';
        ins.style.display = 'block';
        ins.setAttribute('data-ad-client', 'ca-pub-6924336257757707');
        if (box.classList.contains('sq-ad--rail')) {
          ins.setAttribute('data-ad-format', 'vertical');
          ins.setAttribute('data-full-width-responsive', 'false');
        } else {
          ins.setAttribute('data-ad-format', 'horizontal');
          ins.setAttribute('data-full-width-responsive', 'true');
        }
        box.appendChild(ins);
      }
      if (ins.getAttribute('data-adsbygoogle-status')) return;
      try {
        (window.adsbygoogle = window.adsbygoogle || []).push({});
      } catch (e) {}
    });
    [400, 1200, 3000, 6000].forEach(function (ms) {
      setTimeout(markFilledAds, ms);
    });
  }

  function activePanel() {
    if (!playEl.hidden) return playEl;
    if (!resultEl.hidden) return resultEl;
    return setupEl;
  }

  function setWait(on, message) {
    [setupEl, playEl, resultEl].forEach(function (panel) {
      panel.classList.remove('is-waiting');
    });
    if (!on) {
      waitEl.hidden = true;
      return;
    }
    waitLabel.textContent = message || '準備しています…';
    const panel = activePanel();
    panel.classList.add('is-waiting');
    panel.appendChild(waitEl);
    waitEl.hidden = false;
  }

  function show(el) {
    setupEl.hidden = el !== setupEl;
    playEl.hidden = el !== playEl;
    resultEl.hidden = el !== resultEl;
    root.classList.toggle('is-busy', el !== setupEl);
    if (againBtn) {
      againBtn.hidden = el === setupEl;
      againBtn.textContent = el === resultEl ? 'もう一度' : '選びなおす';
    }
  }

  function resetToSetup(confirmIfPlaying) {
    if (confirmIfPlaying && !playEl.hidden) {
      if (!window.confirm('選択画面に戻ります。今までの解答は消えます。よろしいですか？')) {
        return;
      }
    }
    state.session = '';
    state.waiting = false;
    state.finishedCurrent = false;
    hideStamp();
    setNextReady(false);
    setWait(false);
    if (reviewEl) reviewEl.innerHTML = '';
    show(setupEl);
    syncStart();
    window.scrollTo(0, 0);
  }

  function chip(label, value, selected, disabled) {
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'sq-chip' + (selected ? ' is-on' : '');
    btn.textContent = label;
    btn.disabled = !!disabled;
    btn.dataset.value = value;
    return btn;
  }

  function currentGrade() {
    return (state.catalog && state.catalog.grades || []).find(function (g) {
      return g.id === state.grade;
    }) || null;
  }

  function currentUnit() {
    const grade = currentGrade();
    if (!grade) return null;
    return (grade.units || []).find(function (u) {
      return u.slug === state.unit;
    }) || null;
  }

  function renderCounts() {
    countsEl.innerHTML = '';
    const unit = currentUnit();
    const max = unit ? Math.min(20, unit.count) : 0;
    const options = (state.catalog && state.catalog.counts) || [5, 10, 15, 20];
    if (unit) {
      const allowed = options.filter(function (n) { return n <= max; });
      if (allowed.indexOf(state.count) === -1) {
        state.count = allowed.length ? allowed[allowed.length - 1] : max;
      }
    }
    options.forEach(function (n) {
      const disabled = !unit || n > max;
      const selected = !disabled && n === state.count;
      const btn = chip(String(n) + '問', String(n), selected, disabled);
      btn.addEventListener('click', function () {
        state.count = n;
        renderCounts();
        syncStart();
      });
      countsEl.appendChild(btn);
    });
    hintEl.textContent = '';
  }

  function renderUnits() {
    unitsEl.innerHTML = '';
    const grade = currentGrade();
    if (!grade) {
      state.unit = '';
      renderCounts();
      syncStart();
      return;
    }
    if (!grade.units.some(function (u) { return u.slug === state.unit; })) {
      state.unit = grade.units[0] ? grade.units[0].slug : '';
    }
    grade.units.forEach(function (unit, i) {
      const btn = chip(unit.label, unit.slug, unit.slug === state.unit, false);
      if (i >= 4) btn.classList.add('sq-chip--span');
      btn.addEventListener('click', function () {
        state.unit = unit.slug;
        renderUnits();
      });
      unitsEl.appendChild(btn);
    });
    if (grade.units.length < 5 && cfg.unitSpacer !== false) {
      const spacer = document.createElement('span');
      spacer.className = 'sq-chip-spacer';
      spacer.setAttribute('aria-hidden', 'true');
      unitsEl.appendChild(spacer);
    }
    renderCounts();
    syncStart();
  }

  function renderGrades() {
    gradesEl.innerHTML = '';
    (state.catalog.grades || []).forEach(function (grade) {
      const btn = chip(grade.short || grade.label, grade.id, grade.id === state.grade, false);
      btn.addEventListener('click', function () {
        state.grade = grade.id;
        state.unit = '';
        renderGrades();
        renderUnits();
      });
      gradesEl.appendChild(btn);
    });
  }

  function syncStart() {
    startBtn.disabled = !(state.grade && state.unit && state.count > 0) || state.waiting;
  }

  const soundOk = cfg.sounds && cfg.sounds.ok ? new Audio(cfg.sounds.ok) : null;
  const soundNg = cfg.sounds && cfg.sounds.ng ? new Audio(cfg.sounds.ng) : null;
  [soundOk, soundNg].forEach(function (audio) {
    if (!audio) return;
    audio.preload = 'auto';
    audio.volume = 0.9;
  });

  function playJudgeSound(ok) {
    const audio = ok ? soundOk : soundNg;
    if (!audio) return;
    try {
      audio.pause();
      audio.currentTime = 0;
      const playing = audio.play();
      if (playing && typeof playing.catch === 'function') {
        playing.catch(function () {});
      }
    } catch (e) {}
  }

  function hideStamp() {
    stampEl.hidden = true;
    stampEl.className = 'sq-stamp';
    stampEl.textContent = '';
  }

  function showStamp(ok) {
    stampEl.hidden = false;
    stampEl.textContent = ok ? '○' : '✕';
    stampEl.className = 'sq-stamp ' + (ok ? 'is-ok' : 'is-ng');
    void stampEl.offsetWidth;
    stampEl.classList.add('is-show');
  }

  function setNextReady(ready, label) {
    nextBtn.textContent = label || '次の問題へ';
    nextBtn.disabled = !ready;
  }

  function scrollQuizTop() {
    window.scrollTo(0, 0);
    document.documentElement.scrollTop = 0;
    document.body.scrollTop = 0;
  }

  function request(path, body) {
    const options = {
      method: body ? 'POST' : 'GET',
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': cfg.nonce || '',
      },
    };
    if (body) options.body = JSON.stringify(body);
    return fetch(cfg.rest + path, options).then(function (res) {
      return res.json().then(function (data) {
        if (!res.ok) {
          throw new Error(data.message || '通信に失敗しました。');
        }
        return data;
      });
    });
  }

  function paintReview(items, score, total) {
    scoreEl.textContent = score + ' / ' + total;
    scoreEl.classList.remove('is-write');
    void scoreEl.offsetWidth;
    scoreEl.classList.add('is-write');
    reviewEl.innerHTML = '';
    (items || []).forEach(function (item, n) {
      const article = document.createElement('article');
      article.className = 'sq-review-item';

      const status = document.createElement('p');
      status.className = 'sq-review-status' + (item.ok ? ' is-ok' : ' is-ng');
      status.textContent = item.ok ? '正解' : '不正解';

      const q = document.createElement('p');
      q.className = 'sq-review-q';
      if (item.prompt) {
        q.appendChild(document.createTextNode((n + 1) + '. ' + item.prompt));
        const meaning = document.createElement('span');
        meaning.className = 'sq-review-meaning';
        meaning.textContent = item.question;
        q.appendChild(meaning);
      } else {
        q.textContent = (n + 1) + '. ' + item.question;
      }

      const list = document.createElement('ul');
      list.className = 'sq-review-choices';
      (item.choices || []).forEach(function (text, i) {
        const li = document.createElement('li');
        const tags = [];
        if (i === item.selected) tags.push('選択');
        if (i === item.correct) tags.push('正解');
        li.textContent = (marks[i] || '') + ' ' + text + (tags.length ? '（' + tags.join('・') + '）' : '');
        if (i === item.correct) li.classList.add('is-correct');
        if (i === item.selected && !item.ok) li.classList.add('is-wrong');
        list.appendChild(li);
      });

      article.appendChild(status);
      article.appendChild(q);
      article.appendChild(list);
      reviewEl.appendChild(article);
    });
  }

  function paintQuestion(q) {
    state.finishedCurrent = false;
    progressEl.textContent = q.index + ' / ' + q.total;
    contextEl.textContent = [q.grade_label, q.unit_label].filter(Boolean).join('　');
    questionEl.textContent = '';
    if (q.prompt) {
      const prompt = document.createElement('span');
      prompt.className = 'sq-question-prompt';
      prompt.textContent = q.prompt;
      const meaning = document.createElement('span');
      meaning.className = 'sq-question-meaning';
      meaning.textContent = q.question;
      questionEl.appendChild(prompt);
      questionEl.appendChild(meaning);
    } else {
      questionEl.textContent = q.question;
    }
    feedbackEl.textContent = '';
    hideStamp();
    setNextReady(false, '次の問題へ');
    nextBtn.onclick = null;
    choicesEl.innerHTML = '';
    q.choices.forEach(function (text, i) {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'sq-choice';
      btn.dataset.index = String(i);

      const mark = document.createElement('span');
      mark.className = 'sq-choice-mark';
      mark.textContent = marks[i] || String(i + 1);

      const body = document.createElement('span');
      body.className = 'sq-choice-text';
      body.textContent = text;

      btn.appendChild(mark);
      btn.appendChild(body);
      btn.addEventListener('click', function () {
        submitAnswer(i, btn);
      });
      choicesEl.appendChild(btn);
    });
  }

  function submitAnswer(choice, clicked) {
    if (state.waiting || state.finishedCurrent) return;
    state.waiting = true;
    setWait(true, '判定しています…');
    Array.prototype.forEach.call(choicesEl.querySelectorAll('button'), function (btn) {
      btn.disabled = true;
    });
    request('answer', { session: state.session, choice: choice })
      .then(function (data) {
        setWait(false);
        state.finishedCurrent = true;
        Array.prototype.forEach.call(choicesEl.querySelectorAll('button'), function (btn, i) {
          if (i === data.correct_index) btn.classList.add('is-correct');
          if (btn === clicked && !data.correct) btn.classList.add('is-wrong');
        });
        showStamp(!!data.correct);
        playJudgeSound(!!data.correct);
        feedbackEl.textContent = data.correct ? '正解' : '不正解';
        if (data.finished) {
          setNextReady(true, '結果');
          nextBtn.onclick = function () {
            paintReview(data.review, data.score, data.total);
            show(resultEl);
            scrollQuizTop();
          };
        } else {
          setNextReady(true, '次の問題へ');
          nextBtn.onclick = function () {
            paintQuestion(data.next);
            scrollQuizTop();
          };
        }
      })
      .catch(function (err) {
        setWait(false);
        feedbackEl.textContent = err.message;
        hintEl.textContent = err.message;
        Array.prototype.forEach.call(choicesEl.querySelectorAll('button'), function (btn) {
          btn.disabled = false;
        });
      })
      .then(function () {
        state.waiting = false;
      });
  }

  startBtn.addEventListener('click', function () {
    if (startBtn.disabled || state.waiting) return;
    state.waiting = true;
    startBtn.disabled = true;
    startBtn.textContent = '出題を用意しています…';
    setWait(true, '出題を用意しています…');
    [soundOk, soundNg].forEach(function (audio) {
      if (audio) audio.load();
    });
    request('start', {
      grade: state.grade,
      unit: state.unit,
      count: state.count,
    })
      .then(function (data) {
        state.session = data.session;
        if (reviewEl) reviewEl.innerHTML = '';
        setWait(false);
        show(playEl);
        paintQuestion(data.question);
      })
      .catch(function (err) {
        setWait(false);
        hintEl.textContent = err.message;
      })
      .then(function () {
        state.waiting = false;
        startBtn.textContent = 'クイズを始める';
        syncStart();
      });
  });

  if (retryBtn) {
    retryBtn.addEventListener('click', function () {
      resetToSetup(false);
    });
  }
  if (againBtn) {
    againBtn.addEventListener('click', function () {
      resetToSetup(!playEl.hidden);
    });
  }

  hintEl.textContent = '';
  setWait(true, '問題を読み込んでいます…');
  request('catalog')
    .then(function (data) {
      setWait(false);
      state.catalog = data;
      if (data.grades && data.grades[0]) {
        state.grade = data.grades[0].id;
      }
      var gradeField = root.querySelector('[data-sq-grade-field]');
      if (gradeField && (data.grades || []).length <= 1) {
        gradeField.hidden = true;
      }
      renderGrades();
      renderUnits();
      requestAd();
    })
    .catch(function () {
      setWait(false);
      hintEl.textContent = '問題データを読み込めませんでした。';
    });

  document.addEventListener('mytheme-adsense-ready', requestAd);
  var adResizeTimer = 0;
  window.addEventListener('resize', function () {
    clearTimeout(adResizeTimer);
    adResizeTimer = setTimeout(requestAd, 400);
  });
})();
