<?php

use Bitrix\Main\Application;
use Bitrix\Main\Data\Cache;
use Otus\Orm\BookTable;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
*/

$APPLICATION->SetTitle('Очистка тегированного кэша d7');

$taggedCache = Application::getInstance()->getTaggedCache();

$cacheTag = 'book_cache_tag';

$taggedCache->clearByTag($cacheTag); /* = Application::getInstance()->getTaggedCache();*/

echo 'Кэш с тегом ' . $cacheTag . ' очищен';

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
