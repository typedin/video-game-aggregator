const mix = require("laravel-mix")
require("laravel-mix-favicon")

mix.js("resources/js/app.js", "public/js")
    .postCss("resources/css/main.css", "public/css", [require("tailwindcss")])
    .browserSync({
        proxy: "video-game-aggregator.test",
        browser: "/home/antoine/.local/firefox-developer-edition/firefox",
    })
    .favicon({
        blade: "resources/views/layouts/favicon.blade.php",
        cleanUp: true,
    })
