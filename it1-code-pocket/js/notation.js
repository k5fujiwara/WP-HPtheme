const notationExamples = {
  vars: {
    steps: [
      "Scores は4つの点数を持つ配列です。",
      "添字は0から始まるため、Scores[2] は3番目の値です。"
    ],
    output: "95"
  },
  strings: {
    steps: [
      "unit、\"は\"、topic の3つの文字列を + で連結します。"
    ],
    output: "第3問はアルゴリズム"
  },
  assign: {
    steps: [
      "price に 120、count に 5 を代入します。",
      "total = price * count なので、120 * 5 を計算します。"
    ],
    output: "600"
  },
  arithmetic: {
    steps: [
      "23 ÷ 4 は整数の商なので 5 です。",
      "23 ％ 4 は余りなので 3 です。",
      "3 ** 2 は 3 の2乗なので 9 です。"
    ],
    output: "5\n3\n9"
  },
  compare: {
    steps: [
      "68 >= 60 は成り立ちます。",
      "68 == 100 は成り立ちません。",
      "68 != 0 は成り立ちます。"
    ],
    output: "True\nFalse\nTrue"
  },
  logic: {
    steps: [
      "age >= 15 と point >= 40 は両方成り立ちます。",
      "age < 15 は成り立たず、point >= 50 も成り立ちません。",
      "point < 40 は成り立たないので、not により True になります。"
    ],
    output: "True\nFalse\nTrue"
  },
  functions: {
    steps: [
      "Temps には5個の気温データがあります。",
      "要素数(Temps) は 5 を返します。"
    ],
    output: "記録日数 5"
  },
  branch: {
    steps: [
      "stock は 2 なので、stock > 0 が成り立ちます。",
      "そのため、最初の表示する文だけが実行されます。"
    ],
    output: "購入できます"
  },
  loop: {
    steps: [
      "i は 0, 1, 2, 3 と変化します。",
      "Points[0] + Points[1] + Points[2] + Points[3] を合計します。"
    ],
    output: "24"
  },
  comment: {
    steps: [
      "# 以降はコメントなので実行されません。",
      "price * rate、つまり 500 * 0.08 を計算します。"
    ],
    output: "40"
  }
};

function applySavedTheme() {
  const savedTheme = localStorage.getItem("quiz-theme");
  const theme = ["simple", "cool", "pop"].includes(savedTheme) ? savedTheme : "simple";
  document.documentElement.setAttribute("data-theme", theme);
  document.body.setAttribute("data-theme", theme);
}

function runExample(key) {
  const example = notationExamples[key];
  const output = document.getElementById(`output-${key}`);
  if (!example || !output) return;

  output.textContent = [
    "処理の流れ:",
    ...example.steps.map((step, index) => `${index + 1}. ${step}`),
    "",
    "出力:",
    example.output
  ].join("\n");
  output.classList.add("show");
}

(function initNotation() {
  applySavedTheme();
})();
