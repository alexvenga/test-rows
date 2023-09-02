/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: "media", // or 'media' or 'class'
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
    ],
    theme: {
        container: {
            padding: {
                DEFAULT: '1rem',
                sm: '2rem',
                lg: '4rem',
                xl: '5rem',
                '2xl': '6rem',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms')
    ],
}

