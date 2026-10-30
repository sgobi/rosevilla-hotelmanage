import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Open Sans', 'sans-serif', ...defaultTheme.fontFamily.sans],
                serif: ['Alegreya SC', 'serif'],
            },
            colors: {
                'rose-primary': '#7d4281',
                'rose-text': '#111827',
                'rose-accent': '#d9b36c',
                'rose-gold': '#d9b36c',
                'rose-dark': '#1a1a1a',
                'rose-light': '#f8f3ea',
            }
        },
    },

    plugins: [forms],
};
