<?php

use Otus\Orm\BookTable;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Кэширование вёрстки методами ядра d7');

$cacheTime = 100;
$cacheId = 'color_square_cache';
$cacheDir = 'html';

$cache = \Bitrix\Main\Data\Cache::createInstance();
if ($cache->initCache($cacheTime, $cacheId, $cacheDir)) {
    echo 'Закешированная вёрстка: <br>';
    $cache->output();
} else {
    echo 'Данные получаются из БД: <br>';
    if ($cache->startDataCache()) {
        echo '<div style="background: green; width: 50px; height: 50px;"></div>';
        $cache->endDataCache();
    }
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
