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
                'sl-maroon': '#8B1538',
                'sl-gold': '#D4AF37',
            },
            animation: {
                'tilt': 'tilt 10s infinite linear',
            },
            keyframes: {
                tilt: {
                    '0%, 50%, 100%': { transform: 'rotate(0deg)' },
                    '25%': { transform: 'rotate(0.5deg)' },
                    '75%': { transform: 'rotate(-0.5deg)' },
                }
            }
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
