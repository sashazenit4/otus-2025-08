<?php

use Bitrix\Main\Loader;
use Bitrix\Crm\Service\Container;
use Bitrix\Crm\DealTable;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Удаление сделки с помощью нового АПИ CRM');

Loader::includeModule('crm');

// DealTable::delete(13);
$dealFactory = Container::getInstance()->getFactory(\CCrmOwnerType::Deal);
$dealItemToDelete = $dealFactory->getItem(13);
// $dealItemToDelete->delete();
// $dealItemToDelete->save();
$deleteOperation = $dealFactory->getDeleteOperation($dealItemToDelete);
$deleteResult = $deleteOperation->launch();

dump($deleteResult);

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
