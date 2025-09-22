<?php

use Bitrix\Main\Loader;
use Bitrix\Crm\DealTable;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Чтение сделок с помощью D7 ORM');

Loader::includeModule('crm');

$rawDeals = DealTable::getList([
    'cache' => [
        'ttl' => 3600000,
    ],
    'order' => [],
    'group' => [],
    'runtime' => [],
    'limit' => 1,
    'offset' => 0,
    'select' => [
        'ID',
        'TITLE',
        'STAGE_ID',
        'UF_BOSS_COMMENT',
    ],
    'filter' => [
        'ID' => 6,
    ],
]);

$deals = [];
while ($deal = $rawDeals->fetch()) {
    $deals[] = $deal;
}

dump($deals);

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
