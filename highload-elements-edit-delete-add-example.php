<?php

use Bitrix\Highloadblock\HighloadblockTable;
use Bitrix\Main\Loader;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */
$APPLICATION->SetTitle('Пример добавления, изменения, удаления элементов highload-блоков');

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

// $colorAddResult = $pantoneColorsTableClass::add([
//     'UF_NAME' => '18-1750',
//     'UF_HEX_CODE' => '#BB2649',
//     'UF_COLOR_TITLES' => [
//         'Viva Magenta',
//         'Color of The Year 2023',
//     ],
// ]);

// echo 'Id созданного цвета: ' . $colorAddResult->getId();

// $colorUpdateResult = $pantoneColorsTableClass::update(3, ['UF_COLOR_TITLES' => [
//     'Viva Magenta',
//     'Color of The Year 2023',
//     'Люимый цвет босса',
// ]]);
    
// echo 'Id измененного цвета: ' . $colorUpdateResult->getId();

// $pantoneColorsTableClass::delete(3);

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
