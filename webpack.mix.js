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
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/login/login.scss', 'public/css/login')
    .sass('resources/sass/register/register.scss', 'public/css/register')
    .sass('resources/sass/backend/control_panel.scss', 'public/css/backend')
    .sass('resources/sass/backend/user/index.scss', 'public/css/backend/user')
    .version();
