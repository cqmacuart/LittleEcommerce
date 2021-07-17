const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.styles(
    [
        "resources/vendor/css/config.css",
        "resources/vendor/css/page.css"
        // "resources/vendor/assets/fontawesome/css/all.css"
    ],
    "public/css/plantilla.css"
)
    .sass("resources/sass/app.scss", "public/css")
    .js("resources/js/app.js", "public/js")
    .scripts(
        [
            "resources/vendor/js/config.js",
            "resources/vendor/assets/fontawesome/js/all.js"
        ],
        "public/js/plantilla.js"
    )
    .copy("resources/vendor/assets/fontawesome/webfonts", "public/webfonts")
    .copy("resources/vendor/img/", "public/img");
