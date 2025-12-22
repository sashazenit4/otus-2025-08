<?php

use Bitrix\Main\Loader;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Демо работы перезаписи стандартного сервиса Битрикс');

Loader::includeModule('crm');
try {
    $serviceLocator = \Bitrix\Crm\Service\Container::getInstance();
    $serviceLocator->getFactory(\CCrmOwnerType::Deal);
} catch (Exception $e) {
    echo 'Ошибка: ' . $e->getMessage();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
