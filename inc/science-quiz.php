<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function mytheme_science_quiz_csv_path(): string {
    $dir = get_template_directory() . '/data/science-quiz';
    $local = $dir . '/questions.local.csv';
    if ( file_exists($local) ) {
        return $local;
    }
    return $dir . '/questions.csv';
}

function mytheme_science_quiz_unit_key($value): string {
    $value = trim((string) $value);
    $value = preg_replace('/[^\p{L}\p{N}_-]+/u', '', $value);
    return is_string($value) ? $value : '';
}

function mytheme_science_quiz_grade_label(string $grade, bool $short = false): string {
    if ( $short ) {
        $map = [
            '1' => '中1',
            '2' => '中2',
            '3' => '中3',
        ];
        return $map[$grade] ?? $grade;
    }
    $map = [
        '1' => '中学1年',
        '2' => '中学2年',
        '3' => '中学3年',
    ];
    return $map[$grade] ?? $grade;
}

function mytheme_science_quiz_unit_order(): array {
    return [
        'physics'     => '物理',
        'chemistry'   => '化学',
        'biology'     => '生物',
        'earth'       => '地学',
        'nature-tech' => '自然と科学技術',
    ];
}

function mytheme_science_quiz_parse_csv_line(string $line): array {
    if ( PHP_VERSION_ID >= 80400 ) {
        return str_getcsv($line, ',', '"', '');
    }
    return str_getcsv($line, ',', '"');
}

function mytheme_science_quiz_load_rows(): array {
    static $rows = null;
    if ( is_array($rows) ) {
        return $rows;
    }

    $path = mytheme_science_quiz_csv_path();
    $rows = [];
    if ( ! file_exists($path) || ! is_readable($path) ) {
        return $rows;
    }

    $raw = file_get_contents($path);
    if ( ! is_string($raw) || $raw === '' ) {
        return $rows;
    }
    if ( strncmp($raw, "\xEF\xBB\xBF", 3) === 0 ) {
        $raw = substr($raw, 3);
    }
    $raw = str_replace(["\r\n", "\r"], "\n", $raw);

    $header = null;
    $labels = mytheme_science_quiz_unit_order();
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
        $grade = isset($row['grade']) ? (string) $row['grade'] : '';
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

function mytheme_science_quiz_catalog(): array {
    $grades = [];
    $order = array_keys(mytheme_science_quiz_unit_order());
    foreach ( mytheme_science_quiz_load_rows() as $row ) {
        $grade = (string) $row['grade'];
        $unit = (string) $row['unit'];
        if ( ! isset($grades[$grade]) ) {
            $grades[$grade] = [
                'id'    => $grade,
                'label' => mytheme_science_quiz_grade_label($grade),
                'short' => mytheme_science_quiz_grade_label($grade, true),
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
    ksort($grades);
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

function mytheme_science_quiz_filter_rows(string $grade, string $unit): array {
    $matched = [];
    foreach ( mytheme_science_quiz_load_rows() as $row ) {
        if ( (string) $row['grade'] === $grade && (string) $row['unit'] === $unit ) {
            $matched[] = $row;
        }
    }
    return $matched;
}

function mytheme_science_quiz_shuffle_question(array $row): array {
    $order = [0, 1, 2, 3];
    shuffle($order);
    $choices = [];
    $correct = (int) $row['answer'] - 1;
    $correct_index = 0;
    foreach ( $order as $i => $old ) {
        $choices[] = $row['choices'][$old];
        if ( $old === $correct ) {
            $correct_index = $i;
        }
    }
    return [
        'id'            => (int) $row['id'],
        'question'      => (string) $row['question'],
        'choices'       => $choices,
        'correct_index' => $correct_index,
        'unit_label'    => (string) $row['unit_label'],
        'grade'         => (string) $row['grade'],
    ];
}

function mytheme_science_quiz_public_question(array $prepared, int $index, int $total): array {
    return [
        'index'      => $index,
        'total'      => $total,
        'question'   => $prepared['question'],
        'choices'    => $prepared['choices'],
        'unit_label' => $prepared['unit_label'],
        'grade_label'=> mytheme_science_quiz_grade_label((string) $prepared['grade']),
    ];
}

function mytheme_science_quiz_session_key(string $session_id): string {
    return 'mytheme_sq_' . md5($session_id);
}

function mytheme_ensure_science_quiz_page(): void {
    if ( get_option('mytheme_science_quiz_page_ready') === '1' ) {
        return;
    }
    $existing = get_page_by_path('science-quiz');
    if ( ! $existing ) {
        $page_id = wp_insert_post([
            'post_title'   => '中学理科クイズ',
            'post_name'    => 'science-quiz',
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_content' => '',
        ]);
        if ( is_wp_error($page_id) ) {
            return;
        }
    }
    update_option('mytheme_science_quiz_page_ready', '1', false);
}
add_action('init', 'mytheme_ensure_science_quiz_page', 30);

function mytheme_science_quiz_register_rest(): void {
    register_rest_route('mytheme/v1', '/science-quiz/catalog', [
        'methods'             => 'GET',
        'permission_callback' => '__return_true',
        'callback'            => static function() {
            return rest_ensure_response(mytheme_science_quiz_catalog());
        },
    ]);

    register_rest_route('mytheme/v1', '/science-quiz/start', [
        'methods'             => 'POST',
        'permission_callback' => '__return_true',
        'callback'            => 'mytheme_science_quiz_rest_start',
    ]);

    register_rest_route('mytheme/v1', '/science-quiz/answer', [
        'methods'             => 'POST',
        'permission_callback' => '__return_true',
        'callback'            => 'mytheme_science_quiz_rest_answer',
    ]);
}
add_action('rest_api_init', 'mytheme_science_quiz_register_rest');

function mytheme_science_quiz_rest_start(WP_REST_Request $request) {
    $grade = sanitize_text_field((string) $request->get_param('grade'));
    $unit = mytheme_science_quiz_unit_key((string) $request->get_param('unit'));
    $count = (int) $request->get_param('count');
    if ( $grade === '' || $unit === '' ) {
        return new WP_Error('mytheme_sq_invalid', '学年と分野を選んでください。', ['status' => 400]);
    }

    $pool = mytheme_science_quiz_filter_rows($grade, $unit);
    if ( empty($pool) ) {
        return new WP_Error('mytheme_sq_empty', 'この分野の問題がまだありません。', ['status' => 404]);
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
    set_transient(mytheme_science_quiz_session_key($session_id), [
        'items' => $prepared,
        'index' => 0,
        'score' => 0,
        'log'   => [],
        'grade' => $grade,
        'unit'  => $unit,
    ], HOUR_IN_SECONDS);

    $first = $prepared[0];
    return rest_ensure_response([
        'session' => $session_id,
        'total'   => count($prepared),
        'question'=> mytheme_science_quiz_public_question($first, 1, count($prepared)),
    ]);
}

function mytheme_science_quiz_rest_answer(WP_REST_Request $request) {
    $session_id = sanitize_text_field((string) $request->get_param('session'));
    $choice = (int) $request->get_param('choice');
    if ( $session_id === '' ) {
        return new WP_Error('mytheme_sq_session', 'セッションが切れました。最初からやり直してください。', ['status' => 400]);
    }

    $key = mytheme_science_quiz_session_key($session_id);
    $session = get_transient($key);
    if ( ! is_array($session) || empty($session['items']) ) {
        return new WP_Error('mytheme_sq_session', 'セッションが切れました。最初からやり直してください。', ['status' => 400]);
    }

    $index = (int) $session['index'];
    $items = $session['items'];
    if ( ! isset($items[$index]) ) {
        return new WP_Error('mytheme_sq_done', 'この回は終了しています。', ['status' => 400]);
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
    $session['log'][] = [
        'question' => (string) $current['question'],
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
        $payload['next'] = mytheme_science_quiz_public_question($items[$next_index], $next_index + 1, $total);
    }
    if ( $finished ) {
        $payload['review'] = $session['log'];
        delete_transient($key);
    }
    return rest_ensure_response($payload);
}

function mytheme_science_quiz_body_class(array $classes): array {
    if ( is_page('science-quiz') ) {
        $classes[] = 'science-quiz-app';
    }
    return $classes;
}
add_filter('body_class', 'mytheme_science_quiz_body_class');
