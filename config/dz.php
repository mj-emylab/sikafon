<?php

return [

    'url' => env('REDIRECT_URL'),

    'name' => env('APP_NAME', 'FindMe'),

    'public' => [
        'favicon' => 'media/img/logo/favicon.ico',
        'fonts' => [
            'google' => [
                'families' => [
                    'Poppins:300,400,500,600,700'
                ]
            ]
        ],
		'global' => [
			'css' => [
				'css/style.css',
			],
			'js' => [
				'vendor/global/global.min.js',
			],
		],
        'custom' => [
            'css' => [
                'vendor/bootstrap-select/dist/css/bootstrap-select.min.css',
                'vendor/jqvmap/css/jqvmap.min.css',
                'vendor/chartist/css/chartist.min.css',
                'https://cdn.lineicons.com/2.0/LineIcons.css',
                'vendor/select2/css/select2.min.css',
				'vendor/toastr/css/toastr.min.css',
            ],
            'js' => [
                'vendor/bootstrap-select/dist/js/bootstrap-select.min.js',
                'vendor/chart.js/Chart.bundle.min.js',
                'vendor/apexchart/apexchart.js',
                'vendor/peity/jquery.peity.min.js',
                'vendor/chartist/js/chartist.min.js',
                'vendor/svganimation/vivus.min.js',
                'vendor/svganimation/svg.animation.js',
			],
        ],
	]
];


// 'js/deznav-init.js',
// 'vendor/moment/moment.min.js',
//  'vendor/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js',
