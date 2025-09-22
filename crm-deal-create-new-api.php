<?php

use Bitrix\Main\Loader;
use Bitrix\Crm\Service\Container;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Создание сделок с помощью нового АПИ CRM');

Loader::includeModule('crm');

// $dealFields = [
//     'TITLE' => 'Тестовая сделка Старое ядро',
// ];

// $newDealModel = new \CCrmDeal();
// $newDealId = $newDealModel->Add($dealFields);

// echo 'ID новой сделки: ' . $newDealId . PHP_EOL;

// //$result = \Bitrix\Crm\LeadTable::add($dealFields);

$dealFactory = Container::getInstance()->getFactory(\CCrmOwnerType::Deal);
$newDealItem = $dealFactory->createItem([
    'TITLE' => 'Тестовая сделка D7',
    'OPPORTUNITY' => 10_000,
]);
// $newDealItem->set('TITLE', 'Тестовая сделка D7');
// $newDealItem->set('OPPORTUNITY', 10000);
// //$newDealItem->save(); # Выполнит сохранение сразу без проверки
$dealAddOperation = $dealFactory->getAddOperation($newDealItem);
$addResult = $dealAddOperation->launch();

echo 'ID новой сделки Новое апи CRM: ' . $addResult->getId() . PHP_EOL;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
