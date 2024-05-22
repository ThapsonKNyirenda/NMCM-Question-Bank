import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './src/**/*.{html,js,ts,jsx,txs}',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'login-blue': '#bbd4d9',
                'login-green' : '#42a092',
                'theme-muted': '#968E7E',
                'theme-gray-800': '#403D38',
                'theme-gray-500' : '#968E7E',
                'header-search' : '#716D66'
            },
            backgroundColor: {
                'main-blue' : '#bbd4d9',
                'login-card' : '#f8fbff',
                'primary-dark' : '#1c8d9c',
                'muted': '#968E7E',
                'muted-more' : '#DEDBD5'
            },
            borderColor: {
                'login-green' : '#42a092',
            },
            fontSize : {
                'fs-7' : '.95rem'
            },
            zIndex: {
                '100': '100',
                '111': '111'
            },
            width: {
                '250' : '250px',
                '350' : '350px',
                '357' : '375px',
            },
            lineHeight: {
                '0': '0'
            },
            minHeight: {
                '50vh' : '50vh',
                '70vh' : '70vh',
                '75vh' : '75vh',
                '80vh' : '80vh',
            },
        },
    },

    plugins: [forms],
};
