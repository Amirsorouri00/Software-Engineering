var elixir = require('laravel-elixir');
var browserSync = require('laravel-elixir-browsersync2');
require('laravel-elixir-webpack');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
     mix.scripts([
       'vendor/vue.min.js',
       'vendor/vue-resource.min.js'
     ], 'public/js/vendor.js');
     mix.browserSync({
       proxy : 'bit.com:2000/'
     });
     mix.sass('app.scss');
     mix.webpack('app.js');
     mix.webpack('back.js');
     //mix.browserify('guestexam.js');
     //mix.browserify('main.js');
     //mix.browserify('../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap.js');
     mix.webpack('../../../node_modules/jquery/dist/jquery.min.js');
     mix.sass('../../../node_modules/bootstrap-sass/assets/stylesheets/_bootstrap.scss');
});
