<?php

use Otus\Orm\AuthorTable;
use Bitrix\Main\Entity\Query;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Работа с собственными таблицами - чтение 1 к 1');

$query = new Query(AuthorTable::class);
$query->setSelect([
    'ID',
    'FIRST_NAME',
    'EDITOR_FIRST_NAME' => 'PERSONAL_EDITOR.FIRST_NAME',
]);

$authorResult = $query->exec();
$authors = [];
while ($author = $authorResult->fetch()) {
    dump($author);
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
