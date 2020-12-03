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
   .sass('resources/sass/backend/user/edit.scss', 'public/css/backend/user')
   .sass('resources/sass/page/test.scss', 'public/css/page')
   .sass('resources/sass/product/show.scss', 'public/css/product')
   .sass('resources/sass/product/create.scss', 'public/css/product')
   .sass('resources/sass/department/index.scss', 'public/css/department')
   .sass('resources/sass/page/root.scss', 'public/css/page')
   .version();
