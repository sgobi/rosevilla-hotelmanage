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
                'rose-primary': '#7d4281', // Cinnamon Purple inspired
                'rose-text': '#2A2A2A',
                'rose-accent': '#C5A059', // Gold for accents
                'rose-gold': '#d9b36c', // Brighter Gold for branding
                'rose-dark': '#1a1a1a', // Deep charcoal for footers/text
                'rose-light': '#f9f9f9', // Off-white for backgrounds
            }
        },
    },

    plugins: [forms],
};
