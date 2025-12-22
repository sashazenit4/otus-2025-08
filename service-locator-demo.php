<?php

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Loader;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Демо работы Service Locator');

Loader::includeModule('aholin.crmcustomtab');

try {
    $email = 'holinshura@gmail.com';
    echo ((ServiceLocator::getInstance())->get('user.controller'))->handle($email);

} catch (Exception $e) {
    echo 'Ошибка: ' . $e->getMessage();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
