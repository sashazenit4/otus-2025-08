<?php

use Bitrix\Main\Loader;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Чтение сделок с помощью старого ядра');

Loader::includeModule('crm');

$rawDeals = \CCrmDeal::GetListEx(
    [], 
    [
        'ID' => 6,
    ], 
    false, 
    false, 
    [
        'ID',
        'TITLE',
        'STAGE_ID',
        'UF_BOSS_COMMENT',
    ]
);

$deals = [];
while ($deal = $rawDeals->fetch()) {
    $deals[] = $deal;
}

dump($deals);

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
