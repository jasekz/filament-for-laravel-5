var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');

    mix.scripts(['../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js','vendor/dropzone-4.0.1/dist/dropzone.js', 'vendor/purl-master/purl.js','app.js'], 'public/js/app.js');;
});
