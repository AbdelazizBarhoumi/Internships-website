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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                hanken: ['Hanken Grotesk', 'sans-serif'],
            },
            fontSize: {
                '2xs': '0.625rem',
            },
            colors: {
                black: '#060606',
            },
            perspective: {
                '1000': '1000px',
            },
            backfaceVisibility: {
                'hidden': 'hidden',
            },
            rotate: {
                'y-180': 'rotateY(180deg)',
            },
            transitionDuration: {
                '600': '600ms',
            },
            transformStyle: {
                '3d': 'preserve-3d',
            }
        },
    },

    plugins: [
        forms,
        function({ addUtilities }) {
            addUtilities({
                '.perspective-1000': {
                    'perspective': '1000px',
                },
                '.backface-hidden': {
                    'backface-visibility': 'hidden',
                },
                '.rotate-y-180': {
                    'transform': 'rotateY(180deg)',
                },
                '.transform-style-3d': {
                    'transform-style': 'preserve-3d',
                },
            });
        }
    ],
};