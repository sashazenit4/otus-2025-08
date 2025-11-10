<?php
if (!defined('B_PROLOG_INCLUDED') || true !== B_PROLOG_INCLUDED) {
    die();
}

return [
    'css' => [
        'dist/fruits.bundle.css',
    ],
    'js' => [
        'dist/fruits.bundle.js',
    ],
    'rel' => [
		'main.polyfill.core',
		'ui.vue3',
	],
    'skip_core' => true,
];
