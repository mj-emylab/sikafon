const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js').vue()
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);

// mix.options({
//     hmrOptions: {
//         host: '127.0.0.1',
//         port: 8002,
//     }
// })
