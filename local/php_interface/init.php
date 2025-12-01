<?php

use Bitrix\Main\UI\Extension;

// require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/src/autoload.php';
require_once __DIR__ . '/events.php';

Extension::load([
    'otus.crm.negative_currency',
    'otus.sliderHelper',
]);
