/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    safelist: [
        'bg-yellow-200 bg-green-200 bg-slate-200 bg-blue-200 bg-rose-200 bg-sky-200 bg-zinc-200'
    ],
    content: [
        "./resources/**/**/*.blade.php",
        "./resources/**/**/*.js",
        "./app/View/Components/**/**/*.php",
        "./app/Livewire/**/**/*.php",
        "./vendor/robsontenorio/mary/src/View/Components/**/*.php",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    ],
    theme: {
        extend: {},
    },

    plugins: [
        require("daisyui")
    ],

    daisyui: {
        themes: ["winter"],
    },
}
