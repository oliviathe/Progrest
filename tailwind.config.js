export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
    ],
    theme: {
        extend: {
            fontFamily: {
                montserrat: ['Montserrat', 'sans-serif'],
            },
            colors: {
                primary: 'var(--color-primary)',
                secondary: 'var(--color-secondary)',
                tertiary: 'var(--color-tertiary)',

                background: 'var(--color-background)',
                surface: 'var(--color-surface)',
                border: 'var(--color-border)',

                textPrimary: 'var(--color-text-primary)',
                textSecondary: 'var(--color-text-secondary)',
            },
        },
    },
    plugins: [],
}