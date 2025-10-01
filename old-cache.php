<?php

use Otus\Orm\BookTable;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Кэширование методами старого ядра');

$cacheTime = 1000;
$cacheId = 'books_list_cache';
$cacheDir = 'books';

$cache = new \CPHPCache;
if ($cache->InitCache($cacheTime, $cacheId, $cacheDir)) {
    echo 'Закешированные данные: <br>';
    $arResult = $cache->getVars();
} else {
    echo 'Данные получаются из БД: <br>';
    $arResult = BookTable::getList()->fetchAll();

    if ($cache->StartDataCache()) {
        $cache->EndDataCache($arResult);
    }
}

dump($arResult);

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
