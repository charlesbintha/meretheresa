import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#eff2fb',
                    100: '#dce3f5',
                    200: '#bcc9eb',
                    300: '#92a5da',
                    400: '#6578c0',
                    500: '#4557a4',
                    600: '#354588',
                    700: '#2b3a6f',
                    800: '#1F2A5E',
                    900: '#172146',
                    950: '#0d132a',
                },
                secondary: {
                    50: '#fefce8',
                    100: '#fef9c3',
                    200: '#fef08a',
                    300: '#fde047',
                    400: '#facc15',
                    500: '#eab308',
                    600: '#ca8a04',
                    700: '#a16207',
                    800: '#854d0e',
                    900: '#713f12',
                },
                accent: {
                    blue: '#87CEEB',
                    mint: '#98D8C8',
                    pink: '#F4B8C1',
                    peach: '#FFDAB9',
                    lavender: '#E6E6FA',
                },
                cream: '#FFFDF8',
                dark: '#2A2A3A',
            },
            fontFamily: {
                heading: ['Fredoka', ...defaultTheme.fontFamily.sans],
                body: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            borderRadius: {
                'blob': '30% 70% 70% 30% / 30% 30% 70% 70%',
                'blob-2': '60% 40% 30% 70% / 60% 30% 70% 40%',
            },
            animation: {
                'float': 'float 6s ease-in-out infinite',
                'float-slow': 'float 8s ease-in-out infinite',
                'float-delay': 'float 7s ease-in-out 2s infinite',
                'fade-in-up': 'fadeInUp 0.6s ease-out forwards',
                'bounce-gentle': 'bounceGentle 2s ease-in-out infinite',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-20px)' },
                },
                fadeInUp: {
                    '0%': { opacity: '0', transform: 'translateY(30px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                bounceGentle: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-10px)' },
                },
            },
        },
    },
    plugins: [],
};
