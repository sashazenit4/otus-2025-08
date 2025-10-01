<?php

use Bitrix\Main\Application;
use Otus\Helper\Iblock as IblockHelper;
use Otus\Constant\Iblock as IblockConstant;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Кэширование запросов методами ядра d7');

$connection = Application::getConnection();

$connection->startTracker();

$clientsIblockId = IblockHelper::getIblockIdByCode(IblockConstant::CLIENTS_IBLOCK_CODE);
$doctorsIblockId = IblockHelper::getIblockIdByCode(IblockConstant::DOCTORS_IBLOCK_CODE);

echo 'ИД инфоблока Клиенты: ' . $clientsIblockId . '</br>';
echo 'ИД инфоблока Доктора: ' . $doctorsIblockId . '</br>';

$connection->stopTracker();
$tracker = $connection->getTracker();

dump($tracker->getQueries());

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
