document.addEventListener("DOMContentLoaded", () => {
    const themeToggle = document.getElementById("themeToggle");
    const description = document.getElementById("description");
    const characterCount = document.getElementById("characterCount");
    const menuButton = document.getElementById("menuButton");
    const mainNav = document.getElementById("mainNav");

    if (menuButton && mainNav) {
        menuButton.addEventListener("click", () => {
            mainNav.classList.toggle("open");
        });
    }

    function updateThemeIcon() {
        if (!themeToggle) return;

        themeToggle.textContent =
            document.documentElement.classList.contains("dark")
                ? "☀️"
                : "🌙";
    }

    if (themeToggle) {
        themeToggle.addEventListener("click", () => {
            document.documentElement.classList.toggle("dark");

            const darkEnabled =
                document.documentElement.classList.contains("dark");

            localStorage.setItem(
                "helpdesk-theme",
                darkEnabled ? "dark" : "light"
            );

            updateThemeIcon();
        });

        updateThemeIcon();
    }

    if (description && characterCount) {
        const updateCounter = () => {
            characterCount.textContent = `${description.value.length} caracteres`;
        };

        description.addEventListener("input", updateCounter);
        updateCounter();
    }
});