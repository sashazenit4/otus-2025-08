<?php
use Otus\Orm\BookTable;
use Otus\Orm\AuthorTable;
use Bitrix\Main\Entity\Query;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Работа с собственными таблицами - чтение');

$query = new Query(BookTable::class);
$query->setSelect([
    'ID',
    'TITLE',
    'PUBLISH_DATE',
    'AUTHOR_FIRST_NAME' => 'AUTHORS.FIRST_NAME',
    'AUTHOR_SECOND_NAME' => 'AUTHORS.SECOND_NAME',
    'AUTHOR_LAST_NAME' => 'AUTHORS.LAST_NAME',
    'EDITOR_FIRST_NAME' => 'EDITORS.FIRST_NAME',
]);

$bookResult = $query->exec();
$books = [];
while ($book = $bookResult->fetch()) {
    $bookId = $book['ID'];

    if (!isset($books[$bookId])) {
        $books[$bookId] = [
            'ID' => $bookId,
            'TITLE' => $book['TITLE'],
            'PUBLISH_DATE' => $book['PUBLISH_DATE'],
            'AUTHORS' => [],
            'EDITORS' => [],
        ];
    }

    $authorFullName = trim(sprintf('%s %s %s',
        $book['AUTHOR_FIRST_NAME'] ?? '',
        $book['AUTHOR_SECOND_NAME'] ?? '',
        $book['AUTHOR_LAST_NAME'] ?? ''
    ));

    if (!empty($authorFullName) && !in_array($authorFullName, $books[$bookId]['AUTHORS'])) {
        $books[$bookId]['AUTHORS'][] = $authorFullName;
    }

    $editorFullName = trim(sprintf('%s %s %s',
        $book['EDITOR_FIRST_NAME'] ?? '',
        $book['EDITOR_SECOND_NAME'] ?? '',
        $book['EDITOR_LAST_NAME'] ?? ''
    ));

    if (!empty($editorFullName) && !in_array($editorFullName, $books[$bookId]['EDITORS'])) {
        $books[$bookId]['EDITORS'][] = $editorFullName;
    }
}

dump($books);

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
