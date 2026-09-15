// This file is generated from the original QUESTIONS data split by langMode.
const PYTHON_QUESTIONS = [
  {
    "id": 1,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "基礎",
    "langMode": "python",
    "title": "リストの添字を使った値の取得",
    "prompt": "次のプログラムの [ ア ] に入る値として正しいものを選びなさい。（x には 10 を代入したい）",
    "code": "data = [5, 10, 15, 20]\nx = data[[ ア ]]\nprint(x)",
    "choices": [
      "0",
      "1",
      "2",
      "3"
    ],
    "correctIndex": 1,
    "explanation": "Pythonのリストは添字が【0】から始まります。<br>data[0]=5, data[1]=<strong>10</strong>, data[2]=15 …<br>10 を取り出すには添字 <strong>1</strong> が必要です。"
  },
  {
    "id": 2,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "python",
    "title": "変数への代入と計算",
    "prompt": "次のプログラムを実行したとき、print(x) の出力値を選びなさい。",
    "code": "x = 3\nx = x + 4\nprint(x)",
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
    "id": 3,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "基礎",
    "langMode": "python",
    "title": "条件分岐の条件",
    "prompt": "score が 60 以上のときに「合格」と表示するには、[ ア ] に何を入れればよいですか。",
    "code": "score = 75\nif score [ ア ] 60:\n    print(\"合格\")",
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
    "id": 4,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "基礎",
    "langMode": "python",
    "title": "表示する関数の実行回数",
    "prompt": "次のプログラムにおいて、print(i) は何回実行されますか。",
    "code": "for i in range(4):\n    print(i)",
    "choices": [
      "3回",
      "4回",
      "5回",
      "0回"
    ],
    "correctIndex": 1,
    "explanation": "range(4) は 0, 1, 2, 3 の4個の値を作ります。<br>そのため print(i) は <strong>4回</strong> 実行されます。"
  },
  {
    "id": 5,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "python",
    "title": "文字列の連結",
    "prompt": "次のプログラムを実行したとき、出力される文字列を選びなさい。",
    "code": "a = \"情報\"\nb = \"I\"\nprint(a + b)",
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
    "id": 6,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "基礎",
    "langMode": "python",
    "title": "偶数判定の表記",
    "prompt": "変数 n が偶数のときだけ「偶数」と表示するプログラム表記として正しいものを選びなさい。",
    "code": "n = 8\n# n が偶数なら「偶数」と表示する",
    "choices": [
      "if n % 2 == 0:\n    print(\"偶数\")",
      "if n / 2 == 0:\n    print(\"偶数\")",
      "if n % 2 == 1:\n    print(\"偶数\")",
      "if n == 2:\n    print(\"偶数\")"
    ],
    "correctIndex": 0,
    "explanation": "偶数は 2 で割った余りが 0 の数です。<br>Pythonでは余りを <strong>%</strong> で求めるので、n % 2 == 0 が正解です。"
  },
  {
    "id": 7,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "python",
    "title": "リスト要素の更新",
    "prompt": "次のプログラムを実行したとき、print(nums[1]) の出力値を選びなさい。",
    "code": "nums = [2, 4, 6]\nnums[1] = nums[1] + 3\nprint(nums[1])",
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
    "id": 8,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "基礎",
    "langMode": "python",
    "title": "繰り返し回数の穴埋め",
    "prompt": "「Hello」を5回表示するには、[ ア ] に何を入れればよいですか。",
    "code": "for i in range([ ア ]):\n    print(\"Hello\")",
    "choices": [
      "4",
      "5",
      "6",
      "10"
    ],
    "correctIndex": 1,
    "explanation": "range(5) は 0,1,2,3,4 の5回分の繰り返しを作ります。<br>よって [ ア ] は <strong>5</strong> です。"
  },
  {
    "id": 9,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "基礎",
    "langMode": "python",
    "title": "条件を満たす回数",
    "prompt": "次のプログラムにおいて、count += 1 は何回実行されますか。",
    "code": "count = 0\nfor i in range(5):\n    if i >= 2:\n        count += 1\nprint(count)",
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
    "id": 10,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "基礎",
    "langMode": "python",
    "title": "最大値の取り出し",
    "prompt": "リスト nums の中から最大値を表示するコードとして正しいものを選びなさい。",
    "code": "nums = [3, 9, 1, 6]\n# 最大値を表示する",
    "choices": [
      "print(max(nums))",
      "print(min(nums))",
      "print(len(nums))",
      "print(nums[0])"
    ],
    "correctIndex": 0,
    "explanation": "Pythonでは max(リスト) で最大値を求められます。<br>このリストの最大値は <strong>9</strong> です。"
  },
  {
    "id": 11,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "python",
    "title": "rangeの開始と終了",
    "prompt": "次のプログラムを実行したとき、print(s) の出力値を選びなさい。",
    "code": "s = 0\nfor i in range(1, 5):\n    s = s + i\nprint(s)",
    "choices": [
      "6",
      "10",
      "15",
      "5"
    ],
    "correctIndex": 1,
    "explanation": "range(1, 5) は 1,2,3,4 です。<br>合計は 1+2+3+4 = <strong>10</strong> です。"
  },
  {
    "id": 12,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "python",
    "title": "リストの長さ",
    "prompt": "リスト items の要素数を n に代入するには、[ ア ] に何を入れればよいですか。",
    "code": "items = [\"A\", \"B\", \"C\"]\nn = [ ア ]\nprint(n)",
    "choices": [
      "items.size",
      "len(items)",
      "count(items)",
      "items[3]"
    ],
    "correctIndex": 1,
    "explanation": "Pythonでリストの要素数を求める関数は <strong>len()</strong> です。"
  },
  {
    "id": 13,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "標準",
    "langMode": "python",
    "title": "二重ループの実行回数",
    "prompt": "次のプログラムにおいて、print(i, j) は何回実行されますか。",
    "code": "for i in range(3):\n    for j in range(2):\n        print(i, j)",
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
    "id": 14,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "標準",
    "langMode": "python",
    "title": "リストの合計",
    "prompt": "リスト nums の全要素の合計を total に求めるコードとして正しいものを選びなさい。",
    "code": "nums = [1, 2, 3, 4]\n# total に合計を入れる",
    "choices": [
      "total = 0\nfor n in nums:\n    total += n",
      "total = 1\nfor n in nums:\n    total *= n",
      "total = len(nums)",
      "total = nums[0]"
    ],
    "correctIndex": 0,
    "explanation": "合計は初期値0から各要素を足していきます。<br>total += n は total = total + n と同じ意味です。"
  },
  {
    "id": 15,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "python",
    "title": "条件分岐の実行結果",
    "prompt": "次のプログラムを実行したとき、出力される文字列を選びなさい。",
    "code": "x = 7\nif x % 3 == 1:\n    print(\"A\")\nelse:\n    print(\"B\")",
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
    "id": 16,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "python",
    "title": "while文の条件",
    "prompt": "n が 1 になるまで半分にし続けるには、[ ア ] に何を入れればよいですか。",
    "code": "n = 16\nwhile n [ ア ] 1:\n    n = n // 2\nprint(n)",
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
    "id": 17,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "python",
    "title": "リストを順に調べる",
    "prompt": "次のプログラムを実行したとき、print(count) の出力値を選びなさい。",
    "code": "nums = [5, 2, 8, 1, 7]\ncount = 0\nfor n in nums:\n    if n >= 5:\n        count += 1\nprint(count)",
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
    "id": 18,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "標準",
    "langMode": "python",
    "title": "平均値の計算",
    "prompt": "リスト scores の平均値を avg に求めるコードとして正しいものを選びなさい。",
    "code": "scores = [60, 80, 100]\n# avg に平均値を入れる",
    "choices": [
      "avg = sum(scores) / len(scores)",
      "avg = len(scores) / sum(scores)",
      "avg = max(scores) / len(scores)",
      "avg = scores[0] + scores[1] + scores[2]"
    ],
    "correctIndex": 0,
    "explanation": "平均値は「合計 ÷ 個数」です。<br>Pythonでは sum(scores) / len(scores) と書けます。"
  },
  {
    "id": 19,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "標準",
    "langMode": "python",
    "title": "breakまでの回数",
    "prompt": "次のプログラムにおいて、if n == 4: の行は何回判定されますか。",
    "code": "nums = [1, 3, 4, 6]\nfor n in nums:\n    if n == 4:\n        break",
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
    "id": 20,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "python",
    "title": "奇数だけを数える",
    "prompt": "奇数だけ count するには、[ ア ] に何を入れればよいですか。",
    "code": "nums = [1, 2, 3, 4, 5]\ncount = 0\nfor n in nums:\n    if [ ア ]:\n        count += 1\nprint(count)",
    "choices": [
      "n % 2 == 0",
      "n % 2 == 1",
      "n // 2 == 1",
      "n == 2"
    ],
    "correctIndex": 1,
    "explanation": "奇数は2で割った余りが1です。<br>条件は <strong>n % 2 == 1</strong> です。"
  },
  {
    "id": 21,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "python",
    "title": "累積和リスト",
    "prompt": "次のプログラムを実行したとき、print(ans) の出力を選びなさい。",
    "code": "nums = [2, 1, 3]\nans = []\ns = 0\nfor n in nums:\n    s += n\n    ans.append(s)\nprint(ans)",
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
    "id": 22,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "python",
    "title": "最大値の更新条件",
    "prompt": "リストの最大値を mx に求めるには、[ ア ] に何を入れればよいですか。",
    "code": "nums = [4, 9, 2, 7]\nmx = nums[0]\nfor n in nums:\n    if [ ア ]:\n        mx = n\nprint(mx)",
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
    "id": 23,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "発展",
    "langMode": "python",
    "title": "ネストしたifの実行回数",
    "prompt": "次のプログラムにおいて、count += 1 は何回実行されますか。",
    "code": "count = 0\nfor i in range(1, 6):\n    if i % 2 == 1:\n        if i >= 3:\n            count += 1\nprint(count)",
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
    "id": 24,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "発展",
    "langMode": "python",
    "title": "線形探索",
    "prompt": "リスト nums に target が含まれているかを found に入れるコードとして正しいものを選びなさい。",
    "code": "nums = [3, 8, 1, 5]\ntarget = 1\n# found に True または False を入れる",
    "choices": [
      "found = False\nfor n in nums:\n    if n == target:\n        found = True",
      "found = True\nfor n in nums:\n    if n == target:\n        found = False",
      "found = target",
      "found = nums[0]"
    ],
    "correctIndex": 0,
    "explanation": "最初は見つかっていないので False にし、target と同じ要素を見つけたら True にします。"
  },
  {
    "id": 25,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "python",
    "title": "二重ループと合計",
    "prompt": "次のプログラムを実行したとき、print(total) の出力値を選びなさい。",
    "code": "total = 0\nfor i in range(1, 4):\n    for j in range(1, 3):\n        total += i * j\nprint(total)",
    "choices": [
      "6",
      "12",
      "18",
      "24"
    ],
    "correctIndex": 2,
    "explanation": "i=1,2,3、j=1,2 です。<br>合計は 1+2+2+4+3+6 = <strong>18</strong> です。"
  },
  {
    "id": 26,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "python",
    "title": "リスト内包表記",
    "prompt": "nums から偶数だけを取り出したリスト evens を作るには、[ ア ] に何を入れればよいですか。",
    "code": "nums = [1, 2, 3, 4, 5, 6]\nevens = [n for n in nums if [ ア ]]\nprint(evens)",
    "choices": [
      "n % 2 == 0",
      "n % 2 == 1",
      "n > 6",
      "n == 0"
    ],
    "correctIndex": 0,
    "explanation": "偶数は2で割った余りが0です。<br>条件は <strong>n % 2 == 0</strong> です。"
  },
  {
    "id": 27,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "発展",
    "langMode": "python",
    "title": "whileループの回数",
    "prompt": "次のプログラムにおいて、n = n // 2 は何回実行されますか。",
    "code": "n = 20\nwhile n > 1:\n    n = n // 2\nprint(n)",
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
    "id": 28,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "発展",
    "langMode": "python",
    "title": "隣り合う要素の差",
    "prompt": "リスト nums の隣り合う要素の差を diffs に入れるコードとして正しいものを選びなさい。",
    "code": "nums = [3, 7, 10]\n# diffs は [4, 3] にしたい",
    "choices": [
      "diffs = []\nfor i in range(len(nums) - 1):\n    diffs.append(nums[i + 1] - nums[i])",
      "diffs = []\nfor i in range(len(nums)):\n    diffs.append(nums[i] - nums[i + 1])",
      "diffs = nums",
      "diffs = [len(nums)]"
    ],
    "correctIndex": 0,
    "explanation": "隣との差は nums[i + 1] - nums[i] です。<br>最後の要素には次がないので、range(len(nums) - 1) を使います。"
  },
  {
    "id": 29,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "python",
    "title": "条件付きの合計",
    "prompt": "次のプログラムを実行したとき、print(s) の出力値を選びなさい。",
    "code": "nums = [2, 5, 8, 11]\ns = 0\nfor n in nums:\n    if n % 3 == 2:\n        s += n\nprint(s)",
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
    "id": 30,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "python",
    "title": "2次元リストの要素",
    "prompt": "値 6 を取り出して x に代入するには、[ ア ] に何を入れればよいですか。",
    "code": "table = [\n    [1, 2, 3],\n    [4, 5, 6]\n]\nx = table[ ア ]\nprint(x)",
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
    "id": 61,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "python",
    "title": "作業を早く空く担当者へ割り当てる",
    "prompt": "次のプログラムを実行したとき、print(available) の出力として正しいものを選びなさい。",
    "code": "days = [4, 1, 3, 1, 3, 4, 2, 4, 3]\navailable = [1, 1, 1]\n\nfor work in range(len(days)):\n    member = 0\n    for i in range(1, len(available)):\n        if available[i] < available[member]:\n            member = i\n    available[member] = available[member] + days[work]\n\nprint(available)",
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
    "id": 62,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "python",
    "title": "最も早く空く担当者を探す条件",
    "prompt": "作業を最も早く空く担当者に割り当てるには、[ ア ] に入る条件として正しいものを選びなさい。",
    "code": "days = [4, 1, 3, 1, 3, 4]\navailable = [1, 1, 1]\n\nfor work in range(len(days)):\n    member = 0\n    for i in range(1, len(available)):\n        if [ ア ]:\n            member = i\n    available[member] = available[member] + days[work]\n\nprint(available)",
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
    "id": 63,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "python",
    "title": "到着時刻と待ち時間",
    "prompt": "次のプログラムを実行したとき、print(longest) の出力値を選びなさい。",
    "code": "arrival = [0, 3, 4, 10, 11, 12]\nstart = [0] * len(arrival)\nfinish = [0] * len(arrival)\n\nstart[0] = arrival[0]\nfinish[0] = start[0] + 5\n\nfor i in range(1, len(arrival)):\n    start[i] = max(arrival[i], finish[i - 1])\n    finish[i] = start[i] + 5\n\nlongest = 0\nfor i in range(len(arrival)):\n    longest = max(longest, start[i] - arrival[i])\n\nprint(longest)",
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
    "id": 64,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "python",
    "title": "終了時刻を求める式",
    "prompt": "1人あたりの処理時間が service 分のとき、[ ア ] に入る式として正しいものを選びなさい。",
    "code": "arrival = [0, 3, 4, 10]\nservice = 5\nstart = [0] * len(arrival)\nfinish = [0] * len(arrival)\n\nstart[0] = arrival[0]\nfinish[0] = start[0] + service\n\nfor i in range(1, len(arrival)):\n    start[i] = max(arrival[i], finish[i - 1])\n    finish[i] = [ ア ]\n\nprint(finish)",
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
    "id": 65,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "発展",
    "langMode": "python",
    "title": "二重ループと条件判定の実行回数",
    "prompt": "次のプログラムにおいて、count += 1 は何回実行されますか。",
    "code": "count = 0\n\nfor day in range(1, 6):\n    for room in range(3):\n        if (day + room) % 2 == 0:\n            count += 1\n\nprint(count)",
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
    "id": 66,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "発展",
    "langMode": "python",
    "title": "条件を満たす区間数を数える",
    "prompt": "temps の中で、前日より気温が高くなった日数を count に入れるコードとして正しいものを選びなさい。",
    "code": "temps = [22, 24, 23, 27, 29, 28]\n# 前日より高くなった回数を count に入れる",
    "choices": [
      "count = 0\nfor i in range(1, len(temps)):\n    if temps[i] > temps[i - 1]:\n        count += 1",
      "count = 0\nfor i in range(len(temps)):\n    if temps[i] > temps[i + 1]:\n        count += 1",
      "count = 1\nfor i in range(1, len(temps)):\n    if temps[i] < temps[i - 1]:\n        count += 1",
      "count = len(temps)"
    ],
    "correctIndex": 0,
    "explanation": "前日と比較するため、i は1から始めます。<br>比較する式は temps[i] > temps[i - 1] です。"
  },
  {
    "id": 67,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "python",
    "title": "必要数を満たしたグループ数",
    "prompt": "次のプログラムを実行したとき、print(group, filled) の出力として正しいものを選びなさい。",
    "code": "seats = [2, 4, 1, 3, 2]\nneed = [3, 5, 2]\nfilled = [0] * len(need)\ngroup = 0\n\nfor i in range(len(seats)):\n    filled[group] += seats[i]\n    if filled[group] >= need[group]:\n        group += 1\n    if group == len(need):\n        break\n\nprint(group, filled)",
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
    "id": 68,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "python",
    "title": "すべてのグループが完了したら抜ける条件",
    "prompt": "すべてのグループが必要数を満たしたら繰り返しを抜けるには、[ ア ] に何を入れればよいですか。",
    "code": "seats = [2, 4, 1, 3, 2]\nneed = [3, 5, 2]\nfilled = [0] * len(need)\ngroup = 0\n\nfor i in range(len(seats)):\n    filled[group] += seats[i]\n    if filled[group] >= need[group]:\n        group += 1\n    if [ ア ]:\n        break\n\nprint(group)",
    "choices": [
      "group == len(need)",
      "group == len(seats)",
      "filled[group] == 0",
      "i == group"
    ],
    "correctIndex": 0,
    "explanation": "group は完了したグループ数を表します。<br>完了数が need の個数と同じになれば、すべてのグループが完了しています。"
  },
  {
    "id": 69,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "python",
    "title": "2次元リストの行ごとの合計",
    "prompt": "次のプログラムを実行したとき、print(best) の出力値を選びなさい。",
    "code": "table = [\n    [0, 2, 1],\n    [3, 1, 0],\n    [2, 0, 4]\n]\n\nbest = 0\nfor r in range(len(table)):\n    total = 0\n    for c in range(len(table[r])):\n        if table[r][c] > 0:\n            total += table[r][c]\n    if total > best:\n        best = total\n\nprint(best)",
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
    "id": 70,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "発展",
    "langMode": "python",
    "title": "最大値が更新される回数",
    "prompt": "次のプログラムにおいて、best = n は何回実行されますか。",
    "code": "nums = [6, 2, 8, 8, 3, 9]\nbest = 0\ncount = 0\n\nfor n in nums:\n    if n > best:\n        best = n\n        count += 1\n\nprint(best, count)",
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
    "id": 71,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "python",
    "title": "担当者の最短空き日を探す",
    "prompt": "工芸品を、最も早く空く担当者へ順に割り当てる。内側のループで最短の空き日を持つ担当者を選ぶには、[ ア ] に何を入れればよいですか。",
    "code": "work_days = [4, 1, 3, 2, 5, 1]\nfree_day = [1, 1, 1]\n\nfor w in range(len(work_days)):\n    staff = 0\n    for i in range(1, len(free_day)):\n        if [ ア ]:\n            staff = i\n    free_day[staff] = free_day[staff] + work_days[w]\n\nprint(free_day)",
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
    "id": 72,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "python",
    "title": "作業割当後の空き日",
    "prompt": "次のプログラムを実行したとき、print(free_day) の出力として正しいものを選びなさい。",
    "code": "work_days = [2, 5, 1, 4, 3, 2, 4]\nfree_day = [1, 1, 1]\n\nfor w in range(len(work_days)):\n    staff = 0\n    for i in range(1, len(free_day)):\n        if free_day[i] < free_day[staff]:\n            staff = i\n    free_day[staff] = free_day[staff] + work_days[w]\n\nprint(free_day)",
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
    "id": 73,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "python",
    "title": "待ち時間を求める開始時刻",
    "prompt": "1つの窓口で順番に処理する。i番目の人の開始時刻 start[i] を正しく求めるには、[ ア ] に何を入れればよいですか。",
    "code": "arrival = [0, 2, 4, 9, 11]\nservice = 5\nstart = [0] * len(arrival)\nfinish = [0] * len(arrival)\n\nstart[0] = arrival[0]\nfinish[0] = start[0] + service\n\nfor i in range(1, len(arrival)):\n    start[i] = [ ア ]\n    finish[i] = start[i] + service\n\nprint(start)",
    "choices": [
      "max(arrival[i], finish[i - 1])",
      "min(arrival[i], finish[i - 1])",
      "arrival[i] + service",
      "finish[i - 1] - service",
      "max(arrival[i - 1], finish[i])",
      "arrival[i - 1] + finish[i - 1]"
    ],
    "correctIndex": 0,
    "explanation": "その人が到着していて、かつ前の人の処理が終わっていないと開始できません。<br>よって開始時刻は「到着時刻」と「直前の終了時刻」の大きい方、つまり <strong>max(arrival[i], finish[i - 1])</strong> です。"
  },
  {
    "id": 74,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "python",
    "title": "最長待ち時間を求める",
    "prompt": "次のプログラムを実行したとき、print(longest) の出力値として正しいものを選びなさい。",
    "code": "arrival = [0, 3, 6, 7, 15, 16]\nservice = 4\nstart = [0] * len(arrival)\nfinish = [0] * len(arrival)\n\nstart[0] = arrival[0]\nfinish[0] = start[0] + service\n\nfor i in range(1, len(arrival)):\n    start[i] = max(arrival[i], finish[i - 1])\n    finish[i] = start[i] + service\n\nlongest = 0\nfor i in range(len(arrival)):\n    wait = start[i] - arrival[i]\n    if wait > longest:\n        longest = wait\n\nprint(longest)",
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
    "id": 75,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "発展",
    "langMode": "python",
    "title": "条件を満たす組の数",
    "prompt": "次のプログラムで、count += 1 は何回実行されますか。",
    "code": "scores = [\n    [2, 0, 1],\n    [0, 3, 2],\n    [4, 1, 0]\n]\ncount = 0\n\nfor r in range(len(scores)):\n    for c in range(len(scores[r])):\n        if scores[r][c] >= 2:\n            count += 1\n\nprint(count)",
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
    "id": 76,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "python",
    "title": "累積人数が定員を超える時点",
    "prompt": "次のプログラムを実行したとき、print(day) の出力値として正しいものを選びなさい。",
    "code": "visitors = [18, 22, 15, 30, 12, 20]\nlimit = 70\ntotal = 0\nday = -1\n\nfor i in range(len(visitors)):\n    total += visitors[i]\n    if total >= limit and day == -1:\n        day = i\n\nprint(day)",
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
    "id": 77,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "python",
    "title": "初めて条件を満たした位置だけを記録する",
    "prompt": "target 以上になった最初の添字だけを pos に入れるには、[ ア ] に何を入れればよいですか。",
    "code": "points = [12, 8, 15, 6, 20]\ntarget = 30\ntotal = 0\npos = -1\n\nfor i in range(len(points)):\n    total += points[i]\n    if total >= target and [ ア ]:\n        pos = i\n\nprint(pos)",
    "choices": [
      "pos == -1",
      "pos == i",
      "pos >= 0",
      "total == 0",
      "points[i] == target",
      "i == 0",
      "target < 0",
      "len(points) == pos"
    ],
    "correctIndex": 0,
    "explanation": "pos は「まだ記録していない」ことを -1 で表しています。<br>一度 pos に添字を入れた後は更新したくないので、条件に <strong>pos == -1</strong> を加えます。"
  },
  {
    "id": 78,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "python",
    "title": "区間の長さの最大値",
    "prompt": "次のプログラムを実行したとき、print(longest) の出力値として正しいものを選びなさい。",
    "code": "busy = [1, 1, 0, 1, 1, 1, 0, 1]\nnow = 0\nlongest = 0\n\nfor i in range(len(busy)):\n    if busy[i] == 1:\n        now += 1\n        if now > longest:\n            longest = now\n    else:\n        now = 0\n\nprint(longest)",
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
    "id": 79,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "python",
    "title": "2次元リストの列合計",
    "prompt": "各列の合計を col_sum に入れる。空欄 [ ア ] に入る式として正しいものを選びなさい。",
    "code": "table = [\n    [3, 1, 4],\n    [2, 5, 0],\n    [1, 2, 6]\n]\ncol_sum = [0, 0, 0]\n\nfor r in range(len(table)):\n    for c in range(len(table[r])):\n        col_sum[c] += [ ア ]\n\nprint(col_sum)",
    "choices": [
      "table[r][c]",
      "table[c][r]",
      "table[r]",
      "table[c]",
      "col_sum[r]",
      "col_sum[c]",
      "r + c",
      "len(table[c])"
    ],
    "correctIndex": 0,
    "explanation": "r行c列の値を、c列目の合計 col_sum[c] に足します。<br>参照する値は <strong>table[r][c]</strong> です。"
  },
  {
    "id": 80,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "python",
    "title": "列合計の最大値",
    "prompt": "次のプログラムを実行したとき、print(best) の出力値として正しいものを選びなさい。",
    "code": "table = [\n    [3, 1, 4],\n    [2, 5, 0],\n    [1, 2, 6]\n]\ncol_sum = [0, 0, 0]\n\nfor r in range(len(table)):\n    for c in range(len(table[r])):\n        col_sum[c] += table[r][c]\n\nbest = 0\nfor x in col_sum:\n    if x > best:\n        best = x\n\nprint(best)",
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
    "id": 91,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "python",
    "title": "偶数番目の要素を合計する",
    "prompt": "添字が偶数の要素だけを total に加えるには、[ ア ] に何を入れればよいですか。",
    "code": "nums = [5, 8, 3, 6, 7, 2]\ntotal = 0\n\nfor i in range(len(nums)):\n    if [ ア ]:\n        total += nums[i]\n\nprint(total)",
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
    "id": 92,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "python",
    "title": "条件によって足すか引くかを変える",
    "prompt": "次のプログラムを実行したとき、print(total) の出力値として正しいものを選びなさい。",
    "code": "nums = [4, 1, 7, 2, 5]\ntotal = 0\n\nfor n in nums:\n    if n >= 5:\n        total += n\n    else:\n        total -= n\n\nprint(total)",
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
    "id": 93,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "標準",
    "langMode": "python",
    "title": "2つの条件を同時に満たす回数",
    "prompt": "次のプログラムで、count += 1 は何回実行されますか。",
    "code": "nums = [2, 5, 8, 11, 14, 17]\ncount = 0\n\nfor n in nums:\n    if n % 3 == 2 and n > 10:\n        count += 1\n\nprint(count)",
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
    "id": 94,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "python",
    "title": "在庫の残りと少ない商品の数",
    "prompt": "次のプログラムを実行したとき、print(remain, count) の出力として正しいものを選びなさい。",
    "code": "stock = [12, 9, 15, 7, 10]\nsold = [3, 4, 5, 2, 6]\nremain = []\ncount = 0\n\nfor i in range(len(stock)):\n    remain.append(stock[i] - sold[i])\n    if remain[i] < 8:\n        count += 1\n\nprint(remain, count)",
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
    "id": 95,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "python",
    "title": "前日より増えた日を数える",
    "prompt": "前の値より大きくなった回数を数えるには、[ ア ] に何を入れればよいですか。",
    "code": "temps = [18, 20, 19, 22, 22, 25]\ncount = 0\n\nfor i in range(1, len(temps)):\n    if [ ア ]:\n        count += 1\n\nprint(count)",
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
    "id": 96,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "python",
    "title": "指定された箱の数を増やす",
    "prompt": "次のプログラムを実行したとき、print(boxes) の出力として正しいものを選びなさい。",
    "code": "boxes = [3, 0, 2]\nmoves = [1, 2, 0, 1]\n\nfor m in moves:\n    boxes[m] += 1\n\nprint(boxes)",
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
    "id": 97,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "python",
    "title": "隣り合う要素を比較する範囲",
    "prompt": "data[i] と data[i + 1] を安全に比較するには、[ ア ] に何を入れればよいですか。",
    "code": "data = [3, 5, 4, 6, 8]\npos = -1\n\nfor i in [ ア ]:\n    if data[i] > data[i + 1]:\n        pos = i\n        break\n\nprint(pos)",
    "choices": [
      "range(len(data) - 1)",
      "range(len(data))",
      "range(1, len(data))",
      "range(len(data) + 1)",
      "range(data[i])",
      "range(0)",
      "range(pos)",
      "range(len(pos))"
    ],
    "correctIndex": 0,
    "explanation": "data[i + 1] を使うため、i は最後の添字まで進めてはいけません。<br>最後に使える i は len(data)-2 なので、範囲は <strong>range(len(data) - 1)</strong> です。"
  },
  {
    "id": 98,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "python",
    "title": "余りごとの個数を数える",
    "prompt": "次のプログラムを実行したとき、print(bucket) の出力として正しいものを選びなさい。",
    "code": "nums = [5, 8, 10, 12, 14, 17, 21]\nbucket = [0, 0, 0]\n\nfor n in nums:\n    bucket[n % 3] += 1\n\nprint(bucket)",
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
    "id": 99,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "標準",
    "langMode": "python",
    "title": "値を半分にする繰り返し",
    "prompt": "次のプログラムで、count += 1 は何回実行されますか。",
    "code": "x = 48\ncount = 0\n\nwhile x > 5:\n    x = x // 2\n    count += 1\n\nprint(x, count)",
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
    "id": 100,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "python",
    "title": "目標に達したら繰り返しを止める",
    "prompt": "合計が target 以上になった時点で繰り返しを止めるには、[ ア ] に何を入れればよいですか。",
    "code": "items = [4, 7, 3, 6, 5]\ntarget = 18\ntotal = 0\nused = 0\n\nfor i in range(len(items)):\n    total += items[i]\n    used += 1\n    if [ ア ]:\n        break\n\nprint(used)",
    "choices": [
      "total >= target",
      "total < target",
      "items[i] == target",
      "used == 0",
      "i == len(items)",
      "items[i] > total",
      "target < 0",
      "total == items[i]"
    ],
    "correctIndex": 0,
    "explanation": "繰り返しを止めたいのは、ここまでの合計 total が目標 target に達したときです。<br>したがって条件は <strong>total >= target</strong> です。"
  },
  {
    "id": 111,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "基礎",
    "langMode": "python",
    "title": "リストから指定の値を取り出す",
    "prompt": "x に 18 を代入するには、[ ア ] に入る値として正しいものを選びなさい。",
    "code": "scores = [12, 15, 18, 20]\nx = scores[[ ア ]]\nprint(x)",
    "choices": [
      "0",
      "1",
      "2",
      "3",
      "4",
      "18"
    ],
    "correctIndex": 2,
    "explanation": "Python のリストは添字が0から始まります。<br>scores[0]=12, scores[1]=15, scores[2]=18 なので、18を取り出す添字は <strong>2</strong> です。"
  },
  {
    "id": 112,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "python",
    "title": "変数の値を更新する",
    "prompt": "次のプログラムを実行したとき、print(x) の出力値として正しいものを選びなさい。",
    "code": "x = 6\nx = x + 3\nx = x * 2\nprint(x)",
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
    "id": 113,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "基礎",
    "langMode": "python",
    "title": "for文の繰り返し回数",
    "prompt": "次のプログラムで、total += i は何回実行されますか。",
    "code": "total = 0\n\nfor i in range(2, 7):\n    total += i\n\nprint(total)",
    "choices": [
      "2回",
      "3回",
      "4回",
      "5回",
      "6回",
      "7回"
    ],
    "correctIndex": 3,
    "explanation": "range(2, 7) では、i は 2, 3, 4, 5, 6 と変化します。<br>したがって total += i は <strong>5回</strong> 実行されます。"
  },
  {
    "id": 114,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "python",
    "title": "条件を満たす値だけを足す",
    "prompt": "次のプログラムを実行したとき、print(total) の出力値として正しいものを選びなさい。",
    "code": "nums = [3, 8, 5, 10, 2]\ntotal = 0\n\nfor n in nums:\n    if n >= 5:\n        total += n\n\nprint(total)",
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
    "id": 115,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "基礎",
    "langMode": "python",
    "title": "合計を求める代入文",
    "prompt": "リストの値を順に total に加えるには、[ ア ] に何を入れればよいですか。",
    "code": "nums = [2, 4, 6]\ntotal = 0\n\nfor n in nums:\n    [ ア ]\n\nprint(total)",
    "choices": [
      "total += n",
      "total = n",
      "n += total",
      "total -= n",
      "print(n)",
      "nums += n"
    ],
    "correctIndex": 0,
    "explanation": "total に n を加えて更新するので、代入文は <strong>total += n</strong> です。<br>これは total = total + n と同じ意味です。"
  },
  {
    "id": 116,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "python",
    "title": "リストの値を1つだけ更新する",
    "prompt": "次のプログラムを実行したとき、print(data) の出力として正しいものを選びなさい。",
    "code": "data = [4, 7, 1, 9]\ndata[2] = data[2] + 5\nprint(data)",
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
    "explanation": "data[2] は3番目の値で、最初は1です。<br>1+5=6 になるので、リストは <strong>[4, 7, 6, 9]</strong> になります。"
  },
  {
    "id": 117,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "基礎",
    "langMode": "python",
    "title": "リスト全体を添字で調べる",
    "prompt": "リストの全要素を添字 i で順に調べるには、[ ア ] に何を入れればよいですか。",
    "code": "data = [6, 2, 9, 4]\ntotal = 0\n\nfor i in [ ア ]:\n    total += data[i]\n\nprint(total)",
    "choices": [
      "range(len(data))",
      "range(len(data) - 1)",
      "range(1, len(data))",
      "range(data)",
      "range(total)",
      "range(0)",
      "range(len(i))",
      "range(data[i])"
    ],
    "correctIndex": 0,
    "explanation": "添字は 0 から len(data)-1 までです。<br>その範囲を順に作るには <strong>range(len(data))</strong> を使います。"
  },
  {
    "id": 118,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "python",
    "title": "偶数だけを数える",
    "prompt": "次のプログラムを実行したとき、print(count) の出力値として正しいものを選びなさい。",
    "code": "nums = [1, 4, 6, 7, 10]\ncount = 0\n\nfor n in nums:\n    if n % 2 == 0:\n        count += 1\n\nprint(count)",
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
    "id": 119,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "基礎",
    "langMode": "python",
    "title": "条件が成り立つ回数",
    "prompt": "次のプログラムで、count += 1 は何回実行されますか。",
    "code": "scores = [45, 80, 62, 59, 70]\ncount = 0\n\nfor s in scores:\n    if s >= 60:\n        count += 1\n\nprint(count)",
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
    "id": 120,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "python",
    "title": "文字列を条件で数える",
    "prompt": "次のプログラムを実行したとき、print(count) の出力値として正しいものを選びなさい。",
    "code": "letters = [\"A\", \"B\", \"A\", \"C\", \"A\"]\ncount = 0\n\nfor x in letters:\n    if x == \"A\":\n        count += 1\n\nprint(count)",
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
