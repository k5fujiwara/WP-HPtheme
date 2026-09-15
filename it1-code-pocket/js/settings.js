function applyTheme(theme) {
  document.documentElement.setAttribute("data-theme", theme);
  document.body.setAttribute("data-theme", theme);
  document.querySelectorAll("[data-theme-option]").forEach(button => {
    button.classList.toggle("selected", button.dataset.themeOption === theme);
  });
}

function chooseTheme(theme) {
  localStorage.setItem("quiz-theme", theme);
  applyTheme(theme);
}

(function initSettings() {
  const savedTheme = localStorage.getItem("quiz-theme");
  applyTheme(["simple", "cool", "pop"].includes(savedTheme) ? savedTheme : "simple");
})();
