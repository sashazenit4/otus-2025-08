<?php

use Otus\Orm\PublisherTable;
use Bitrix\Main\Entity\Query;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Работа с собственными таблицами - чтение издательств');

$query = new Query(PublisherTable::class);
$query->setSelect([
    'ID',
    'TITLE',
    'BOOK_TITLE' => 'BOOKS.TITLE',
]);

$publisherResult = $query->exec();
$publishers = [];
while ($publisher = $publisherResult->fetch()) {
    $publisherId = $publisher['ID'];
    if (!isset($publishers[$publisherId])) {
        $publishers[$publisherId] = [
            'TITLE' => $publisher['TITLE'],
            'BOOKS' => [],
        ];
    }

    if (
        isset($publisher['BOOK_TITLE']) &&
        !in_array($publisher['BOOK_TITLE'], $publishers[$publisherId]['BOOKS'])
    ) {
        $publishers[$publisherId]['BOOKS'][] = $publisher['BOOK_TITLE'];
    }
}

dump($publishers);

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
