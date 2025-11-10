<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

return [
	'css' => 'dist/greetingmessage.bundle.css',
	'js' => 'dist/greetingmessage.bundle.js',
	'rel' => [
		'main.core',
	],
	'skip_core' => false,
];
