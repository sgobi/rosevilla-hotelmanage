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
                'rose-primary': '#FFFFFF',
                'rose-text': '#545454',
                'rose-accent': '#2A2A2A',
                'rose-gold': '#C5A059', // Added a likely accent color based on "heritage" theme usually having gold/brown
            }
        },
    },

    plugins: [forms],
};
