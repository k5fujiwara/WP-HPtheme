// JavaScript questions generated from the Python question set.
const JAVASCRIPT_QUESTIONS = [
  {
    "id": 141,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "基礎",
    "langMode": "javascript",
    "title": "配列の添字を使った値の取得",
    "prompt": "次のプログラムの [ ア ] に入る値として正しいものを選びなさい。（x には 10 を代入したい）",
    "code": "let data = [5, 10, 15, 20];\nlet x = data[[ ア ]];\nconsole.log(x);",
    "choices": [
      "0",
      "1",
      "2",
      "3"
    ],
    "correctIndex": 1,
    "explanation": "JavaScriptの配列は添字が【0】から始まります。<br>data[0]=5, data[1]=<strong>10</strong>, data[2]=15 …<br>10 を取り出すには添字 <strong>1</strong> が必要です。"
  },
  {
    "id": 142,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "javascript",
    "title": "変数への代入と計算",
    "prompt": "次のプログラムを実行したとき、console.log(x) の出力値を選びなさい。",
    "code": "let x = 3;\nx = x + 4;\nconsole.log(x);",
    "choices": [
      "3",
      "4",
      "7",
      "12"
    ],
    "correctIndex": 2,
    "explanation": "最初に x は 3 です。<br>x = x + 4 により、3 + 4 = <strong>7</strong> になります。"
  },
  {
    "id": 143,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "基礎",
    "langMode": "javascript",
    "title": "条件分岐の条件",
    "prompt": "score が 60 以上のときに「合格」と表示するには、[ ア ] に何を入れればよいですか。",
    "code": "let score = 75;\nif (score [ ア ] 60) {\n  console.log(\"合格\");\n}",
    "choices": [
      "<",
      ">",
      ">=",
      "=="
    ],
    "correctIndex": 2,
    "explanation": "60以上は <strong>>= 60</strong> と書きます。score は75なので条件を満たし、「合格」と表示されます。"
  },
  {
    "id": 144,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "基礎",
    "langMode": "javascript",
    "title": "表示する関数の実行回数",
    "prompt": "次のプログラムにおいて、console.log(i) は何回実行されますか。",
    "code": "for (let i = 0; i < 4; i++) {\n  console.log(i);\n}",
    "choices": [
      "3回",
      "4回",
      "5回",
      "0回"
    ],
    "correctIndex": 1,
    "explanation": "for文では i が 0, 1, 2, 3 と変化します。<br>そのため console.log(i) は <strong>4回</strong> 実行されます。"
  },
  {
    "id": 145,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "javascript",
    "title": "文字列の連結",
    "prompt": "次のプログラムを実行したとき、出力される文字列を選びなさい。",
    "code": "let a = \"情報\";\nlet b = \"I\";\nconsole.log(a + b);",
    "choices": [
      "情報I",
      "情報 I",
      "a+b",
      "I情報"
    ],
    "correctIndex": 0,
    "explanation": "文字列同士を + でつなげると、そのまま連結されます。<br>よって <strong>情報I</strong> です。"
  },
  {
    "id": 146,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "基礎",
    "langMode": "javascript",
    "title": "偶数判定の表記",
    "prompt": "変数 n が偶数のときだけ「偶数」と表示するプログラム表記として正しいものを選びなさい。",
    "code": "let n = 8;\n// n が偶数なら「偶数」と表示する",
    "choices": [
      "if (n % 2 == 0) {\n  console.log(\"偶数\");\n}",
      "if (n / 2 == 0) {\n  console.log(\"偶数\");\n}",
      "if (n % 2 == 1) {\n  console.log(\"偶数\");\n}",
      "if (n == 2) {\n  console.log(\"偶数\");\n}"
    ],
    "correctIndex": 0,
    "explanation": "偶数は 2 で割った余りが 0 の数です。<br>JavaScriptでは余りを <strong>%</strong> で求めるので、n % 2 == 0 が正解です。"
  },
  {
    "id": 147,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "javascript",
    "title": "配列要素の更新",
    "prompt": "次のプログラムを実行したとき、console.log(nums[1]) の出力値を選びなさい。",
    "code": "let nums = [2, 4, 6];\nnums[1] = nums[1] + 3;\nconsole.log(nums[1]);",
    "choices": [
      "4",
      "5",
      "7",
      "9"
    ],
    "correctIndex": 2,
    "explanation": "nums[1] は2番目の要素なので 4 です。<br>4 + 3 = <strong>7</strong> に更新されます。"
  },
  {
    "id": 148,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "基礎",
    "langMode": "javascript",
    "title": "繰り返し回数の穴埋め",
    "prompt": "「Hello」を5回表示するには、[ ア ] に何を入れればよいですか。",
    "code": "for (let i = 0; i < [ ア ]; i++) {\n  console.log(\"Hello\");\n}",
    "choices": [
      "4",
      "5",
      "6",
      "10"
    ],
    "correctIndex": 1,
    "explanation": "for文では i が 0,1,2,3,4 と変化するため、5回繰り返します。<br>よって [ ア ] は <strong>5</strong> です。"
  },
  {
    "id": 149,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "基礎",
    "langMode": "javascript",
    "title": "条件を満たす回数",
    "prompt": "次のプログラムにおいて、count += 1 は何回実行されますか。",
    "code": "let count = 0;\nfor (let i = 0; i < 5; i++) {\n  if (i >= 2) {\n    count += 1;\n  }\n}\nconsole.log(count);",
    "choices": [
      "1回",
      "2回",
      "3回",
      "5回"
    ],
    "correctIndex": 2,
    "explanation": "i は 0,1,2,3,4 と変化します。<br>i >= 2 を満たすのは 2,3,4 の <strong>3回</strong> です。"
  },
  {
    "id": 150,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "基礎",
    "langMode": "javascript",
    "title": "最大値の取り出し",
    "prompt": "配列 nums の中から最大値を表示するコードとして正しいものを選びなさい。",
    "code": "let nums = [3, 9, 1, 6];\n// 最大値を表示する",
    "choices": [
      "console.log(Math.max(...nums));",
      "console.log(Math.min(...nums));",
      "console.log(nums.length);",
      "console.log(nums[0]);"
    ],
    "correctIndex": 0,
    "explanation": "JavaScriptでは Math.max(...配列) で最大値を求められます。<br>この配列の最大値は <strong>9</strong> です。"
  },
  {
    "id": 151,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "javascript",
    "title": "for文の開始と終了",
    "prompt": "次のプログラムを実行したとき、console.log(s) の出力値を選びなさい。",
    "code": "let s = 0;\nfor (let i = 1; i < 5; i++) {\n  s = s + i;\n}\nconsole.log(s);",
    "choices": [
      "6",
      "10",
      "15",
      "5"
    ],
    "correctIndex": 1,
    "explanation": "for文では i が 1,2,3,4 と変化します。<br>合計は 1+2+3+4 = <strong>10</strong> です。"
  },
  {
    "id": 152,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "javascript",
    "title": "配列の長さ",
    "prompt": "配列 items の要素数を n に代入するには、[ ア ] に何を入れればよいですか。",
    "code": "let items = [\"A\", \"B\", \"C\"];\nlet n = [ ア ];\nconsole.log(n);",
    "choices": [
      "items.size",
      "items.length",
      "count(items)",
      "items[3]"
    ],
    "correctIndex": 1,
    "explanation": "JavaScriptで配列の要素数を求めるには <strong>配列.length</strong> を使います。"
  },
  {
    "id": 153,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "標準",
    "langMode": "javascript",
    "title": "二重ループの実行回数",
    "prompt": "次のプログラムにおいて、console.log(i, j) は何回実行されますか。",
    "code": "for (let i = 0; i < 3; i++) {\n  for (let j = 0; j < 2; j++) {\n    console.log(i, j);\n  }\n}",
    "choices": [
      "2回",
      "3回",
      "5回",
      "6回"
    ],
    "correctIndex": 3,
    "explanation": "外側が3回、内側が各回で2回実行されます。<br>合計は 3 × 2 = <strong>6回</strong> です。"
  },
  {
    "id": 154,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "標準",
    "langMode": "javascript",
    "title": "配列の合計",
    "prompt": "配列 nums の全要素の合計を total に求めるコードとして正しいものを選びなさい。",
    "code": "let nums = [1, 2, 3, 4];\n// total に合計を入れる",
    "choices": [
      "let total = 0;\nfor (const n of nums) {\n  total += n;\n}",
      "let total = 1;\nfor (const n of nums) {\n  total *= n;\n}",
      "total = nums.length",
      "total = nums[0]"
    ],
    "correctIndex": 0,
    "explanation": "合計は初期値0から各要素を足していきます。<br>total += n は total = total + n と同じ意味です。"
  },
  {
    "id": 155,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "javascript",
    "title": "条件分岐の実行結果",
    "prompt": "次のプログラムを実行したとき、出力される文字列を選びなさい。",
    "code": "let x = 7;\nif (x % 3 == 1) {\n  console.log(\"A\");\n}\nelse {\n  console.log(\"B\");\n}",
    "choices": [
      "A",
      "B",
      "AB",
      "何も表示されない"
    ],
    "correctIndex": 0,
    "explanation": "7を3で割った余りは1です。<br>条件 x % 3 == 1 が真なので <strong>A</strong> が表示されます。"
  },
  {
    "id": 156,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "javascript",
    "title": "while文の条件",
    "prompt": "n が 1 になるまで半分にし続けるには、[ ア ] に何を入れればよいですか。",
    "code": "let n = 16;\nwhile (n [ ア ] 1) {\n  n = Math.floor(n / 2);\n}\nconsole.log(n);",
    "choices": [
      ">",
      ">=",
      "<",
      "=="
    ],
    "correctIndex": 0,
    "explanation": "n が 1 より大きい間だけ繰り返せば、16→8→4→2→1 で止まります。<br>条件は <strong>n > 1</strong> です。"
  },
  {
    "id": 157,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "javascript",
    "title": "配列を順に調べる",
    "prompt": "次のプログラムを実行したとき、console.log(count) の出力値を選びなさい。",
    "code": "let nums = [5, 2, 8, 1, 7];\nlet count = 0;\nfor (const n of nums) {\n  if (n >= 5) {\n    count += 1;\n  }\n}\nconsole.log(count);",
    "choices": [
      "2",
      "3",
      "4",
      "5"
    ],
    "correctIndex": 1,
    "explanation": "5以上の値は 5, 8, 7 の3つです。<br>よって count は <strong>3</strong> になります。"
  },
  {
    "id": 158,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "標準",
    "langMode": "javascript",
    "title": "平均値の計算",
    "prompt": "配列 scores の平均値を avg に求めるコードとして正しいものを選びなさい。",
    "code": "let scores = [60, 80, 100];\n// avg に平均値を入れる",
    "choices": [
      "avg = scores.reduce((a, b) => a + b, 0) / scores.length",
      "avg = scores.length / scores.reduce((a, b) => a + b, 0)",
      "avg = Math.max(...scores) / scores.length",
      "avg = scores[0] + scores[1] + scores[2]"
    ],
    "correctIndex": 0,
    "explanation": "平均値は「合計 ÷ 個数」です。<br>JavaScriptでは scores.reduce((a, b) => a + b, 0) / scores.length と書けます。"
  },
  {
    "id": 159,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "標準",
    "langMode": "javascript",
    "title": "breakまでの回数",
    "prompt": "次のプログラムにおいて、if (n == 4) の行は何回判定されますか。",
    "code": "let nums = [1, 3, 4, 6];\nfor (const n of nums) {\n  if (n == 4) {\n    break;\n  }\n}",
    "choices": [
      "1回",
      "2回",
      "3回",
      "4回"
    ],
    "correctIndex": 2,
    "explanation": "n は 1, 3, 4 の順に調べられます。<br>4で break するため、if の判定は <strong>3回</strong> です。"
  },
  {
    "id": 160,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "javascript",
    "title": "奇数だけを数える",
    "prompt": "奇数だけ count するには、[ ア ] に何を入れればよいですか。",
    "code": "let nums = [1, 2, 3, 4, 5];\nlet count = 0;\nfor (const n of nums) {\n  if ([ ア ]) {\n    count += 1;\n  }\n}\nconsole.log(count);",
    "choices": [
      "n % 2 == 0",
      "n % 2 == 1",
      "Math.floor(n / 2 )== 1",
      "n == 2"
    ],
    "correctIndex": 1,
    "explanation": "奇数は2で割った余りが1です。<br>条件は <strong>n % 2 == 1</strong> です。"
  },
  {
    "id": 161,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "累積和配列",
    "prompt": "次のプログラムを実行したとき、console.log(ans) の出力を選びなさい。",
    "code": "let nums = [2, 1, 3];\nlet ans = [];\nlet s = 0;\nfor (const n of nums) {\n  s += n;\n  ans.push(s)\n}\nconsole.log(ans);",
    "choices": [
      "[2, 1, 3]",
      "[2, 3, 6]",
      "[0, 2, 3]",
      "[6]"
    ],
    "correctIndex": 1,
    "explanation": "s は 2 → 3 → 6 と増え、その都度 ans に追加されます。<br>結果は <strong>[2, 3, 6]</strong> です。"
  },
  {
    "id": 162,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "最大値の更新条件",
    "prompt": "配列の最大値を mx に求めるには、[ ア ] に何を入れればよいですか。",
    "code": "let nums = [4, 9, 2, 7];\nlet mx = nums[0];\nfor (const n of nums) {\n  if ([ ア ]) {\n    mx = n;\n  }\n}\nconsole.log(mx);",
    "choices": [
      "n > mx",
      "n < mx",
      "n == mx",
      "mx > n"
    ],
    "correctIndex": 0,
    "explanation": "今までの最大値 mx より n が大きいときだけ更新します。<br>条件は <strong>n > mx</strong> です。"
  },
  {
    "id": 163,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "ネストしたifの実行回数",
    "prompt": "次のプログラムにおいて、count += 1 は何回実行されますか。",
    "code": "let count = 0;\nfor (let i = 1; i < 6; i++) {\n  if (i % 2 == 1) {\n    if (i >= 3) {\n      count += 1;\n    }\n  }\n}\nconsole.log(count);",
    "choices": [
      "1回",
      "2回",
      "3回",
      "5回"
    ],
    "correctIndex": 1,
    "explanation": "i は 1〜5 です。奇数かつ3以上なのは 3 と 5 の2つです。<br>よって <strong>2回</strong> 実行されます。"
  },
  {
    "id": 164,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "線形探索",
    "prompt": "配列 nums の中に target と同じ値があるかを調べるコードとして正しいものを選びなさい。",
    "code": "let nums = [3, 8, 1, 5];\nlet target = 1;\n// found に true または false を入れる",
    "choices": [
      "let found = false;\nfor (const n of nums) {\n  if (n == target) {\n    found = true;\n  }\n}",
      "let found = true;\nfor (const n of nums) {\n  if (n == target) {\n    found = false;\n  }\n}",
      "found = target",
      "found = nums[0]"
    ],
    "correctIndex": 0,
    "explanation": "最初は見つかっていないので false にし、target と同じ要素を見つけたら true にします。"
  },
  {
    "id": 165,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "二重ループと合計",
    "prompt": "次のプログラムを実行したとき、console.log(total) の出力値を選びなさい。",
    "code": "let total = 0;\nfor (let i = 1; i < 4; i++) {\n  for (let j = 1; j < 3; j++) {\n    total += i * j;\n  }\n}\nconsole.log(total);",
    "choices": [
      "6",
      "12",
      "18",
      "24"
    ],
    "correctIndex": 2,
    "explanation": "i は 1,2,3、j は 1,2 と変化します。<br>合計は 1×1 + 1×2 + 2×1 + 2×2 + 3×1 + 3×2 = <strong>18</strong> です。"
  },
  {
    "id": 166,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "filterによる抽出",
    "prompt": "nums から偶数だけを取り出した配列 evens を作るには、[ ア ] に何を入れればよいですか。",
    "code": "let nums = [1, 2, 3, 4, 5, 6];\nlet evens = nums.filter(n => [ ア ]);\nconsole.log(evens);",
    "choices": [
      "n % 2 == 0",
      "n % 2 == 1",
      "n > 6",
      "n == 0"
    ],
    "correctIndex": 0,
    "explanation": "filter は条件を満たす要素だけを残します。<br>偶数の条件は <strong>n % 2 == 0</strong> です。"
  },
  {
    "id": 167,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "whileループの回数",
    "prompt": "次のプログラムにおいて、n = Math.floor(n / 2) は何回実行されますか。",
    "code": "let n = 20;\nwhile (n > 1) {\n  n = Math.floor(n / 2);\n}\nconsole.log(n);",
    "choices": [
      "3回",
      "4回",
      "5回",
      "20回"
    ],
    "correctIndex": 1,
    "explanation": "n は 20 → 10 → 5 → 2 → 1 と変化します。<br>代入は <strong>4回</strong> 実行されます。"
  },
  {
    "id": 168,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "隣り合う要素の差",
    "prompt": "配列 nums の隣り合う要素の差を diffs に入れるコードとして正しいものを選びなさい。",
    "code": "let nums = [3, 7, 10];\n// diffs は [4, 3] にしたい",
    "choices": [
      "let diffs = [];\nfor (let i = 0; i < nums.length - 1; i++) {\n  diffs.push(nums[i + 1] - nums[i])\n}",
      "let diffs = [];\nfor (let i = 0; i < nums.length; i++) {\n  diffs.push(nums[i] - nums[i + 1])\n}",
      "diffs = nums",
      "diffs = [nums.length]"
    ],
    "correctIndex": 0,
    "explanation": "隣との差は nums[i + 1] - nums[i] です。<br>最後の要素には次がないので、i < nums.length - 1 まで調べます。"
  },
  {
    "id": 169,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "条件付きの合計",
    "prompt": "次のプログラムを実行したとき、console.log(s) の出力値を選びなさい。",
    "code": "let nums = [2, 5, 8, 11];\nlet s = 0;\nfor (const n of nums) {\n  if (n % 3 == 2) {\n    s += n;\n  }\n}\nconsole.log(s);",
    "choices": [
      "8",
      "11",
      "19",
      "26"
    ],
    "correctIndex": 3,
    "explanation": "2, 5, 8, 11 はすべて3で割った余りが2です。<br>すべて足されるので、2+5+8+11 = <strong>26</strong> です。"
  },
  {
    "id": 170,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "2次元配列の要素",
    "prompt": "値 6 を取り出して x に代入するには、[ ア ] に何を入れればよいですか。",
    "code": "let table = [\n  [1, 2, 3],\n  [4, 5, 6]\n];\nlet x = table[ ア ];\nconsole.log(x);",
    "choices": [
      "[0][2]",
      "[1][2]",
      "[2][1]",
      "[1][3]"
    ],
    "correctIndex": 1,
    "explanation": "2行目は添字1、3列目は添字2です。<br>したがって <strong>table[1][2]</strong> で 6 を取り出せます。"
  },
  {
    "id": 171,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "作業を早く空く担当者へ割り当てる",
    "prompt": "次のプログラムを実行したとき、console.log(available) の出力として正しいものを選びなさい。",
    "code": "let days = [4, 1, 3, 1, 3, 4, 2, 4, 3];\nlet available = [1, 1, 1];\n\nfor (let work = 0; work < days.length; work++) {\n  let member = 0;\n  for (let i = 1; i < available.length; i++) {\n    if (available[i] < available[member]) {\n      member = i;\n    }\n  }\n  available[member] = available[member] + days[work];\n\n}\nconsole.log(available);",
    "choices": [
      "[8, 10, 10]",
      "[10, 10, 8]",
      "[9, 9, 10]",
      "[11, 8, 9]"
    ],
    "correctIndex": 1,
    "explanation": "各作業を、現在もっとも早く空く担当者に割り当てます。<br>順に更新すると available は最終的に <strong>[10, 10, 8]</strong> になります。"
  },
  {
    "id": 172,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "最も早く空く担当者を探す条件",
    "prompt": "作業を最も早く空く担当者に割り当てるには、[ ア ] に入る条件として正しいものを選びなさい。",
    "code": "let days = [4, 1, 3, 1, 3, 4];\nlet available = [1, 1, 1];\n\nfor (let work = 0; work < days.length; work++) {\n  let member = 0;\n  for (let i = 1; i < available.length; i++) {\n    if ([ ア ]) {\n      member = i;\n    }\n  }\n  available[member] = available[member] + days[work];\n\n}\nconsole.log(available);",
    "choices": [
      "available[i] < available[member]",
      "available[i] > available[member]",
      "days[i] < days[member]",
      "work < member"
    ],
    "correctIndex": 0,
    "explanation": "最も早く空く担当者を探すので、候補 i の空き日 available[i] が現在の member より小さいかを調べます。"
  },
  {
    "id": 173,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "到着時刻と待ち時間",
    "prompt": "次のプログラムを実行したとき、console.log(longest) の出力値を選びなさい。",
    "code": "let arrival = [0, 3, 4, 10, 11, 12];\nlet start = Array(arrival.length).fill(0);\nlet finish = Array(arrival.length).fill(0);\n\nstart[0] = arrival[0];\nfinish[0] = start[0] + 5;\n\nfor (let i = 1; i < arrival.length; i++) {\n  start[i] = Math.max(arrival[i], finish[i - 1]);\n  finish[i] = start[i] + 5;\n\n}\nlet longest = 0;\nfor (let i = 0; i < arrival.length; i++) {\n  longest = Math.max(longest, start[i] - arrival[i]);\n\n}\nconsole.log(longest);",
    "choices": [
      "6",
      "9",
      "13",
      "15"
    ],
    "correctIndex": 2,
    "explanation": "前の人の終了時刻より早く到着した人は待ちます。<br>最後の人は 12 に到着し、25 に開始するので待ち時間は 13。最大は <strong>13</strong> です。"
  },
  {
    "id": 174,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "終了時刻を求める式",
    "prompt": "1人あたりの処理時間が service 分のとき、[ ア ] に入る式として正しいものを選びなさい。",
    "code": "let arrival = [0, 3, 4, 10];\nlet service = 5;\nlet start = Array(arrival.length).fill(0);\nlet finish = Array(arrival.length).fill(0);\n\nstart[0] = arrival[0];\nfinish[0] = start[0] + service;\n\nfor (let i = 1; i < arrival.length; i++) {\n  start[i] = Math.max(arrival[i], finish[i - 1]);\n  finish[i] = [ ア ];\n\n}\nconsole.log(finish);",
    "choices": [
      "start[i] + service",
      "arrival[i] + finish[i - 1]",
      "finish[i - 1] + i",
      "service - start[i]"
    ],
    "correctIndex": 0,
    "explanation": "終了時刻は「開始時刻 + 処理時間」です。したがって finish[i] = <strong>start[i] + service</strong> です。"
  },
  {
    "id": 175,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "二重ループと条件判定の実行回数",
    "prompt": "次のプログラムにおいて、count += 1 は何回実行されますか。",
    "code": "let count = 0;\n\nfor (let day = 1; day < 6; day++) {\n  for (let room = 0; room < 3; room++) {\n    if ((day + room) % 2 == 0) {\n      count += 1;\n\n    }\n  }\n}\nconsole.log(count);",
    "choices": [
      "5回",
      "6回",
      "7回",
      "8回"
    ],
    "correctIndex": 2,
    "explanation": "day は1〜5、room は0〜2です。<br>day+room が偶数になる組を数えると、1+2+1+2+1 = <strong>7回</strong> です。"
  },
  {
    "id": 176,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "条件を満たす区間数を数える",
    "prompt": "temps の中で、前日より気温が高くなった日数を count に入れるコードとして正しいものを選びなさい。",
    "code": "let temps = [22, 24, 23, 27, 29, 28];\n// 前日より高くなった回数を count に入れる",
    "choices": [
      "let count = 0;\nfor (let i = 1; i < temps.length; i++) {\n  if (temps[i] > temps[i - 1]) {\n    count += 1;\n  }\n}",
      "let count = 0;\nfor (let i = 0; i < temps.length; i++) {\n  if (temps[i] > temps[i + 1]) {\n    count += 1;\n  }\n}",
      "let count = 1;\nfor (let i = 1; i < temps.length; i++) {\n  if (temps[i] < temps[i - 1]) {\n    count += 1;\n  }\n}",
      "count = temps.length"
    ],
    "correctIndex": 0,
    "explanation": "前日と比較するため、i は1から始めます。<br>比較する式は temps[i] > temps[i - 1] です。"
  },
  {
    "id": 177,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "必要数を満たしたグループ数",
    "prompt": "次のプログラムを実行したとき、console.log(group, filled) の出力として正しいものを選びなさい。",
    "code": "let seats = [2, 4, 1, 3, 2];\nlet need = [3, 5, 2];\nlet filled = Array(need.length).fill(0);\nlet group = 0;\n\nfor (let i = 0; i < seats.length; i++) {\n  filled[group] += seats[i];\n  if (filled[group] >= need[group]) {\n    group += 1;\n  }\n  if (group == need.length) {\n    break;\n\n  }\n}\nconsole.log(group, filled);",
    "choices": [
      "1 [6, 0, 0]",
      "2 [6, 6, 0]",
      "2 [3, 5, 0]",
      "3 [6, 6, 2]"
    ],
    "correctIndex": 1,
    "explanation": "1つ目のグループは 2+4=6 で条件を満たします。<br>2つ目は 1+3+2=6 で条件を満たします。よって <strong>2 [6, 6, 0]</strong> です。"
  },
  {
    "id": 178,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "すべてのグループが完了したら抜ける条件",
    "prompt": "すべてのグループが必要数を満たしたら繰り返しを抜けるには、[ ア ] に何を入れればよいですか。",
    "code": "let seats = [2, 4, 1, 3, 2];\nlet need = [3, 5, 2];\nlet filled = Array(need.length).fill(0);\nlet group = 0;\n\nfor (let i = 0; i < seats.length; i++) {\n  filled[group] += seats[i];\n  if (filled[group] >= need[group]) {\n    group += 1;\n  }\n  if ([ ア ]) {\n    break;\n\n  }\n}\nconsole.log(group);",
    "choices": [
      "group == need.length",
      "group == seats.length",
      "filled[group] == 0",
      "i == group"
    ],
    "correctIndex": 0,
    "explanation": "group は完了したグループ数を表します。<br>完了数が need の個数と同じになれば、すべてのグループが完了しています。"
  },
  {
    "id": 179,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "2次元配列の行ごとの合計",
    "prompt": "次のプログラムを実行したとき、console.log(best) の出力値を選びなさい。",
    "code": "let table = [\n  [0, 2, 1],\n  [3, 1, 0],\n  [2, 0, 4]\n];\n\nlet best = 0;\nfor (let r = 0; r < table.length; r++) {\n  let total = 0;\n  for (let c = 0; c < table[r].length; c++) {\n    if (table[r][c] > 0) {\n      total += table[r][c];\n    }\n  }\n  if (total > best) {\n    best = total;\n\n  }\n}\nconsole.log(best);",
    "choices": [
      "3",
      "4",
      "6",
      "10"
    ],
    "correctIndex": 2,
    "explanation": "各行の合計は、1行目が3、2行目が4、3行目が6です。<br>最大は <strong>6</strong> です。"
  },
  {
    "id": 180,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "最大値が更新される回数",
    "prompt": "次のプログラムにおいて、best = n は何回実行されますか。",
    "code": "let nums = [6, 2, 8, 8, 3, 9];\nlet best = 0;\nlet count = 0;\n\nfor (const n of nums) {\n  if (n > best) {\n    best = n;\n    count += 1;\n\n  }\n}\nconsole.log(best, count);",
    "choices": [
      "1回",
      "2回",
      "3回",
      "4回"
    ],
    "correctIndex": 2,
    "explanation": "best は 6、8、9 のときに更新されます。<br>同じ8がもう一度出ても n > best ではないため更新されません。よって <strong>3回</strong> です。"
  },
  {
    "id": 181,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "担当者の最短空き日を探す",
    "prompt": "工芸品を、最も早く空く担当者へ順に割り当てる。内側のループで最短の空き日を持つ担当者を選ぶには、[ ア ] に何を入れればよいですか。",
    "code": "let work_days = [4, 1, 3, 2, 5, 1];\nlet free_day = [1, 1, 1];\n\nfor (let w = 0; w < work_days.length; w++) {\n  let staff = 0;\n  for (let i = 1; i < free_day.length; i++) {\n    if ([ ア ]) {\n      staff = i;\n    }\n  }\n  free_day[staff] = free_day[staff] + work_days[w];\n\n}\nconsole.log(free_day);",
    "choices": [
      "free_day[i] < free_day[staff]",
      "free_day[i] > free_day[staff]",
      "work_days[i] < work_days[staff]",
      "i < staff",
      "free_day[staff] < work_days[w]",
      "work_days[w] < free_day[i]"
    ],
    "correctIndex": 0,
    "explanation": "staff には「今のところ最も早く空く担当者」の添字を入れます。<br>候補 i の空き日 free_day[i] が、現在の staff の空き日 free_day[staff] より小さいときに staff を更新します。<br>したがって条件は <strong>free_day[i] < free_day[staff]</strong> です。"
  },
  {
    "id": 182,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "作業割当後の空き日",
    "prompt": "次のプログラムを実行したとき、console.log(free_day) の出力として正しいものを選びなさい。",
    "code": "let work_days = [2, 5, 1, 4, 3, 2, 4];\nlet free_day = [1, 1, 1];\n\nfor (let w = 0; w < work_days.length; w++) {\n  let staff = 0;\n  for (let i = 1; i < free_day.length; i++) {\n    if (free_day[i] < free_day[staff]) {\n      staff = i;\n    }\n  }\n  free_day[staff] = free_day[staff] + work_days[w];\n\n}\nconsole.log(free_day);",
    "choices": [
      "[8, 10, 6]",
      "[9, 8, 5]",
      "[7, 7, 8]",
      "[10, 5, 7]",
      "[6, 9, 7]",
      "[9, 5, 8]"
    ],
    "correctIndex": 0,
    "explanation": "free_day は担当者が次に空く日を表します。<br>同じ空き日の担当者が複数いる場合、このプログラムでは添字の小さい担当者が選ばれます。順に割り当てると、[1,1,1] → [3,1,1] → [3,6,1] → [3,6,2] → [3,6,6] → [6,6,6] → [8,6,6] → <strong>[8,10,6]</strong> です。"
  },
  {
    "id": 183,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "待ち時間を求める開始時刻",
    "prompt": "1つの窓口で順番に処理する。i番目の人の開始時刻 start[i] を正しく求めるには、[ ア ] に何を入れればよいですか。",
    "code": "let arrival = [0, 2, 4, 9, 11];\nlet service = 5;\nlet start = Array(arrival.length).fill(0);\nlet finish = Array(arrival.length).fill(0);\n\nstart[0] = arrival[0];\nfinish[0] = start[0] + service;\n\nfor (let i = 1; i < arrival.length; i++) {\n  start[i] = [ ア ];\n  finish[i] = start[i] + service;\n\n}\nconsole.log(start);",
    "choices": [
      "Math.max(arrival[i], finish[i - 1])",
      "Math.min(arrival[i], finish[i - 1])",
      "arrival[i] + service",
      "finish[i - 1] - service",
      "Math.max(arrival[i - 1], finish[i])",
      "arrival[i - 1] + finish[i - 1]"
    ],
    "correctIndex": 0,
    "explanation": "その人が到着していて、かつ前の人の処理が終わっていないと開始できません。<br>よって開始時刻は「到着時刻」と「直前の終了時刻」の大きい方、つまり <strong>Math.max(arrival[i], finish[i - 1])</strong> です。"
  },
  {
    "id": 184,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "最長待ち時間を求める",
    "prompt": "次のプログラムを実行したとき、console.log(longest) の出力値として正しいものを選びなさい。",
    "code": "let arrival = [0, 3, 6, 7, 15, 16];\nlet service = 4;\nlet start = Array(arrival.length).fill(0);\nlet finish = Array(arrival.length).fill(0);\n\nstart[0] = arrival[0];\nfinish[0] = start[0] + service;\n\nfor (let i = 1; i < arrival.length; i++) {\n  start[i] = Math.max(arrival[i], finish[i - 1]);\n  finish[i] = start[i] + service;\n\n}\nlet longest = 0;\nfor (let i = 0; i < arrival.length; i++) {\n  let wait = start[i] - arrival[i];\n  if (wait > longest) {\n    longest = wait;\n\n  }\n}\nconsole.log(longest);",
    "choices": [
      "0",
      "1",
      "2",
      "3",
      "4",
      "5"
    ],
    "correctIndex": 5,
    "explanation": "開始時刻は [0,4,8,12,16,20] です。<br>待ち時間は [0,1,2,5,1,4] なので、最大は4番目の人の 12-7=<strong>5</strong> です。"
  },
  {
    "id": 185,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "条件を満たす組の数",
    "prompt": "次のプログラムで、count += 1 は何回実行されますか。",
    "code": "let scores = [\n  [2, 0, 1],\n  [0, 3, 2],\n  [4, 1, 0]\n];\nlet count = 0;\n\nfor (let r = 0; r < scores.length; r++) {\n  for (let c = 0; c < scores[r].length; c++) {\n    if (scores[r][c] >= 2) {\n      count += 1;\n\n    }\n  }\n}\nconsole.log(count);",
    "choices": [
      "2回",
      "3回",
      "4回",
      "5回",
      "6回",
      "9回"
    ],
    "correctIndex": 2,
    "explanation": "2以上の値は、2, 3, 2, 4 の4個です。<br>したがって count += 1 は <strong>4回</strong> 実行されます。"
  },
  {
    "id": 186,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "累積人数が定員を超える時点",
    "prompt": "次のプログラムを実行したとき、console.log(day) の出力値として正しいものを選びなさい。",
    "code": "let visitors = [18, 22, 15, 30, 12, 20];\nlet limit = 70;\nlet total = 0;\nlet day = -1;\n\nfor (let i = 0; i < visitors.length; i++) {\n  total += visitors[i];\n  if (total >= limit && day == -1) {\n    day = i;\n\n  }\n}\nconsole.log(day);",
    "choices": [
      "0",
      "1",
      "2",
      "3",
      "4",
      "5",
      "-1",
      "70"
    ],
    "correctIndex": 3,
    "explanation": "累積は 18 → 40 → 55 → 85 と変化します。<br>初めて70以上になるのは i=3 のときです。よって出力は <strong>3</strong> です。"
  },
  {
    "id": 187,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "初めて条件を満たした位置だけを記録する",
    "prompt": "target 以上になった最初の添字だけを pos に入れるには、[ ア ] に何を入れればよいですか。",
    "code": "let points = [12, 8, 15, 6, 20];\nlet target = 30;\nlet total = 0;\nlet pos = -1;\n\nfor (let i = 0; i < points.length; i++) {\n  total += points[i];\n  if (total >= target && [ ア ]) {\n    pos = i;\n\n  }\n}\nconsole.log(pos);",
    "choices": [
      "pos == -1",
      "pos == i",
      "pos >= 0",
      "total == 0",
      "points[i] == target",
      "i == 0",
      "target < 0",
      "points.length == pos"
    ],
    "correctIndex": 0,
    "explanation": "pos は「まだ記録していない」ことを -1 で表しています。<br>一度 pos に添字を入れた後は更新したくないので、条件に <strong>pos == -1</strong> を加えます。"
  },
  {
    "id": 188,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "区間の長さの最大値",
    "prompt": "次のプログラムを実行したとき、console.log(longest) の出力値として正しいものを選びなさい。",
    "code": "let busy = [1, 1, 0, 1, 1, 1, 0, 1];\nlet now = 0;\nlet longest = 0;\n\nfor (let i = 0; i < busy.length; i++) {\n  if (busy[i] == 1) {\n    now += 1;\n    if (now > longest) {\n      longest = now;\n    }\n  }\n  else {\n    now = 0;\n\n  }\n}\nconsole.log(longest);",
    "choices": [
      "0",
      "1",
      "2",
      "3",
      "4",
      "5",
      "6",
      "8"
    ],
    "correctIndex": 3,
    "explanation": "1が連続する長さを数えています。<br>連続部分は [1,1] が長さ2、[1,1,1] が長さ3、最後の [1] が長さ1です。最大は <strong>3</strong> です。"
  },
  {
    "id": 189,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "2次元配列の列合計",
    "prompt": "各列の合計を col_sum に入れる。空欄 [ ア ] に入る式として正しいものを選びなさい。",
    "code": "let table = [\n  [3, 1, 4],\n  [2, 5, 0],\n  [1, 2, 6]\n];\nlet col_sum = [0, 0, 0];\n\nfor (let r = 0; r < table.length; r++) {\n  for (let c = 0; c < table[r].length; c++) {\n    col_sum[c] += [ ア ];\n\n  }\n}\nconsole.log(col_sum);",
    "choices": [
      "table[r][c]",
      "table[c][r]",
      "table[r]",
      "table[c]",
      "col_sum[r]",
      "col_sum[c]",
      "r + c",
      "table[c].length"
    ],
    "correctIndex": 0,
    "explanation": "r行c列の値を、c列目の合計 col_sum[c] に足します。<br>参照する値は <strong>table[r][c]</strong> です。"
  },
  {
    "id": 190,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "javascript",
    "title": "列合計の最大値",
    "prompt": "次のプログラムを実行したとき、console.log(best) の出力値として正しいものを選びなさい。",
    "code": "let table = [\n  [3, 1, 4],\n  [2, 5, 0],\n  [1, 2, 6]\n];\nlet col_sum = [0, 0, 0];\n\nfor (let r = 0; r < table.length; r++) {\n  for (let c = 0; c < table[r].length; c++) {\n    col_sum[c] += table[r][c];\n\n  }\n}\nlet best = 0;\nfor (const x of col_sum) {\n  if (x > best) {\n    best = x;\n\n  }\n}\nconsole.log(best);",
    "choices": [
      "6",
      "7",
      "8",
      "9",
      "10",
      "11",
      "12",
      "21"
    ],
    "correctIndex": 4,
    "explanation": "列ごとの合計は、1列目が 3+2+1=6、2列目が 1+5+2=8、3列目が 4+0+6=10 です。<br>最大値は <strong>10</strong> です。"
  },
  {
    "id": 191,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "javascript",
    "title": "偶数番目の要素を合計する",
    "prompt": "添字が偶数の要素だけを total に加えるには、[ ア ] に何を入れればよいですか。",
    "code": "let nums = [5, 8, 3, 6, 7, 2];\nlet total = 0;\n\nfor (let i = 0; i < nums.length; i++) {\n  if ([ ア ]) {\n    total += nums[i];\n  }\n}\nconsole.log(total);",
    "choices": [
      "i % 2 == 0",
      "i % 2 == 1",
      "nums[i] % 2 == 0",
      "nums[i] % 2 == 1",
      "i == nums[i]",
      "i > nums[i]"
    ],
    "correctIndex": 0,
    "explanation": "添字が偶数とは、i が 0, 2, 4, ... になる場合です。<br>2で割った余りが0なので、条件は <strong>i % 2 == 0</strong> です。"
  },
  {
    "id": 192,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "javascript",
    "title": "条件によって足すか引くかを変える",
    "prompt": "次のプログラムを実行したとき、console.log(total) の出力値として正しいものを選びなさい。",
    "code": "let nums = [4, 1, 7, 2, 5];\nlet total = 0;\n\nfor (const n of nums) {\n  if (n >= 5) {\n    total += n;\n  }\n  else {\n    total -= n;\n\n  }\n}\nconsole.log(total);",
    "choices": [
      "0",
      "3",
      "5",
      "7",
      "9",
      "19"
    ],
    "correctIndex": 2,
    "explanation": "5以上なら足し、5未満なら引きます。<br>total は 0-4-1+7-2+5 = <strong>5</strong> になります。"
  },
  {
    "id": 193,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "標準",
    "langMode": "javascript",
    "title": "2つの条件を同時に満たす回数",
    "prompt": "次のプログラムで、count += 1 は何回実行されますか。",
    "code": "let nums = [2, 5, 8, 11, 14, 17];\nlet count = 0;\n\nfor (const n of nums) {\n  if (n % 3 == 2 && n > 10) {\n    count += 1;\n\n  }\n}\nconsole.log(count);",
    "choices": [
      "1回",
      "2回",
      "3回",
      "4回",
      "5回",
      "6回"
    ],
    "correctIndex": 2,
    "explanation": "n % 3 == 2 かつ n > 10 を満たす値は 11, 14, 17 の3つです。<br>よって count += 1 は <strong>3回</strong> 実行されます。"
  },
  {
    "id": 194,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "javascript",
    "title": "在庫の残りと少ない商品の数",
    "prompt": "次のプログラムを実行したとき、console.log(remain, count) の出力として正しいものを選びなさい。",
    "code": "let stock = [12, 9, 15, 7, 10];\nlet sold = [3, 4, 5, 2, 6];\nlet remain = [];\nlet count = 0;\n\nfor (let i = 0; i < stock.length; i++) {\n  remain.push(stock[i] - sold[i])\n  if (remain[i] < 8) {\n    count += 1;\n\n  }\n}\nconsole.log(remain, count);",
    "choices": [
      "[9, 5, 10, 5, 4] 3",
      "[9, 5, 10, 5, 4] 2",
      "[15, 13, 20, 9, 16] 0",
      "[3, 4, 5, 2, 6] 5",
      "[9, 5, 10, 5, 4] 5",
      "[12, 9, 15, 7, 10] 3"
    ],
    "correctIndex": 0,
    "explanation": "残りは順に 12-3=9, 9-4=5, 15-5=10, 7-2=5, 10-6=4 です。<br>8未満は 5, 5, 4 の3個なので、出力は <strong>[9, 5, 10, 5, 4] 3</strong> です。"
  },
  {
    "id": 195,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "javascript",
    "title": "前日より増えた日を数える",
    "prompt": "前の値より大きくなった回数を数えるには、[ ア ] に何を入れればよいですか。",
    "code": "let temps = [18, 20, 19, 22, 22, 25];\nlet count = 0;\n\nfor (let i = 1; i < temps.length; i++) {\n  if ([ ア ]) {\n    count += 1;\n\n  }\n}\nconsole.log(count);",
    "choices": [
      "temps[i] > temps[i - 1]",
      "temps[i] < temps[i - 1]",
      "temps[i] == temps[i - 1]",
      "i > temps[i]",
      "temps[i - 1] > i",
      "temps[i] >= 0"
    ],
    "correctIndex": 0,
    "explanation": "前の値は temps[i - 1]、現在の値は temps[i] です。<br>前より増えたかを調べる条件は <strong>temps[i] > temps[i - 1]</strong> です。"
  },
  {
    "id": 196,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "javascript",
    "title": "指定された箱の数を増やす",
    "prompt": "次のプログラムを実行したとき、console.log(boxes) の出力として正しいものを選びなさい。",
    "code": "let boxes = [3, 0, 2];\nlet moves = [1, 2, 0, 1];\n\nfor (const m of moves) {\n  boxes[m] += 1;\n\n}\nconsole.log(boxes);",
    "choices": [
      "[4, 2, 3]",
      "[3, 2, 3]",
      "[4, 1, 3]",
      "[5, 1, 2]",
      "[3, 1, 2]",
      "[1, 2, 0]",
      "[7, 4, 6]",
      "[4, 3, 2]"
    ],
    "correctIndex": 0,
    "explanation": "moves の値は、増やす箱の添字を表します。<br>添字1を2回、添字2を1回、添字0を1回増やすので、boxes は <strong>[4, 2, 3]</strong> になります。"
  },
  {
    "id": 197,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "javascript",
    "title": "隣り合う要素を比較する範囲",
    "prompt": "data[i] と data[i + 1] を安全に比較するには、[ ア ] に何を入れればよいですか。",
    "code": "let data = [3, 5, 4, 6, 8];\nlet pos = -1;\n\nfor ([ ア ]) {\n  if (data[i] > data[i + 1]) {\n    pos = i;\n    break;\n  }\n}\nconsole.log(pos);",
    "choices": [
      "let i = 0; i < data.length - 1; i++",
      "let i = 0; i < data.length; i++",
      "let i = 1; i < data.length; i++",
      "let i = 0; i < data.length + 1; i++",
      "let i = 0; i < data[i]; i++",
      "let i = 0; i < 0; i++",
      "let i = 0; i < pos; i++",
      "let i = 0; i < pos.length; i++"
    ],
    "correctIndex": 0,
    "explanation": "data[i + 1] を使うため、i は最後の添字まで進めてはいけません。<br>最後に使える i は data.length - 2 なので、条件は <strong>i < data.length - 1</strong> です。"
  },
  {
    "id": 198,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "javascript",
    "title": "余りごとの個数を数える",
    "prompt": "次のプログラムを実行したとき、console.log(bucket) の出力として正しいものを選びなさい。",
    "code": "let nums = [5, 8, 10, 12, 14, 17, 21];\nlet bucket = [0, 0, 0];\n\nfor (const n of nums) {\n  bucket[n % 3] += 1;\n\n}\nconsole.log(bucket);",
    "choices": [
      "[2, 1, 4]",
      "[1, 2, 4]",
      "[4, 1, 2]",
      "[2, 4, 1]",
      "[0, 3, 4]",
      "[3, 2, 2]",
      "[5, 8, 10]",
      "[7, 0, 0]"
    ],
    "correctIndex": 0,
    "explanation": "3で割った余りごとに数えます。<br>余り0は 12,21 の2個、余り1は 10 の1個、余り2は 5,8,14,17 の4個です。よって <strong>[2, 1, 4]</strong> です。"
  },
  {
    "id": 199,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "標準",
    "langMode": "javascript",
    "title": "値を半分にする繰り返し",
    "prompt": "次のプログラムで、count += 1 は何回実行されますか。",
    "code": "let x = 48;\nlet count = 0;\n\nwhile (x > 5) {\n  x = Math.floor(x / 2);\n  count += 1;\n\n}\nconsole.log(x, count);",
    "choices": [
      "1回",
      "2回",
      "3回",
      "4回",
      "5回",
      "6回",
      "7回",
      "8回"
    ],
    "correctIndex": 3,
    "explanation": "x は 48 → 24 → 12 → 6 → 3 と変化します。<br>x が3になると x > 5 を満たさないため停止します。count += 1 は <strong>4回</strong> 実行されます。"
  },
  {
    "id": 200,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "javascript",
    "title": "目標に達したら繰り返しを止める",
    "prompt": "合計が target 以上になった時点で繰り返しを止めるには、[ ア ] に何を入れればよいですか。",
    "code": "let items = [4, 7, 3, 6, 5];\nlet target = 18;\nlet total = 0;\nlet used = 0;\n\nfor (let i = 0; i < items.length; i++) {\n  total += items[i];\n  used += 1;\n  if ([ ア ]) {\n    break;\n\n  }\n}\nconsole.log(used);",
    "choices": [
      "total >= target",
      "total < target",
      "items[i] == target",
      "used == 0",
      "i == items.length",
      "items[i] > total",
      "target < 0",
      "total == items[i]"
    ],
    "correctIndex": 0,
    "explanation": "合計が target 以上になったら、そこで繰り返しを止めます。<br>条件は <strong>total >= target</strong> です。"
  },
  {
    "id": 201,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "基礎",
    "langMode": "javascript",
    "title": "配列から指定の値を取り出す",
    "prompt": "x に 18 を代入するには、[ ア ] に入る値として正しいものを選びなさい。",
    "code": "let scores = [12, 15, 18, 20];\nlet x = scores[[ ア ]];\nconsole.log(x);",
    "choices": [
      "0",
      "1",
      "2",
      "3",
      "4",
      "18"
    ],
    "correctIndex": 2,
    "explanation": "JavaScriptの配列は添字が0から始まります。<br>scores[0]=12, scores[1]=15, scores[2]=18 なので、18を取り出す添字は <strong>2</strong> です。"
  },
  {
    "id": 202,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "javascript",
    "title": "変数の値を更新する",
    "prompt": "次のプログラムを実行したとき、console.log(x) の出力値として正しいものを選びなさい。",
    "code": "let x = 6;\nx = x + 3;\nx = x * 2;\nconsole.log(x);",
    "choices": [
      "9",
      "12",
      "15",
      "18",
      "21",
      "36"
    ],
    "correctIndex": 3,
    "explanation": "最初 x=6 です。<br>x=x+3 で9になり、x=x*2 で <strong>18</strong> になります。"
  },
  {
    "id": 203,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "基礎",
    "langMode": "javascript",
    "title": "for文の繰り返し回数",
    "prompt": "次のプログラムで、total += i は何回実行されますか。",
    "code": "let total = 0;\n\nfor (let i = 2; i < 7; i++) {\n  total += i;\n\n}\nconsole.log(total);",
    "choices": [
      "2回",
      "3回",
      "4回",
      "5回",
      "6回",
      "7回"
    ],
    "correctIndex": 3,
    "explanation": "for文では、i は 2, 3, 4, 5, 6 と変化します。<br>したがって total += i は <strong>5回</strong> 実行されます。"
  },
  {
    "id": 204,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "javascript",
    "title": "条件を満たす値だけを足す",
    "prompt": "次のプログラムを実行したとき、console.log(total) の出力値として正しいものを選びなさい。",
    "code": "let nums = [3, 8, 5, 10, 2];\nlet total = 0;\n\nfor (const n of nums) {\n  if (n >= 5) {\n    total += n;\n\n  }\n}\nconsole.log(total);",
    "choices": [
      "13",
      "15",
      "18",
      "20",
      "23",
      "28"
    ],
    "correctIndex": 4,
    "explanation": "5以上の値は 8, 5, 10 です。<br>合計は 8+5+10=<strong>23</strong> です。"
  },
  {
    "id": 205,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "基礎",
    "langMode": "javascript",
    "title": "合計を求める代入文",
    "prompt": "配列の値を順に total に加えるには、[ ア ] に何を入れればよいですか。",
    "code": "let nums = [2, 4, 6];\nlet total = 0;\n\nfor (const n of nums) {\n  [ ア ]\n\n}\nconsole.log(total);",
    "choices": [
      "total += n",
      "total = n",
      "n += total",
      "total -= n",
      "console.log(n);",
      "nums += n"
    ],
    "correctIndex": 0,
    "explanation": "total に n を加えて更新するので、代入文は <strong>total += n</strong> です。<br>これは total = total + n と同じ意味です。"
  },
  {
    "id": 206,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "javascript",
    "title": "配列の値を1つだけ更新する",
    "prompt": "次のプログラムを実行したとき、console.log(data) の出力として正しいものを選びなさい。",
    "code": "let data = [4, 7, 1, 9];\ndata[2] = data[2] + 5;\nconsole.log(data);",
    "choices": [
      "[4, 7, 6, 9]",
      "[4, 12, 1, 9]",
      "[4, 7, 1, 14]",
      "[9, 7, 1, 9]",
      "[4, 7, 5, 9]",
      "[4, 7, 1, 9]",
      "[6, 7, 1, 9]",
      "[4, 6, 1, 9]"
    ],
    "correctIndex": 0,
    "explanation": "data[2] は3番目の値で、最初は1です。<br>1+5=6 になるので、配列は <strong>[4, 7, 6, 9]</strong> になります。"
  },
  {
    "id": 207,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "基礎",
    "langMode": "javascript",
    "title": "配列全体を添字で調べる",
    "prompt": "配列の全要素を添字 i で順に調べるには、[ ア ] に何を入れればよいですか。",
    "code": "let data = [6, 2, 9, 4];\nlet total = 0;\n\nfor ([ ア ]) {\n  total += data[i];\n}\nconsole.log(total);",
    "choices": [
      "let i = 0; i < data.length; i++",
      "let i = 0; i < data.length - 1; i++",
      "let i = 1; i < data.length; i++",
      "let i = 0; i < data; i++",
      "let i = 0; i < total; i++",
      "let i = 0; i < 0; i++",
      "let i = 0; i < i.length; i++",
      "let i = 0; i < data[i]; i++"
    ],
    "correctIndex": 0,
    "explanation": "添字は 0 から data.length - 1 までです。<br>その範囲を順に作るには <strong>let i = 0; i < data.length; i++</strong> を使います。"
  },
  {
    "id": 208,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "javascript",
    "title": "偶数だけを数える",
    "prompt": "次のプログラムを実行したとき、console.log(count) の出力値として正しいものを選びなさい。",
    "code": "let nums = [1, 4, 6, 7, 10];\nlet count = 0;\n\nfor (const n of nums) {\n  if (n % 2 == 0) {\n    count += 1;\n\n  }\n}\nconsole.log(count);",
    "choices": [
      "0",
      "1",
      "2",
      "3",
      "4",
      "5",
      "6",
      "10"
    ],
    "correctIndex": 3,
    "explanation": "偶数は 4, 6, 10 の3つです。<br>したがって count は <strong>3</strong> になります。"
  },
  {
    "id": 209,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "基礎",
    "langMode": "javascript",
    "title": "条件が成り立つ回数",
    "prompt": "次のプログラムで、count += 1 は何回実行されますか。",
    "code": "let scores = [45, 80, 62, 59, 70];\nlet count = 0;\n\nfor (const s of scores) {\n  if (s >= 60) {\n    count += 1;\n\n  }\n}\nconsole.log(count);",
    "choices": [
      "0回",
      "1回",
      "2回",
      "3回",
      "4回",
      "5回",
      "60回",
      "70回"
    ],
    "correctIndex": 3,
    "explanation": "60以上の点数は 80, 62, 70 の3つです。<br>よって count += 1 は <strong>3回</strong> 実行されます。"
  },
  {
    "id": 210,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "javascript",
    "title": "文字列を条件で数える",
    "prompt": "次のプログラムを実行したとき、console.log(count) の出力値として正しいものを選びなさい。",
    "code": "let letters = [\"A\", \"B\", \"A\", \"C\", \"A\"];\nlet count = 0;\n\nfor (const x of letters) {\n  if (x == \"A\") {\n    count += 1;\n\n  }\n}\nconsole.log(count);",
    "choices": [
      "0",
      "1",
      "2",
      "3",
      "4",
      "5",
      "A",
      "B"
    ],
    "correctIndex": 3,
    "explanation": "letters の中で \"A\" は1番目、3番目、5番目にあります。<br>合計3個なので、出力は <strong>3</strong> です。"
  }
];
