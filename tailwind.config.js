/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                "deep-blue": "#1E4D7B", // Был #1E3A5F, стал чуть светлее и голубее
                "mint": "#00BFA6",
                "warm-gray": "#F5F3F0", // Оставим для карточек, если нужно
                "slate-text": "#2D3748",
                "slate-light": "#4A5568",
                "alert-coral": "#FF6B6B",
            },
            fontFamily: {
                sans: ["Inter", "system-ui", "sans-serif"],
                mono: ["JetBrains Mono", "monospace"],
            },
        },
    },
    plugins: [],
};
