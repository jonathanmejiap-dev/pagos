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

mix.styles([
        //'resources/plantilla/css/font-awesome.min.css',
        //'resources/plantilla/css/bootstrap.min.css',
        //'resources/plantilla/css/simple-line-icons.min.css',    
        'resources/css/styles.css',
        //'resources/css/sb-admin-2.css',
        //'resources/plantilla/css/front.css',
    ], 'public/css/plantilla.css')
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');