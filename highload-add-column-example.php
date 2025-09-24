<?php

use Bitrix\Highloadblock\HighloadblockTable;
use Bitrix\Main\Loader;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */
$APPLICATION->SetTitle('Пример создания нового поля для highload-блока');

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

$newPantoneColorsField = [
    'USER_TYPE_ID' => 'string',
    'ENTITY_ID' => 'HLBLOCK_' . $highloadBlockId,
    'FIELD_NAME' => 'UF_DESCRIPTION',
    'XML_ID' => 'DESCRIPTION',
    'SORT' => 100,
    'MULTIPLE' => 'N',
    'MANDATORY' => 'N',
    'SHOW_FILTER' => 'Y',
    'SHOW_IN_LIST' => 'Y',
    'EDIT_IN_LIST' => 'Y',
    'IS_SEARCHABLE' => 'Y',
    'SETTINGS' => [
        'EDIT_FORM_LABEL' => [
            'ru' => 'Описание цвета',
            'en' => 'Color description',
        ],
    ],
];

$userTypeEntity = new \CUserTypeEntity();
$newFieldAddResult = $userTypeEntity->Add($newPantoneColorsField);

echo !empty($newFieldAddResult) ? 'Поле создалось': 'Ошибка';

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
