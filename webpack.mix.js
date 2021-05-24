const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
    // .setResourceRoot('../');
    // http://localhost:8080/fonts/vendor/@fortawesome/fontawesome-free/webfa-solid-900.woff2
    // http://localhost:8080/fonts/vendor/@fortawesome/fontawesome-free/webfa-solid-900.woff2 