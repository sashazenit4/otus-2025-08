<?php

use Bitrix\UI\Toolbar\Facade\Toolbar;
use Bitrix\UI\Buttons\Color;
use Bitrix\Main\UI\Extension;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

// Extension::load('sidepanel');
/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Кнопка, открывающая ссылку');
$button = [
    'link' => '/excel-export.php',
    'text' => 'Открыть список книг в слайдере',
    'color' => Color::SUCCESS,
];

Toolbar::addButton($button);
?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
