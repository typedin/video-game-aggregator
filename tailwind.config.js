const plugin = require("tailwindcss/plugin")
module.exports = {
    purge: [],
    theme: {
        extend: {
            spacing: {
                44: "11rem",
            },
        },
    },
    variants: {},
    plugins: [
        plugin(function ({ addComponents, theme }) {
            const titles = {
                ".section-title": {
                    color: theme("colors.blue.500"),
                    fontWeight: theme("fontWeight.semibold"),
                    letterSpacing: theme("letterSpacing.wide"),
                    textTransform: "uppercase",
                },
                ".game-title": {
                    color: theme("colors.white"),
                    fontSize: theme("fontSize.base"),
                    fontWeight: theme("fontWeight.semibold"),
                    lineHeight: theme("lineHeight.tight"),
                    "&:hover": {
                        color: theme("colors.gray.400"),
                    },
                },
            }
            addComponents(titles)
        }),
    ],
}
