module.exports = {
    purge: [],
    theme: {
        extend: {
            spacing: {
                44: "11rem",
            },
        },
        spinner: () => ({
            default: {
                color: "#dae1e7",
                size: "1em",
                border: "2px",
                speed: "500ms",
            },
        }),
    },
    variants: {},
    plugins: [
        require("tailwindcss-spinner")({
            className: "spinner",
            themeKey: "spinner",
        }),
    ],
}
