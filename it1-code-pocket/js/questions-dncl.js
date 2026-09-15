// This file is generated from the original QUESTIONS data split by langMode.
const DNCL_QUESTIONS = [
  {
    "id": 31,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "基礎",
    "langMode": "dncl",
    "title": "配列の添字と出力値",
    "prompt": "次のプログラムの [ ア ] に入る値として正しいものを選びなさい。（x には 10 を代入したい）",
    "code": "Data = [5, 10, 15, 20]\nx = Data[[ ア ]]\n表示する(x)",
    "choices": [
      "0",
      "1",
      "2",
      "3"
    ],
    "correctIndex": 1,
    "explanation": "共通テスト用プログラム表記では、特に説明がなければ配列の添字は【0】から始まります。<br>Data[0]=5, Data[1]=<strong>10</strong>, Data[2]=15 …<br>10 を取り出すには添字 <strong>1</strong> が必要です。"
  },
  {
    "id": 32,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "dncl",
    "title": "変数への代入と計算",
    "prompt": "次のプログラムを実行したとき、表示される値を選びなさい。",
    "code": "x = 3\nx = x + 4\n表示する(x)",
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
    "id": 33,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "基礎",
    "langMode": "dncl",
    "title": "条件分岐の条件",
    "prompt": "score が 60 以上のときに「合格」と表示するには、[ ア ] に何を入れればよいですか。",
    "code": "score = 75\nもし score [ ア ] 60 ならば:\n⎿ 表示する(\"合格\")",
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
    "id": 34,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "基礎",
    "langMode": "dncl",
    "title": "表示する関数の実行回数",
    "prompt": "次のプログラムにおいて、表示する(i) は何回実行されますか。",
    "code": "i を 0 から 3 まで 1 ずつ増やしながら繰り返す:\n⎿ 表示する(i)",
    "choices": [
      "3回",
      "4回",
      "5回",
      "0回"
    ],
    "correctIndex": 1,
    "explanation": "i は 0,1,2,3 の4個の値を取ります。<br>そのため 表示する(i) は <strong>4回</strong> 実行されます。"
  },
  {
    "id": 35,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "dncl",
    "title": "文字列の連結",
    "prompt": "次のプログラムを実行したとき、出力される文字列を選びなさい。",
    "code": "a = \"情報\"\nb = \"I\"\n表示する(a + b)",
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
    "id": 36,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "基礎",
    "langMode": "dncl",
    "title": "偶数判定の表記",
    "prompt": "変数 n が偶数のときだけ「偶数」と表示するプログラム表記として正しいものを選びなさい。",
    "code": "n = 8\n# n が偶数なら「偶数」と表示する",
    "choices": [
      "もし n ％ 2 == 0 ならば:\n⎿ 表示する(\"偶数\")",
      "もし n ÷ 2 == 0 ならば:\n⎿ 表示する(\"偶数\")",
      "もし n ％ 2 == 1 ならば:\n⎿ 表示する(\"偶数\")",
      "もし n == 2 ならば:\n⎿ 表示する(\"偶数\")"
    ],
    "correctIndex": 0,
    "explanation": "偶数は2で割った余りが0の数です。<br>共通テスト用プログラム表記では余りを <strong>％</strong> で表し、n ％ 2 == 0 が正解です。"
  },
  {
    "id": 37,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "dncl",
    "title": "配列要素の更新",
    "prompt": "次のプログラムを実行したとき、表示される値を選びなさい。",
    "code": "Nums = [2, 4, 6]\nNums[1] = Nums[1] + 3\n表示する(Nums[1])",
    "choices": [
      "4",
      "5",
      "7",
      "9"
    ],
    "correctIndex": 2,
    "explanation": "添字は0始まりなので Nums[1] は2番目の要素 4 です。<br>4 + 3 = <strong>7</strong> に更新されます。"
  },
  {
    "id": 38,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "基礎",
    "langMode": "dncl",
    "title": "繰り返し回数の穴埋め",
    "prompt": "「Hello」を5回表示するには、[ ア ] に何を入れればよいですか。",
    "code": "i を 0 から [ ア ] まで 1 ずつ増やしながら繰り返す:\n⎿ 表示する(\"Hello\")",
    "choices": [
      "4",
      "5",
      "6",
      "10"
    ],
    "correctIndex": 0,
    "explanation": "0から4まで繰り返すと、0,1,2,3,4 の <strong>5回</strong> 実行されます。"
  },
  {
    "id": 39,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "基礎",
    "langMode": "dncl",
    "title": "条件を満たす回数",
    "prompt": "次のプログラムにおいて、count = count + 1 は何回実行されますか。",
    "code": "count = 0\ni を 0 から 4 まで 1 ずつ増やしながら繰り返す:\n｜もし i >= 2 ならば:\n⎿⎿ count = count + 1\n表示する(count)",
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
    "id": 40,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "基礎",
    "langMode": "dncl",
    "title": "最大値の取り出し",
    "prompt": "配列 Nums の中から最大値を表示するプログラム表記として正しいものを選びなさい。",
    "code": "Nums = [3, 9, 1, 6]\n# 最大値を表示する",
    "choices": [
      "表示する(最大値(Nums))",
      "表示する(最小値(Nums))",
      "表示する(要素数(Nums))",
      "表示する(Nums[0])"
    ],
    "correctIndex": 0,
    "explanation": "最大値を求めるには 最大値(Nums) を使います。<br>この配列の最大値は <strong>9</strong> です。"
  },
  {
    "id": 41,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "dncl",
    "title": "繰り返しの開始と終了",
    "prompt": "次のプログラムを実行したとき、表示される値を選びなさい。",
    "code": "s = 0\ni を 1 から 4 まで 1 ずつ増やしながら繰り返す:\n⎿ s = s + i\n表示する(s)",
    "choices": [
      "6",
      "10",
      "15",
      "5"
    ],
    "correctIndex": 1,
    "explanation": "i は 1,2,3,4 です。<br>合計は 1+2+3+4 = <strong>10</strong> です。"
  },
  {
    "id": 42,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "dncl",
    "title": "配列の要素数",
    "prompt": "配列 Items の要素数を n に代入するには、[ ア ] に何を入れればよいですか。",
    "code": "Items = [\"A\", \"B\", \"C\"]\nn = [ ア ]\n表示する(n)",
    "choices": [
      "Items.size",
      "要素数(Items)",
      "count(Items)",
      "Items[3]"
    ],
    "correctIndex": 1,
    "explanation": "共通テスト用プログラム表記では、配列の要素数は <strong>要素数(Items)</strong> で求められます。"
  },
  {
    "id": 43,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "標準",
    "langMode": "dncl",
    "title": "二重ループの実行回数",
    "prompt": "次のプログラムにおいて、表示する(i, j) は何回実行されますか。",
    "code": "i を 1 から 3 まで 1 ずつ増やしながら繰り返す:\n｜j を 1 から 2 まで 1 ずつ増やしながら繰り返す:\n⎿⎿ 表示する(i, j)",
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
    "id": 44,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "標準",
    "langMode": "dncl",
    "title": "配列の合計",
    "prompt": "配列 Nums の全要素の合計を total に求めるプログラム表記として正しいものを選びなさい。",
    "code": "Nums = [1, 2, 3, 4]\n# total に合計を入れる",
    "choices": [
      "total = 0\ni を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:\n⎿ total = total + Nums[i]",
      "total = 1\ni を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:\n⎿ total = total × Nums[i]",
      "total = 要素数(Nums)",
      "total = Nums[0]"
    ],
    "correctIndex": 0,
    "explanation": "合計は初期値0から各要素を足していきます。<br>配列は0始まりなので、i は 0 から 要素数(Nums) - 1 まで動かします。"
  },
  {
    "id": 45,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "dncl",
    "title": "条件分岐の実行結果",
    "prompt": "次のプログラムを実行したとき、出力される文字列を選びなさい。",
    "code": "x = 7\nもし x ％ 3 == 1 ならば:\n｜表示する(\"A\")\nそうでなければ:\n⎿ 表示する(\"B\")",
    "choices": [
      "A",
      "B",
      "AB",
      "何も表示されない"
    ],
    "correctIndex": 0,
    "explanation": "7を3で割った余りは1です。<br>条件 x ％ 3 == 1 が真なので <strong>A</strong> が表示されます。"
  },
  {
    "id": 46,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "dncl",
    "title": "条件繰返しの条件",
    "prompt": "n が 1 になるまで半分にし続けるには、[ ア ] に何を入れればよいですか。",
    "code": "n = 16\nn [ ア ] 1 の間繰り返す:\n⎿ n = n ÷ 2\n表示する(n)",
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
    "id": 47,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "dncl",
    "title": "配列を順に調べる",
    "prompt": "次のプログラムを実行したとき、表示される値を選びなさい。",
    "code": "Nums = [5, 2, 8, 1, 7]\ncount = 0\ni を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし Nums[i] >= 5 ならば:\n⎿⎿ count = count + 1\n表示する(count)",
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
    "id": 48,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "標準",
    "langMode": "dncl",
    "title": "平均値の計算",
    "prompt": "配列 Scores の平均値を avg に求めるプログラム表記として正しいものを選びなさい。",
    "code": "Scores = [60, 80, 100]\n# avg に平均値を入れる",
    "choices": [
      "avg = 合計(Scores) ÷ 要素数(Scores)",
      "avg = 要素数(Scores) ÷ 合計(Scores)",
      "avg = 最大値(Scores) ÷ 要素数(Scores)",
      "avg = Scores[0] + Scores[1] + Scores[2]"
    ],
    "correctIndex": 0,
    "explanation": "平均値は「合計 ÷ 個数」です。<br>よって 合計(Scores) ÷ 要素数(Scores) が正解です。"
  },
  {
    "id": 49,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "標準",
    "langMode": "dncl",
    "title": "繰り返しを抜けるまでの回数",
    "prompt": "次のプログラムにおいて、もし Nums[i] == 4 ならば の行は何回判定されますか。",
    "code": "Nums = [1, 3, 4, 6]\ni を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし Nums[i] == 4 ならば:\n⎿⎿ 繰り返しを抜ける",
    "choices": [
      "1回",
      "2回",
      "3回",
      "4回"
    ],
    "correctIndex": 2,
    "explanation": "Nums[0]=1, Nums[1]=3, Nums[2]=4 の順に調べます。<br>4で抜けるため、条件判定は <strong>3回</strong> です。"
  },
  {
    "id": 50,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "dncl",
    "title": "奇数だけを数える",
    "prompt": "奇数だけ count するには、[ ア ] に何を入れればよいですか。",
    "code": "Nums = [1, 2, 3, 4, 5]\ncount = 0\ni を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし [ ア ] ならば:\n⎿⎿ count = count + 1\n表示する(count)",
    "choices": [
      "Nums[i] ％ 2 == 0",
      "Nums[i] ％ 2 == 1",
      "Nums[i] ÷ 2 == 1",
      "Nums[i] == 2"
    ],
    "correctIndex": 1,
    "explanation": "奇数は2で割った余りが1です。<br>条件は <strong>Nums[i] ％ 2 == 1</strong> です。"
  },
  {
    "id": 51,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "累積和配列",
    "prompt": "次のプログラムを実行したとき、表示される値を選びなさい。",
    "code": "Nums = [2, 1, 3]\nAns = []\ns = 0\ni を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:\n｜s = s + Nums[i]\n⎿ Ans の末尾に s を追加する\n表示する(Ans)",
    "choices": [
      "[2, 1, 3]",
      "[2, 3, 6]",
      "[0, 2, 3]",
      "[6]"
    ],
    "correctIndex": 1,
    "explanation": "s は 2 → 3 → 6 と増え、その都度 Ans に追加されます。<br>結果は <strong>[2, 3, 6]</strong> です。"
  },
  {
    "id": 52,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "最大値の更新条件",
    "prompt": "配列の最大値を mx に求めるには、[ ア ] に何を入れればよいですか。",
    "code": "Nums = [4, 9, 2, 7]\nmx = Nums[0]\ni を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし [ ア ] ならば:\n⎿⎿ mx = Nums[i]\n表示する(mx)",
    "choices": [
      "Nums[i] > mx",
      "Nums[i] < mx",
      "Nums[i] == mx",
      "mx > Nums[i]"
    ],
    "correctIndex": 0,
    "explanation": "今までの最大値 mx より Nums[i] が大きいときだけ更新します。<br>条件は <strong>Nums[i] > mx</strong> です。"
  },
  {
    "id": 53,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "入れ子の条件分岐の実行回数",
    "prompt": "次のプログラムにおいて、count = count + 1 は何回実行されますか。",
    "code": "count = 0\ni を 1 から 5 まで 1 ずつ増やしながら繰り返す:\n｜もし i ％ 2 == 1 ならば:\n｜｜もし i >= 3 ならば:\n⎿⎿⎿ count = count + 1\n表示する(count)",
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
    "id": 54,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "線形探索",
    "prompt": "配列 Nums に target が含まれているかを found に入れるプログラム表記として正しいものを選びなさい。",
    "code": "Nums = [3, 8, 1, 5]\ntarget = 1\n# found に True または False を入れる",
    "choices": [
      "found = False\ni を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし Nums[i] == target ならば:\n⎿⎿ found = True",
      "found = True\ni を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし Nums[i] == target ならば:\n⎿⎿ found = False",
      "found = target",
      "found = Nums[0]"
    ],
    "correctIndex": 0,
    "explanation": "最初は見つかっていないので False にし、target と同じ要素を見つけたら True にします。"
  },
  {
    "id": 55,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "二重ループと合計",
    "prompt": "次のプログラムを実行したとき、表示される値を選びなさい。",
    "code": "total = 0\ni を 1 から 3 まで 1 ずつ増やしながら繰り返す:\n｜j を 1 から 2 まで 1 ずつ増やしながら繰り返す:\n⎿⎿ total = total + i × j\n表示する(total)",
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
    "id": 56,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "偶数だけの配列",
    "prompt": "Nums から偶数だけを取り出した配列 Evens を作るには、[ ア ] に何を入れればよいですか。",
    "code": "Nums = [1, 2, 3, 4, 5, 6]\nEvens = []\ni を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし [ ア ] ならば:\n⎿⎿ Evens の末尾に Nums[i] を追加する\n表示する(Evens)",
    "choices": [
      "Nums[i] ％ 2 == 0",
      "Nums[i] ％ 2 == 1",
      "Nums[i] > 6",
      "Nums[i] == 0"
    ],
    "correctIndex": 0,
    "explanation": "偶数は2で割った余りが0です。<br>条件は <strong>Nums[i] ％ 2 == 0</strong> です。"
  },
  {
    "id": 57,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "条件繰返しの回数",
    "prompt": "次のプログラムにおいて、n = n ÷ 2 は何回実行されますか。",
    "code": "n = 20\nn > 1 の間繰り返す:\n⎿ n = n ÷ 2\n表示する(n)",
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
    "id": 58,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "隣り合う要素の差",
    "prompt": "配列 Nums の隣り合う要素の差を Diffs に入れるプログラム表記として正しいものを選びなさい。",
    "code": "Nums = [3, 7, 10]\n# Diffs は [4, 3] にしたい",
    "choices": [
      "Diffs = []\ni を 0 から 要素数(Nums) - 2 まで 1 ずつ増やしながら繰り返す:\n⎿ Diffs の末尾に Nums[i + 1] - Nums[i] を追加する",
      "Diffs = []\ni を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:\n⎿ Diffs の末尾に Nums[i] - Nums[i + 1] を追加する",
      "Diffs = Nums",
      "Diffs = [要素数(Nums)]"
    ],
    "correctIndex": 0,
    "explanation": "隣との差は Nums[i + 1] - Nums[i] です。<br>最後の要素には次がないので、i は 要素数(Nums) - 2 まで繰り返します。"
  },
  {
    "id": 59,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "条件付きの合計",
    "prompt": "次のプログラムを実行したとき、表示される値を選びなさい。",
    "code": "Nums = [2, 5, 8, 11]\ns = 0\ni を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし Nums[i] ％ 3 == 2 ならば:\n⎿⎿ s = s + Nums[i]\n表示する(s)",
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
    "id": 60,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "2次元配列の要素",
    "prompt": "値 6 を取り出して x に代入するには、[ ア ] に何を入れればよいですか。",
    "code": "Table = [\n    [1, 2, 3],\n    [4, 5, 6]\n]\nx = Table[ ア ]\n表示する(x)",
    "choices": [
      "[0,2]",
      "[1,2]",
      "[2,1]",
      "[1,3]"
    ],
    "correctIndex": 1,
    "explanation": "2次元配列は Table[行,列] の形で表します。添字は0始まりなので、2行目・3列目は <strong>Table[1,2]</strong> です。"
  },
  {
    "id": 81,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "担当者の最短空き日を探す",
    "prompt": "品物を、最も早く空く担当者へ順に割り当てる。内側の繰り返しで最短の空き日を持つ担当者を選ぶには、[ ア ] に何を入れればよいですか。",
    "code": "Work = [4, 1, 3, 2, 5, 1]\nFree = [1, 1, 1]\n\nw を 0 から 要素数(Work) - 1 まで 1 ずつ増やしながら繰り返す:\n｜staff = 0\n｜i を 1 から 要素数(Free) - 1 まで 1 ずつ増やしながら繰り返す:\n｜｜もし [ ア ] ならば:\n｜⎿⎿ staff = i\n⎿ Free[staff] = Free[staff] + Work[w]\n\n表示する(Free)",
    "choices": [
      "Free[i] < Free[staff]",
      "Free[i] > Free[staff]",
      "Work[i] < Work[staff]",
      "i < staff",
      "Free[staff] < Work[w]",
      "Work[w] < Free[i]"
    ],
    "correctIndex": 0,
    "explanation": "staff は「今のところ最も早く空く担当者」の添字です。<br>候補 i の空き日 Free[i] が、現在の staff の空き日 Free[staff] より小さいときに staff を更新します。よって <strong>Free[i] < Free[staff]</strong> が入ります。"
  },
  {
    "id": 82,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "作業割当後の空き日",
    "prompt": "次のプログラムを実行したとき、表示される Free として正しいものを選びなさい。",
    "code": "Work = [2, 5, 1, 4, 3, 2, 4]\nFree = [1, 1, 1]\n\nw を 0 から 要素数(Work) - 1 まで 1 ずつ増やしながら繰り返す:\n｜staff = 0\n｜i を 1 から 要素数(Free) - 1 まで 1 ずつ増やしながら繰り返す:\n｜｜もし Free[i] < Free[staff] ならば:\n｜⎿⎿ staff = i\n⎿ Free[staff] = Free[staff] + Work[w]\n\n表示する(Free)",
    "choices": [
      "[8, 10, 6]",
      "[9, 8, 5]",
      "[7, 7, 8]",
      "[10, 5, 7]",
      "[6, 9, 7]",
      "[9, 5, 8]"
    ],
    "correctIndex": 0,
    "explanation": "Free は担当者が次に空く日を表します。<br>同じ空き日の担当者が複数いる場合、このプログラムでは添字の小さい担当者が選ばれます。順に追うと、[1,1,1] → [3,1,1] → [3,6,1] → [3,6,2] → [3,6,6] → [6,6,6] → [8,6,6] → <strong>[8,10,6]</strong> です。"
  },
  {
    "id": 83,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "待ち時間を求める開始時刻",
    "prompt": "1つの窓口で順番に処理する。i番目の人の開始時刻 Start[i] を正しく求めるには、[ ア ] に何を入れればよいですか。",
    "code": "Arrive = [0, 2, 4, 9, 11]\nservice = 5\nStart = [0, 0, 0, 0, 0]\nFinish = [0, 0, 0, 0, 0]\n\nStart[0] = Arrive[0]\nFinish[0] = Start[0] + service\n\ni を 1 から 要素数(Arrive) - 1 まで 1 ずつ増やしながら繰り返す:\n｜Start[i] = [ ア ]\n⎿ Finish[i] = Start[i] + service\n\n表示する(Start)",
    "choices": [
      "最大値(Arrive[i], Finish[i - 1])",
      "最小値(Arrive[i], Finish[i - 1])",
      "Arrive[i] + service",
      "Finish[i - 1] - service",
      "最大値(Arrive[i - 1], Finish[i])",
      "Arrive[i - 1] + Finish[i - 1]"
    ],
    "correctIndex": 0,
    "explanation": "その人が到着していて、前の人の処理も終わっている必要があります。<br>したがって開始時刻は「到着時刻」と「直前の終了時刻」の大きい方、つまり <strong>最大値(Arrive[i], Finish[i - 1])</strong> です。"
  },
  {
    "id": 84,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "最長待ち時間を求める",
    "prompt": "次のプログラムを実行したとき、表示される longest の値として正しいものを選びなさい。",
    "code": "Arrive = [0, 3, 6, 7, 15, 16]\nservice = 4\nStart = [0, 0, 0, 0, 0, 0]\nFinish = [0, 0, 0, 0, 0, 0]\n\nStart[0] = Arrive[0]\nFinish[0] = Start[0] + service\n\ni を 1 から 要素数(Arrive) - 1 まで 1 ずつ増やしながら繰り返す:\n｜Start[i] = 最大値(Arrive[i], Finish[i - 1])\n⎿ Finish[i] = Start[i] + service\n\nlongest = 0\ni を 0 から 要素数(Arrive) - 1 まで 1 ずつ増やしながら繰り返す:\n｜wait = Start[i] - Arrive[i]\n｜もし wait > longest ならば:\n⎿⎿ longest = wait\n\n表示する(longest)",
    "choices": [
      "0",
      "1",
      "2",
      "3",
      "4",
      "5"
    ],
    "correctIndex": 5,
    "explanation": "Start は [0,4,8,12,16,20] になります。<br>待ち時間は [0,1,2,5,1,4] なので、最大は 12-7=<strong>5</strong> です。"
  },
  {
    "id": 85,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "条件を満たす表の要素数",
    "prompt": "次のプログラムで、count = count + 1 は何回実行されますか。",
    "code": "Score = [\n  [2, 0, 1],\n  [0, 3, 2],\n  [4, 1, 0]\n]\ncount = 0\n\nr を 0 から 要素数(Score) - 1 まで 1 ずつ増やしながら繰り返す:\n｜c を 0 から 要素数(Score[r]) - 1 まで 1 ずつ増やしながら繰り返す:\n｜｜もし Score[r][c] >= 2 ならば:\n⎿⎿⎿ count = count + 1\n\n表示する(count)",
    "choices": [
      "2回",
      "3回",
      "4回",
      "5回",
      "6回",
      "9回"
    ],
    "correctIndex": 2,
    "explanation": "表の中で2以上の値は、2, 3, 2, 4 の4個です。<br>そのため count = count + 1 は <strong>4回</strong> 実行されます。"
  },
  {
    "id": 86,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "累積人数が定員を超える時点",
    "prompt": "次のプログラムを実行したとき、表示される day の値として正しいものを選びなさい。",
    "code": "Visitors = [18, 22, 15, 30, 12, 20]\nlimit = 70\ntotal = 0\nday = -1\n\ni を 0 から 要素数(Visitors) - 1 まで 1 ずつ増やしながら繰り返す:\n｜total = total + Visitors[i]\n｜もし total >= limit かつ day == -1 ならば:\n⎿⎿ day = i\n\n表示する(day)",
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
    "explanation": "累積は 18 → 40 → 55 → 85 と増えます。<br>初めて70以上になるのは i=3 のときなので、表示される値は <strong>3</strong> です。"
  },
  {
    "id": 87,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "初めて条件を満たした位置だけを記録する",
    "prompt": "target 以上になった最初の添字だけを pos に入れるには、[ ア ] に何を入れればよいですか。",
    "code": "Point = [12, 8, 15, 6, 20]\ntarget = 30\ntotal = 0\npos = -1\n\ni を 0 から 要素数(Point) - 1 まで 1 ずつ増やしながら繰り返す:\n｜total = total + Point[i]\n｜もし total >= target かつ [ ア ] ならば:\n⎿⎿ pos = i\n\n表示する(pos)",
    "choices": [
      "pos == -1",
      "pos == i",
      "pos >= 0",
      "total == 0",
      "Point[i] == target",
      "i == 0",
      "target < 0",
      "要素数(Point) == pos"
    ],
    "correctIndex": 0,
    "explanation": "pos は「まだ記録していない」ことを -1 で表しています。<br>最初の1回だけ記録するには、条件に <strong>pos == -1</strong> を加えます。"
  },
  {
    "id": 88,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "連続している区間の最大長",
    "prompt": "次のプログラムを実行したとき、表示される longest の値として正しいものを選びなさい。",
    "code": "Busy = [1, 1, 0, 1, 1, 1, 0, 1]\nnow = 0\nlongest = 0\n\ni を 0 から 要素数(Busy) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし Busy[i] == 1 ならば:\n｜｜now = now + 1\n｜｜もし now > longest ならば:\n｜⎿⎿ longest = now\n｜そうでなければ:\n⎿⎿ now = 0\n\n表示する(longest)",
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
    "explanation": "1が続く長さを now で数え、最大値を longest に記録します。<br>連続部分の長さは 2、3、1 なので、最大は <strong>3</strong> です。"
  },
  {
    "id": 89,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "2次元配列の列合計",
    "prompt": "各列の合計を ColSum に入れる。空欄 [ ア ] に入る式として正しいものを選びなさい。",
    "code": "Table = [\n  [3, 1, 4],\n  [2, 5, 0],\n  [1, 2, 6]\n]\nColSum = [0, 0, 0]\n\nr を 0 から 要素数(Table) - 1 まで 1 ずつ増やしながら繰り返す:\n｜c を 0 から 要素数(Table[r]) - 1 まで 1 ずつ増やしながら繰り返す:\n⎿⎿ ColSum[c] = ColSum[c] + [ ア ]\n\n表示する(ColSum)",
    "choices": [
      "Table[r][c]",
      "Table[c][r]",
      "Table[r]",
      "Table[c]",
      "ColSum[r]",
      "ColSum[c]",
      "r + c",
      "要素数(Table[c])"
    ],
    "correctIndex": 0,
    "explanation": "r行c列の値を、c列目の合計 ColSum[c] に足します。<br>参照する値は <strong>Table[r][c]</strong> です。"
  },
  {
    "id": 90,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "列合計の最大値",
    "prompt": "次のプログラムを実行したとき、表示される best の値として正しいものを選びなさい。",
    "code": "Table = [\n  [3, 1, 4],\n  [2, 5, 0],\n  [1, 2, 6]\n]\nColSum = [0, 0, 0]\n\nr を 0 から 要素数(Table) - 1 まで 1 ずつ増やしながら繰り返す:\n｜c を 0 から 要素数(Table[r]) - 1 まで 1 ずつ増やしながら繰り返す:\n⎿⎿ ColSum[c] = ColSum[c] + Table[r][c]\n\nbest = 0\ni を 0 から 要素数(ColSum) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし ColSum[i] > best ならば:\n⎿⎿ best = ColSum[i]\n\n表示する(best)",
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
    "explanation": "列合計は、1列目が 3+2+1=6、2列目が 1+5+2=8、3列目が 4+0+6=10 です。<br>最大値は <strong>10</strong> です。"
  },
  {
    "id": 101,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "dncl",
    "title": "偶数番目の要素を合計する",
    "prompt": "添字が偶数の要素だけを total に加えるには、[ ア ] に何を入れればよいですか。",
    "code": "Nums = [5, 8, 3, 6, 7, 2]\ntotal = 0\n\ni を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし [ ア ] ならば:\n⎿⎿ total = total + Nums[i]\n\n表示する(total)",
    "choices": [
      "i ％ 2 == 0",
      "i ％ 2 == 1",
      "Nums[i] ％ 2 == 0",
      "Nums[i] ％ 2 == 1",
      "i == Nums[i]",
      "i > Nums[i]"
    ],
    "correctIndex": 0,
    "explanation": "添字が偶数とは、i が 0, 2, 4, ... になる場合です。<br>2で割った余りが0なので、条件は <strong>i ％ 2 == 0</strong> です。"
  },
  {
    "id": 102,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "dncl",
    "title": "条件によって足すか引くかを変える",
    "prompt": "次のプログラムを実行したとき、表示される total の値として正しいものを選びなさい。",
    "code": "Nums = [4, 1, 7, 2, 5]\ntotal = 0\n\ni を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし Nums[i] >= 5 ならば:\n｜⎿ total = total + Nums[i]\n｜そうでなければ:\n⎿⎿ total = total - Nums[i]\n\n表示する(total)",
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
    "id": 103,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "標準",
    "langMode": "dncl",
    "title": "2つの条件を同時に満たす回数",
    "prompt": "次のプログラムで、count = count + 1 は何回実行されますか。",
    "code": "Nums = [2, 5, 8, 11, 14, 17]\ncount = 0\n\ni を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし Nums[i] ％ 3 == 2 かつ Nums[i] > 10 ならば:\n⎿⎿ count = count + 1\n\n表示する(count)",
    "choices": [
      "1回",
      "2回",
      "3回",
      "4回",
      "5回",
      "6回"
    ],
    "correctIndex": 2,
    "explanation": "3で割った余りが2で、さらに10より大きい値は 11, 14, 17 の3つです。<br>よって count = count + 1 は <strong>3回</strong> 実行されます。"
  },
  {
    "id": 104,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "dncl",
    "title": "在庫の残りと少ない商品の数",
    "prompt": "次のプログラムを実行したとき、表示される Remain と count の組として正しいものを選びなさい。",
    "code": "Stock = [12, 9, 15, 7, 10]\nSold = [3, 4, 5, 2, 6]\nRemain = [0, 0, 0, 0, 0]\ncount = 0\n\ni を 0 から 要素数(Stock) - 1 まで 1 ずつ増やしながら繰り返す:\n｜Remain[i] = Stock[i] - Sold[i]\n｜もし Remain[i] < 8 ならば:\n⎿⎿ count = count + 1\n\n表示する(Remain, count)",
    "choices": [
      "[9, 5, 10, 5, 4] 3",
      "[9, 5, 10, 5, 4] 2",
      "[15, 13, 20, 9, 16] 0",
      "[3, 4, 5, 2, 6] 5",
      "[9, 5, 10, 5, 4] 5",
      "[12, 9, 15, 7, 10] 3"
    ],
    "correctIndex": 0,
    "explanation": "Remain は Stock から Sold を引いた値です。<br>順に [9, 5, 10, 5, 4] となり、8未満は 5, 5, 4 の3個です。よって <strong>[9, 5, 10, 5, 4] 3</strong> です。"
  },
  {
    "id": 105,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "dncl",
    "title": "前日より増えた日を数える",
    "prompt": "前の値より大きくなった回数を数えるには、[ ア ] に何を入れればよいですか。",
    "code": "Temps = [18, 20, 19, 22, 22, 25]\ncount = 0\n\ni を 1 から 要素数(Temps) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし [ ア ] ならば:\n⎿⎿ count = count + 1\n\n表示する(count)",
    "choices": [
      "Temps[i] > Temps[i - 1]",
      "Temps[i] < Temps[i - 1]",
      "Temps[i] == Temps[i - 1]",
      "i > Temps[i]",
      "Temps[i - 1] > i",
      "Temps[i] >= 0"
    ],
    "correctIndex": 0,
    "explanation": "現在の値は Temps[i]、前の値は Temps[i - 1] です。<br>前より増えたかを調べる条件は <strong>Temps[i] > Temps[i - 1]</strong> です。"
  },
  {
    "id": 106,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "dncl",
    "title": "指定された箱の数を増やす",
    "prompt": "次のプログラムを実行したとき、表示される Boxes として正しいものを選びなさい。",
    "code": "Boxes = [3, 0, 2]\nMoves = [1, 2, 0, 1]\n\ni を 0 から 要素数(Moves) - 1 まで 1 ずつ増やしながら繰り返す:\n⎿ Boxes[Moves[i]] = Boxes[Moves[i]] + 1\n\n表示する(Boxes)",
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
    "explanation": "Moves の値は、増やす箱の添字を表します。<br>添字1を2回、添字2を1回、添字0を1回増やすので、Boxes は <strong>[4, 2, 3]</strong> になります。"
  },
  {
    "id": 107,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "dncl",
    "title": "隣り合う要素を比較する範囲",
    "prompt": "Data[i] と Data[i + 1] を安全に比較するには、[ ア ] に何を入れればよいですか。",
    "code": "Data = [3, 5, 4, 6, 8]\npos = -1\n\ni を [ ア ] まで 1 ずつ増やしながら繰り返す:\n｜もし Data[i] > Data[i + 1] ならば:\n｜｜pos = i\n⎿⎿ 繰り返しを抜ける\n\n表示する(pos)",
    "choices": [
      "0 から 要素数(Data) - 2",
      "0 から 要素数(Data) - 1",
      "1 から 要素数(Data) - 1",
      "0 から 要素数(Data)",
      "Data[i] から 要素数(Data)",
      "0 から 0",
      "pos から 要素数(Data) - 1",
      "0 から 要素数(pos) - 1"
    ],
    "correctIndex": 0,
    "explanation": "Data[i + 1] を使うため、i が最後の添字になると範囲外になります。<br>最後に使える i は 要素数(Data)-2 なので、範囲は <strong>0 から 要素数(Data) - 2</strong> です。"
  },
  {
    "id": 108,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "標準",
    "langMode": "dncl",
    "title": "余りごとの個数を数える",
    "prompt": "次のプログラムを実行したとき、表示される Bucket として正しいものを選びなさい。",
    "code": "Nums = [5, 8, 10, 12, 14, 17, 21]\nBucket = [0, 0, 0]\n\ni を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:\n⎿ Bucket[Nums[i] ％ 3] = Bucket[Nums[i] ％ 3] + 1\n\n表示する(Bucket)",
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
    "id": 109,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "標準",
    "langMode": "dncl",
    "title": "値を半分にする繰り返し",
    "prompt": "次のプログラムで、count = count + 1 は何回実行されますか。",
    "code": "x = 48\ncount = 0\n\nx > 5 の間繰り返す:\n｜x = x ÷ 2\n⎿ count = count + 1\n\n表示する(x, count)",
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
    "explanation": "x は 48 → 24 → 12 → 6 → 3 と変化します。<br>x が3になると x > 5 を満たさないため停止します。count = count + 1 は <strong>4回</strong> 実行されます。"
  },
  {
    "id": 110,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "標準",
    "langMode": "dncl",
    "title": "目標に達したら繰り返しを止める",
    "prompt": "合計が target 以上になった時点で繰り返しを止めるには、[ ア ] に何を入れればよいですか。",
    "code": "Items = [4, 7, 3, 6, 5]\ntarget = 18\ntotal = 0\nused = 0\n\ni を 0 から 要素数(Items) - 1 まで 1 ずつ増やしながら繰り返す:\n｜total = total + Items[i]\n｜used = used + 1\n｜もし [ ア ] ならば:\n⎿⎿ 繰り返しを抜ける\n\n表示する(used)",
    "choices": [
      "total >= target",
      "total < target",
      "Items[i] == target",
      "used == 0",
      "i == 要素数(Items)",
      "Items[i] > total",
      "target < 0",
      "total == Items[i]"
    ],
    "correctIndex": 0,
    "explanation": "繰り返しを止めたいのは、ここまでの合計 total が目標 target に達したときです。<br>したがって条件は <strong>total >= target</strong> です。"
  },
  {
    "id": 121,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "基礎",
    "langMode": "dncl",
    "title": "配列から指定の値を取り出す",
    "prompt": "x に 18 を代入するには、[ ア ] に入る値として正しいものを選びなさい。",
    "code": "Scores = [12, 15, 18, 20]\nx = Scores[[ ア ]]\n表示する(x)",
    "choices": [
      "0",
      "1",
      "2",
      "3",
      "4",
      "18"
    ],
    "correctIndex": 2,
    "explanation": "添字は0から始まります。<br>Scores[0]=12, Scores[1]=15, Scores[2]=18 なので、18を取り出す添字は <strong>2</strong> です。"
  },
  {
    "id": 122,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "dncl",
    "title": "変数の値を更新する",
    "prompt": "次のプログラムを実行したとき、表示される x の値として正しいものを選びなさい。",
    "code": "x = 6\nx = x + 3\nx = x × 2\n表示する(x)",
    "choices": [
      "9",
      "12",
      "15",
      "18",
      "21",
      "36"
    ],
    "correctIndex": 3,
    "explanation": "最初 x=6 です。<br>x=x+3 で9になり、x=x×2 で <strong>18</strong> になります。"
  },
  {
    "id": 123,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "基礎",
    "langMode": "dncl",
    "title": "繰り返しの回数",
    "prompt": "次のプログラムで、total = total + i は何回実行されますか。",
    "code": "total = 0\n\ni を 2 から 6 まで 1 ずつ増やしながら繰り返す:\n⎿ total = total + i\n\n表示する(total)",
    "choices": [
      "2回",
      "3回",
      "4回",
      "5回",
      "6回",
      "7回"
    ],
    "correctIndex": 3,
    "explanation": "i は 2, 3, 4, 5, 6 と変化します。<br>したがって total = total + i は <strong>5回</strong> 実行されます。"
  },
  {
    "id": 124,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "dncl",
    "title": "条件を満たす値だけを足す",
    "prompt": "次のプログラムを実行したとき、表示される total の値として正しいものを選びなさい。",
    "code": "Nums = [3, 8, 5, 10, 2]\ntotal = 0\n\ni を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし Nums[i] >= 5 ならば:\n⎿⎿ total = total + Nums[i]\n\n表示する(total)",
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
    "id": 125,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "基礎",
    "langMode": "dncl",
    "title": "合計を求める代入文",
    "prompt": "配列の値を順に total に加えるには、[ ア ] に何を入れればよいですか。",
    "code": "Nums = [2, 4, 6]\ntotal = 0\n\ni を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:\n⎿ [ ア ]\n\n表示する(total)",
    "choices": [
      "total = total + Nums[i]",
      "total = Nums[i]",
      "Nums[i] = total + Nums[i]",
      "total = total - Nums[i]",
      "表示する(Nums[i])",
      "Nums = Nums + i"
    ],
    "correctIndex": 0,
    "explanation": "total に Nums[i] を加えて更新するので、代入文は <strong>total = total + Nums[i]</strong> です。"
  },
  {
    "id": 126,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "dncl",
    "title": "配列の値を1つだけ更新する",
    "prompt": "次のプログラムを実行したとき、表示される Data として正しいものを選びなさい。",
    "code": "Data = [4, 7, 1, 9]\nData[2] = Data[2] + 5\n表示する(Data)",
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
    "explanation": "Data[2] は3番目の値で、最初は1です。<br>1+5=6 になるので、Data は <strong>[4, 7, 6, 9]</strong> になります。"
  },
  {
    "id": 127,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "基礎",
    "langMode": "dncl",
    "title": "配列全体を添字で調べる",
    "prompt": "配列の全要素を添字 i で順に調べるには、[ ア ] に何を入れればよいですか。",
    "code": "Data = [6, 2, 9, 4]\ntotal = 0\n\ni を [ ア ] まで 1 ずつ増やしながら繰り返す:\n⎿ total = total + Data[i]\n\n表示する(total)",
    "choices": [
      "0 から 要素数(Data) - 1",
      "0 から 要素数(Data) - 2",
      "1 から 要素数(Data) - 1",
      "Data から 要素数(Data)",
      "total から 要素数(Data)",
      "0 から 0",
      "0 から 要素数(i) - 1",
      "Data[i] から 要素数(Data)"
    ],
    "correctIndex": 0,
    "explanation": "添字は 0 から 要素数(Data)-1 までです。<br>全要素を調べる範囲は <strong>0 から 要素数(Data) - 1</strong> です。"
  },
  {
    "id": 128,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "dncl",
    "title": "偶数だけを数える",
    "prompt": "次のプログラムを実行したとき、表示される count の値として正しいものを選びなさい。",
    "code": "Nums = [1, 4, 6, 7, 10]\ncount = 0\n\ni を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし Nums[i] ％ 2 == 0 ならば:\n⎿⎿ count = count + 1\n\n表示する(count)",
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
    "id": 129,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "基礎",
    "langMode": "dncl",
    "title": "条件が成り立つ回数",
    "prompt": "次のプログラムで、count = count + 1 は何回実行されますか。",
    "code": "Scores = [45, 80, 62, 59, 70]\ncount = 0\n\ni を 0 から 要素数(Scores) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし Scores[i] >= 60 ならば:\n⎿⎿ count = count + 1\n\n表示する(count)",
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
    "explanation": "60以上の点数は 80, 62, 70 の3つです。<br>よって count = count + 1 は <strong>3回</strong> 実行されます。"
  },
  {
    "id": 130,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "基礎",
    "langMode": "dncl",
    "title": "文字列を条件で数える",
    "prompt": "次のプログラムを実行したとき、表示される count の値として正しいものを選びなさい。",
    "code": "Letters = [\"A\", \"B\", \"A\", \"C\", \"A\"]\ncount = 0\n\ni を 0 から 要素数(Letters) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし Letters[i] == \"A\" ならば:\n⎿⎿ count = count + 1\n\n表示する(count)",
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
    "explanation": "Letters の中で \"A\" は1番目、3番目、5番目にあります。<br>合計3個なので、表示される値は <strong>3</strong> です。"
  },
  {
    "id": 131,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "作業を早く空く担当者へ割り当てる",
    "prompt": "次のプログラムを実行したとき、表示される Available として正しいものを選びなさい。",
    "code": "Days = [4, 1, 3, 1, 3, 4, 2, 4, 3]\nAvailable = [1, 1, 1]\n\nwork を 0 から 要素数(Days) - 1 まで 1 ずつ増やしながら繰り返す:\n｜member = 0\n｜i を 1 から 要素数(Available) - 1 まで 1 ずつ増やしながら繰り返す:\n｜｜もし Available[i] < Available[member] ならば:\n｜⎿⎿ member = i\n⎿ Available[member] = Available[member] + Days[work]\n\n表示する(Available)",
    "choices": [
      "[8, 10, 10]",
      "[10, 10, 8]",
      "[9, 9, 10]",
      "[11, 8, 9]"
    ],
    "correctIndex": 1,
    "explanation": "各作業を、現在もっとも早く空く担当者に割り当てます。<br>順に更新すると Available は最終的に <strong>[10, 10, 8]</strong> になります。"
  },
  {
    "id": 132,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "最も早く空く担当者を探す条件",
    "prompt": "作業を最も早く空く担当者に割り当てるには、[ ア ] に入る条件として正しいものを選びなさい。",
    "code": "Days = [4, 1, 3, 1, 3, 4]\nAvailable = [1, 1, 1]\n\nwork を 0 から 要素数(Days) - 1 まで 1 ずつ増やしながら繰り返す:\n｜member = 0\n｜i を 1 から 要素数(Available) - 1 まで 1 ずつ増やしながら繰り返す:\n｜｜もし [ ア ] ならば:\n｜⎿⎿ member = i\n⎿ Available[member] = Available[member] + Days[work]\n\n表示する(Available)",
    "choices": [
      "Available[i] < Available[member]",
      "Available[i] > Available[member]",
      "Days[i] < Days[member]",
      "work < member"
    ],
    "correctIndex": 0,
    "explanation": "最も早く空く担当者を探すので、候補 i の空き日 Available[i] が現在の member より小さいかを調べます。"
  },
  {
    "id": 133,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "到着時刻と待ち時間",
    "prompt": "次のプログラムを実行したとき、表示される longest の値として正しいものを選びなさい。",
    "code": "Arrival = [0, 3, 4, 10, 11, 12]\nStart = [0, 0, 0, 0, 0, 0]\nFinish = [0, 0, 0, 0, 0, 0]\n\nStart[0] = Arrival[0]\nFinish[0] = Start[0] + 5\n\ni を 1 から 要素数(Arrival) - 1 まで 1 ずつ増やしながら繰り返す:\n｜Start[i] = 最大値(Arrival[i], Finish[i - 1])\n⎿ Finish[i] = Start[i] + 5\n\nlongest = 0\ni を 0 から 要素数(Arrival) - 1 まで 1 ずつ増やしながら繰り返す:\n⎿ longest = 最大値(longest, Start[i] - Arrival[i])\n\n表示する(longest)",
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
    "id": 134,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "終了時刻を求める式",
    "prompt": "1人あたりの処理時間が service 分のとき、[ ア ] に入る式として正しいものを選びなさい。",
    "code": "Arrival = [0, 3, 4, 10]\nservice = 5\nStart = [0, 0, 0, 0]\nFinish = [0, 0, 0, 0]\n\nStart[0] = Arrival[0]\nFinish[0] = Start[0] + service\n\ni を 1 から 要素数(Arrival) - 1 まで 1 ずつ増やしながら繰り返す:\n｜Start[i] = 最大値(Arrival[i], Finish[i - 1])\n⎿ Finish[i] = [ ア ]\n\n表示する(Finish)",
    "choices": [
      "Start[i] + service",
      "Arrival[i] + Finish[i - 1]",
      "Finish[i - 1] + i",
      "service - Start[i]"
    ],
    "correctIndex": 0,
    "explanation": "終了時刻は「開始時刻 + 処理時間」です。したがって Finish[i] = <strong>Start[i] + service</strong> です。"
  },
  {
    "id": 135,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "二重の繰り返しと条件判定の実行回数",
    "prompt": "次のプログラムにおいて、count = count + 1 は何回実行されますか。",
    "code": "count = 0\n\nday を 1 から 5 まで 1 ずつ増やしながら繰り返す:\n｜room を 0 から 2 まで 1 ずつ増やしながら繰り返す:\n｜｜もし (day + room) ％ 2 == 0 ならば:\n⎿⎿⎿ count = count + 1\n\n表示する(count)",
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
    "id": 136,
    "pattern": "B",
    "patternLabel": "正誤判定",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "前日より高くなった回数を数える",
    "prompt": "Temps の中で、前日より気温が高くなった日数を count に入れるコードとして正しいものを選びなさい。",
    "code": "Temps = [22, 24, 23, 27, 29, 28]\n# 前日より高くなった回数を count に入れる",
    "choices": [
      "count = 0\ni を 1 から 要素数(Temps) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし Temps[i] > Temps[i - 1] ならば:\n⎿⎿ count = count + 1",
      "count = 0\ni を 0 から 要素数(Temps) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし Temps[i] > Temps[i + 1] ならば:\n⎿⎿ count = count + 1",
      "count = 1\ni を 1 から 要素数(Temps) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし Temps[i] < Temps[i - 1] ならば:\n⎿⎿ count = count + 1",
      "count = 要素数(Temps)"
    ],
    "correctIndex": 0,
    "explanation": "前日と比較するため、i は1から始めます。<br>比較する式は Temps[i] > Temps[i - 1] です。"
  },
  {
    "id": 137,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "必要数を満たしたグループ数",
    "prompt": "次のプログラムを実行したとき、表示される group と Filled の組として正しいものを選びなさい。",
    "code": "Seats = [2, 4, 1, 3, 2]\nNeed = [3, 5, 2]\nFilled = [0, 0, 0]\ngroup = 0\n\ni を 0 から 要素数(Seats) - 1 まで 1 ずつ増やしながら繰り返す:\n｜Filled[group] = Filled[group] + Seats[i]\n｜もし Filled[group] >= Need[group] ならば:\n｜⎿ group = group + 1\n｜もし group == 要素数(Need) ならば:\n⎿⎿ 繰り返しを抜ける\n\n表示する(group, Filled)",
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
    "id": 138,
    "pattern": "A",
    "patternLabel": "穴埋め",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "すべてのグループが完了したら抜ける条件",
    "prompt": "すべてのグループが必要数を満たしたら繰り返しを抜けるには、[ ア ] に何を入れればよいですか。",
    "code": "Seats = [2, 4, 1, 3, 2]\nNeed = [3, 5, 2]\nFilled = [0, 0, 0]\ngroup = 0\n\ni を 0 から 要素数(Seats) - 1 まで 1 ずつ増やしながら繰り返す:\n｜Filled[group] = Filled[group] + Seats[i]\n｜もし Filled[group] >= Need[group] ならば:\n｜⎿ group = group + 1\n｜もし [ ア ] ならば:\n⎿⎿ 繰り返しを抜ける\n\n表示する(group)",
    "choices": [
      "group == 要素数(Need)",
      "group == 要素数(Seats)",
      "Filled[group] == 0",
      "i == group"
    ],
    "correctIndex": 0,
    "explanation": "group は完了したグループ数を表します。<br>完了数が Need の個数と同じになれば、すべてのグループが完了しています。"
  },
  {
    "id": 139,
    "pattern": "C",
    "patternLabel": "実行結果",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "2次元配列の行ごとの合計",
    "prompt": "次のプログラムを実行したとき、表示される best の値として正しいものを選びなさい。",
    "code": "Table = [\n  [0, 2, 1],\n  [3, 1, 0],\n  [2, 0, 4]\n]\n\nbest = 0\nr を 0 から 要素数(Table) - 1 まで 1 ずつ増やしながら繰り返す:\n｜total = 0\n｜c を 0 から 要素数(Table[r]) - 1 まで 1 ずつ増やしながら繰り返す:\n｜｜もし Table[r][c] > 0 ならば:\n｜⎿⎿ total = total + Table[r][c]\n｜もし total > best ならば:\n⎿⎿ best = total\n\n表示する(best)",
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
    "id": 140,
    "pattern": "D",
    "patternLabel": "実行回数",
    "difficulty": "発展",
    "langMode": "dncl",
    "title": "最大値が更新される回数",
    "prompt": "次のプログラムにおいて、best = Nums[i] は何回実行されますか。",
    "code": "Nums = [6, 2, 8, 8, 3, 9]\nbest = 0\ncount = 0\n\ni を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:\n｜もし Nums[i] > best ならば:\n｜｜best = Nums[i]\n⎿⎿ count = count + 1\n\n表示する(best, count)",
    "choices": [
      "1回",
      "2回",
      "3回",
      "4回"
    ],
    "correctIndex": 2,
    "explanation": "best は 6、8、9 のときに更新されます。<br>同じ8がもう一度出ても Nums[i] > best ではないため更新されません。よって <strong>3回</strong> です。"
  }
];
