import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Noto Sans JP', ...defaultTheme.fontFamily.sans],
            },
            keyframes: {
                'show-toast-keyframes': {
                    from: {opacity: 0, transform: 'translateY(-100%)'},
                    to: {opacity: 1},
                }
            },
            animation: {
                'show-toast': 'show-toast-keyframes 0.5s cubic-bezier(0.4, 0, 0.2, 1)',
            }
        },
    },
    plugins: [],
};
