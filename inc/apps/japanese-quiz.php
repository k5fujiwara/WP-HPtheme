<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function mytheme_japanese_quiz_csv_path(): string {
    $dir = get_template_directory() . '/data/japanese-quiz';
    $candidates = [
        $dir . '/questions.local.php',
        $dir . '/questions.local.csv',
        $dir . '/questions.php',
        $dir . '/questions.csv',
    ];
    foreach ( $candidates as $path ) {
        if ( file_exists($path) ) {
            return $path;
        }
    }
    return $dir . '/questions.php';
}

function mytheme_japanese_quiz_unit_order(): array {
    return [
        'kotowaza' => 'ことわざ',
        'idiom'    => '慣用句',
        'yoji'     => '四字熟語',
    ];
}

function mytheme_japanese_quiz_grade_label(string $grade, bool $short = false): string {
    if ( $grade === 'all' ) {
        return $short ? '国語' : '中学国語';
    }
    return function_exists('mytheme_science_quiz_grade_label')
        ? mytheme_science_quiz_grade_label($grade, $short)
        : $grade;
}

function mytheme_japanese_quiz_load_rows(): array {
    static $rows = null;
    if ( is_array($rows) ) {
        return $rows;
    }

    $rows = [];
    $path = mytheme_japanese_quiz_csv_path();
    if ( ! file_exists($path) || ! is_readable($path) || ! function_exists('mytheme_science_quiz_read_source') ) {
        return $rows;
    }

    $raw = mytheme_science_quiz_read_source($path);
    if ( $raw === '' ) {
        return $rows;
    }
    $raw = str_replace(["\r\n", "\r"], "\n", $raw);
    $header = null;
    $labels = mytheme_japanese_quiz_unit_order();
    foreach ( explode("\n", $raw) as $line ) {
        if ( $line === '' ) {
            continue;
        }
        $data = mytheme_science_quiz_parse_csv_line($line);
        if ( ! is_array($data) || $data === [null] ) {
            continue;
        }
        if ( $header === null ) {
            $header = array_map(static function($col) {
                return trim((string) $col);
            }, $data);
            continue;
        }
        if ( count($data) < count($header) ) {
            continue;
        }
        $row = array_combine($header, array_slice($data, 0, count($header)));
        if ( ! is_array($row) ) {
            continue;
        }
        $id = isset($row['id']) ? (int) $row['id'] : 0;
        $grade = isset($row['grade']) ? (string) $row['grade'] : 'all';
        $unit = isset($row['unit']) ? mytheme_science_quiz_unit_key($row['unit']) : '';
        $question = isset($row['question']) ? trim((string) $row['question']) : '';
        $answer = isset($row['answer']) ? (int) $row['answer'] : 0;
        if ( $id <= 0 || $grade === '' || $unit === '' || $question === '' || $answer < 1 || $answer > 4 ) {
            continue;
        }
        $choices = [];
        for ( $i = 1; $i <= 4; $i++ ) {
            $choices[] = isset($row['choice' . $i]) ? trim((string) $row['choice' . $i]) : '';
        }
        if ( in_array('', $choices, true) ) {
            continue;
        }
        $rows[] = [
            'id'         => $id,
            'grade'      => $grade,
            'unit'       => $unit,
            'unit_label' => $labels[$unit]
                ?? (isset($row['unit_label']) && trim((string) $row['unit_label']) !== ''
                    ? trim((string) $row['unit_label'])
                    : $unit),
            'question'   => $question,
            'choices'    => $choices,
            'answer'     => $answer,
        ];
    }
    return $rows;
}

function mytheme_japanese_quiz_catalog(): array {
    $grades = [];
    $order = array_keys(mytheme_japanese_quiz_unit_order());
    foreach ( mytheme_japanese_quiz_load_rows() as $row ) {
        $grade = (string) $row['grade'];
        $unit = (string) $row['unit'];
        if ( ! isset($grades[$grade]) ) {
            $grades[$grade] = [
                'id'    => $grade,
                'label' => mytheme_japanese_quiz_grade_label($grade),
                'short' => mytheme_japanese_quiz_grade_label($grade, true),
                'units' => [],
            ];
        }
        if ( ! isset($grades[$grade]['units'][$unit]) ) {
            $grades[$grade]['units'][$unit] = [
                'slug'  => $unit,
                'label' => (string) $row['unit_label'],
                'count' => 0,
            ];
        }
        $grades[$grade]['units'][$unit]['count']++;
    }

    $out = [];
    foreach ( $grades as $grade ) {
        $sorted = [];
        foreach ( $order as $slug ) {
            if ( isset($grade['units'][$slug]) ) {
                $sorted[] = $grade['units'][$slug];
                unset($grade['units'][$slug]);
            }
        }
        foreach ( $grade['units'] as $unit ) {
            $sorted[] = $unit;
        }
        $grade['units'] = $sorted;
        $out[] = $grade;
    }

    return [
        'grades' => $out,
        'counts' => [5, 10, 15, 20],
    ];
}

function mytheme_japanese_quiz_filter_rows(string $grade, string $unit): array {
    $matched = [];
    foreach ( mytheme_japanese_quiz_load_rows() as $row ) {
        if ( (string) $row['grade'] === $grade && (string) $row['unit'] === $unit ) {
            $matched[] = $row;
        }
    }
    return $matched;
}

function mytheme_japanese_quiz_stem(string $unit): string {
    $map = [
        'kotowaza' => '次の意味に当てはまることわざはどれか？',
        'idiom'    => '次の意味に当てはまる慣用句はどれか？',
        'yoji'     => '次の意味に当てはまる四字熟語はどれか？',
    ];
    return $map[$unit] ?? '';
}

function mytheme_japanese_quiz_clean_meaning(string $text): string {
    $text = trim($text);
    $text = preg_replace('/^(次の説明に最も合うもの|この意味に当てはまるもの|次のような意味・場面を表すもの|説明に合う表現を選ぶ|次の意味に当てはまるもの)[:：]/u', '', $text);
    $text = is_string($text) ? trim($text) : '';
    $text = preg_replace('/という(?:意味|教え・考え方)$/u', '', $text);
    return is_string($text) ? trim($text) : '';
}

function mytheme_japanese_quiz_public_question(array $prepared, int $index, int $total): array {
    $unit = (string) ($prepared['unit'] ?? '');
    return [
        'index'       => $index,
        'total'       => $total,
        'prompt'      => mytheme_japanese_quiz_stem($unit),
        'question'    => mytheme_japanese_quiz_clean_meaning((string) $prepared['question']),
        'choices'     => $prepared['choices'],
        'unit_label'  => $prepared['unit_label'],
        'grade_label' => mytheme_japanese_quiz_grade_label((string) $prepared['grade']),
    ];
}

function mytheme_japanese_quiz_session_key(string $session_id): string {
    return 'mytheme_jq_' . md5($session_id);
}

function mytheme_ensure_japanese_quiz_page(): void {
    if ( get_option('mytheme_japanese_quiz_page_ready') === '1' ) {
        return;
    }
    $existing = get_page_by_path('japanese-quiz');
    if ( ! $existing ) {
        $page_id = wp_insert_post([
            'post_title'   => '中学国語クイズ',
            'post_name'    => 'japanese-quiz',
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_content' => '',
        ]);
        if ( is_wp_error($page_id) ) {
            return;
        }
    }
    update_option('mytheme_japanese_quiz_page_ready', '1', false);
}
add_action('init', 'mytheme_ensure_japanese_quiz_page', 30);

function mytheme_japanese_quiz_register_rest(): void {
    register_rest_route('mytheme/v1', '/japanese-quiz/catalog', [
        'methods'             => 'GET',
        'permission_callback' => '__return_true',
        'callback'            => static function() {
            return rest_ensure_response(mytheme_japanese_quiz_catalog());
        },
    ]);

    register_rest_route('mytheme/v1', '/japanese-quiz/start', [
        'methods'             => 'POST',
        'permission_callback' => '__return_true',
        'callback'            => 'mytheme_japanese_quiz_rest_start',
    ]);

    register_rest_route('mytheme/v1', '/japanese-quiz/answer', [
        'methods'             => 'POST',
        'permission_callback' => '__return_true',
        'callback'            => 'mytheme_japanese_quiz_rest_answer',
    ]);
}
add_action('rest_api_init', 'mytheme_japanese_quiz_register_rest');

function mytheme_japanese_quiz_rest_start(WP_REST_Request $request) {
    $grade = sanitize_text_field((string) $request->get_param('grade'));
    $unit = mytheme_science_quiz_unit_key((string) $request->get_param('unit'));
    $count = (int) $request->get_param('count');
    if ( $grade === '' || $unit === '' ) {
        return new WP_Error('mytheme_jq_invalid', '分野を選んでください。', ['status' => 400]);
    }

    $pool = mytheme_japanese_quiz_filter_rows($grade, $unit);
    if ( empty($pool) ) {
        return new WP_Error('mytheme_jq_empty', 'この分野の問題がまだありません。', ['status' => 404]);
    }

    $available = count($pool);
    if ( $count < 1 ) {
        $count = 10;
    }
    $count = min($count, $available, 20);

    shuffle($pool);
    $selected = array_slice($pool, 0, $count);
    $prepared = [];
    foreach ( $selected as $row ) {
        $prepared[] = mytheme_science_quiz_shuffle_question($row);
    }

    $session_id = wp_generate_uuid4();
    set_transient(mytheme_japanese_quiz_session_key($session_id), [
        'items' => $prepared,
        'index' => 0,
        'score' => 0,
        'log'   => [],
        'grade' => $grade,
        'unit'  => $unit,
    ], HOUR_IN_SECONDS);

    $first = $prepared[0];
    return rest_ensure_response([
        'session'  => $session_id,
        'total'    => count($prepared),
        'question' => mytheme_japanese_quiz_public_question($first, 1, count($prepared)),
    ]);
}

function mytheme_japanese_quiz_rest_answer(WP_REST_Request $request) {
    $session_id = sanitize_text_field((string) $request->get_param('session'));
    $choice = (int) $request->get_param('choice');
    if ( $session_id === '' ) {
        return new WP_Error('mytheme_jq_session', 'セッションが切れました。最初からやり直してください。', ['status' => 400]);
    }

    $key = mytheme_japanese_quiz_session_key($session_id);
    $session = get_transient($key);
    if ( ! is_array($session) || empty($session['items']) ) {
        return new WP_Error('mytheme_jq_session', 'セッションが切れました。最初からやり直してください。', ['status' => 400]);
    }

    $index = (int) $session['index'];
    $items = $session['items'];
    if ( ! isset($items[$index]) ) {
        return new WP_Error('mytheme_jq_done', 'この回は終了しています。', ['status' => 400]);
    }

    $current = $items[$index];
    $correct_index = (int) $current['correct_index'];
    $is_correct = ( $choice === $correct_index );
    if ( $is_correct ) {
        $session['score']++;
    }
    if ( ! isset($session['log']) || ! is_array($session['log']) ) {
        $session['log'] = [];
    }
    $choices = [];
    foreach ( (array) $current['choices'] as $text ) {
        $choices[] = (string) $text;
    }
    $unit = (string) ($current['unit'] ?? $session['unit'] ?? '');
    $session['log'][] = [
        'prompt'   => mytheme_japanese_quiz_stem($unit),
        'question' => mytheme_japanese_quiz_clean_meaning((string) $current['question']),
        'choices'  => $choices,
        'selected' => $choice,
        'correct'  => $correct_index,
        'ok'       => $is_correct,
    ];
    $session['index'] = $index + 1;
    set_transient($key, $session, HOUR_IN_SECONDS);

    $total = count($items);
    $next_index = (int) $session['index'];
    $finished = $next_index >= $total;
    $payload = [
        'correct'       => $is_correct,
        'correct_index' => $correct_index,
        'score'         => (int) $session['score'],
        'total'         => $total,
        'finished'      => $finished,
        'next'          => null,
        'review'        => null,
    ];
    if ( ! $finished && isset($items[$next_index]) ) {
        $payload['next'] = mytheme_japanese_quiz_public_question($items[$next_index], $next_index + 1, $total);
    }
    if ( $finished ) {
        $payload['review'] = $session['log'];
        delete_transient($key);
    }
    return rest_ensure_response($payload);
}

function mytheme_japanese_quiz_body_class(array $classes): array {
    if ( is_page('japanese-quiz') ) {
        $classes[] = 'japanese-quiz-app';
        $classes[] = 'science-quiz-app';
    }
    return $classes;
}
add_filter('body_class', 'mytheme_japanese_quiz_body_class');
