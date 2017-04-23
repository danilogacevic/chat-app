const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix.sass('app.scss')
       .webpack('app.js')
       .styles([

            'libs/bootstrap.css',
       	'libs/bootstrap.min.css'],

       	'./public/css/libs.css')

       .scripts([

       	'libs/jquery.js',
       	'libs/bootstrap.min.js'
       	],

       	'./public/js/libs.js');
});
