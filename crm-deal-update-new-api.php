<?php

use Bitrix\Main\Loader;
use Bitrix\Crm\Service\Container;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Изменение сделок с помощью нового АПИ CRM');

Loader::includeModule('crm');

$dealFactory = Container::getInstance()->getFactory(\CCrmOwnerType::Deal);
$existedDealItem = $dealFactory->getItem(13);
$existedDealItem->set('OPPORTUNITY', 10_000_000);
$existedDealItem->set('TITLE', 'Измененная дважды тестовая сделка D7');
// $existedDealItem->save(); # Сохранение внесенные в Item изменений без выполнения проверок
$dealUpdateOperation = $dealFactory->getUpdateOperation($existedDealItem);
$updateResult = $dealUpdateOperation->launch();

echo 'ID измененной сделки Новое апи CRM: ' . $updateResult->getId() . PHP_EOL;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
