let mix = require('laravel-mix');

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
mix.options({
    processCssUrls: false
});
mix.react('resources/assets/js/app.js', 'public/js');
mix.react('resources/assets/js/es6/login.js', 'public/js');
mix.sass('resources/assets/sass/app.scss', 'public/css');
mix.sass('resources/assets/sass/order_input.scss', 'public/css');
mix.copyDirectory('resources/assets/css', 'public/css');
mix.copyDirectory('node_modules/material-design-icons/iconfont', 'public/iconfont/fontmaterial');
mix.copyDirectory('node_modules/air-datepicker/dist', 'public/dist/air-datepicker');
mix.copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/iconfont/fontawesome');
mix.copyDirectory('node_modules/tinymce', 'public/dist/tinymce');
mix.copyDirectory('node_modules/jquery-tageditor/jquery.tag-editor.css', 'public/dist/tageditor');
mix.copyDirectory('node_modules/jquery-tageditor/jquery.caret.min.js', 'public/dist/tageditor');
mix.copyDirectory('node_modules/jquery-tageditor/jquery.tag-editor.min.js', 'public/dist/tageditor');
mix.copyDirectory('resources/assets/fonts/roboto/v18', 'public/fonts/roboto/v18');
mix.copyDirectory('resources/assets/dist', 'public/dist');
mix.copyDirectory('resources/assets/js/es5', 'public/js');
mix.copyDirectory('resources/assets/images', 'public/images');
