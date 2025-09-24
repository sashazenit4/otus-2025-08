<?php

use Bitrix\Highloadblock\HighloadblockTable;
use Bitrix\Main\Loader;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */
$APPLICATION->SetTitle('Пример вывода элементов highload-блоков');

Loader::includeModule('highloadblock');

$highloadBlockId = HighloadblockTable::getList([
    'filter' => [
        'NAME' => 'PantoneColors'
    ],
    'limit' => 1,
    'cache' => [
        'ttl' => 3600000,
    ],
])->fetch()['ID'] ?? 0;

if ($highloadBlockId <= 0) {
    return;
}

$pantoneColorsEntity = HighloadblockTable::compileEntity($highloadBlockId);
$pantoneColorsTableClass = $pantoneColorsEntity->getDataClass();
$pantoneColorsCollection = $pantoneColorsTableClass::getList([
    'select' => [
        'UF_HEX_CODE',
        'UF_NAME', # Код Пантона
        'UF_COLOR_TITLES',
    ],
])->fetchCollection();

foreach ($pantoneColorsCollection as $pantoneColor) {
    echo sprintf(
        'Код цвета: %s; Цвет: <div style="width: 16px; height: 16px; display: inline-block; background-color: %s"></div>;<br>',
        $pantoneColor->getUfName(),
        $pantoneColor->getUfHexCode(),
    );
    foreach ($pantoneColor->getUfColorTitles() as $colorTitle) {
        echo $colorTitle . '<br>';
    }
    echo '<br>';
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
