<?php

use Bitrix\Main\Loader;
use Bitrix\Crm\Service\Container;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Чтение сделок с помощью нового АПИ CRM');

Loader::includeModule('crm');

// Аргумент метода getFactory принимает EntityTypeId сущности, в т ч Смарт-процесса
$crmDealFactory = Container::getInstance()->getFactory(\CCrmOwnerType::Deal);

$deals = $crmDealFactory->getItems([
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
    // 'filter' => [
    //     'ID' => 6,
    // ],
]);

$arrayOfDeals = [];
foreach ($deals as $dealItem) {
    $arrayOfDeals[] = [
        'ID' => $dealItem->get('ID'),
        'TITLE' => $dealItem->get('TITLE'),
        'STAGE_ID' => $dealItem->get('STAGE_ID'),
        // 'UF_BOSS_COMMENT' => $dealItem->get('UF_BOSS_COMMENT'),
    ];
    // $arrayOfDeals[] = [
    //     'ID' => $dealItem->getId(),
    //     'TITLE' => $dealItem->getTitle(),
    //     'STAGE_ID' => $dealItem->getStageId(),
    //     'UF_BOSS_COMMENT' => $dealItem->getUfBossComment(),
    // ];
}

dump($arrayOfDeals);

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
