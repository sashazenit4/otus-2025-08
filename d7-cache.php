<?php

use Otus\Orm\BookTable;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Кэширование методами ядра d7');

$cacheTime = 1000;
$cacheId = 'books_list_cache';
$cacheDir = 'books';

$cache = \Bitrix\Main\Data\Cache::createInstance();
if ($cache->initCache($cacheTime, $cacheId, $cacheDir)) {
    echo 'Закешированные данные: <br>';
    $arResult = $cache->getVars();
} else {
    echo 'Данные получаются из БД: <br>';
    $arResult = BookTable::getList()->fetchAll();

    if ($cache->startDataCache()) {
        $cache->endDataCache($arResult);
    }
}

dump($arResult);

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
