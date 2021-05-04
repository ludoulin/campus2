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
mix.setResourceRoot("../");
mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/AlertMessage.js', 'public/js')
   .js('resources/js/Validation.js', 'public/js')
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
   .sass('resources/sass/user/favorite.scss', 'public/css/user')
   .sass('resources/sass/search/index.scss', 'public/css/search')
   .sass('resources/sass/user/cart.scss', 'public/css/user')
   .sass('resources/sass/errors/404.scss', 'public/css/errors')
   .sass('resources/sass/user/edit.scss', 'public/css/user')
   .sass('resources/sass/user/products.scss', 'public/css/user')
   .sass('resources/sass/order/status.scss', 'public/css/user')
   .sass('resources/sass/order/manage.scss', 'public/css/order')
   .sass('resources/sass/backend/product/index.scss', 'public/css/backend/product')
   .sass('resources/sass/checkout/confirm.scss', 'public/css/checkout')
   .version();



