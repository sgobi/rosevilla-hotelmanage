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
                sans: ['Inter', 'Noto Sans Tamil', 'Noto Sans Sinhala', 'Open Sans', 'sans-serif', ...defaultTheme.fontFamily.sans],
                serif: ['"Playfair Display"', 'Noto Serif Tamil', 'Noto Serif Sinhala', 'Alegreya SC', 'serif', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                heritageGreen: '#1F4D3A',
                roseRed: '#B3203A',
                creamBg: '#F7F2E7',
                stoneBeige: '#EAE1D1',
                antiqueGold: '#D4AF37',
                goldHover: '#c19d31',
                darkText: '#232323',
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
