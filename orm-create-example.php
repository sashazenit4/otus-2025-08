<?php
use Otus\Orm\BookTable;
use Otus\Orm\AuthorTable;
use Bitrix\Main\Type\Date;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Работа с собственными таблицами - добавление');

$authorId = AuthorTable::add([
    'FIRST_NAME' => 'Albus',
    'LAST_NAME' => 'Potter',
    'SECOND_NAME' => 'Severus',
    'BIRTH_DATE' => (new Date)->add('-6Y'),
    'BIOGRAPHY' => 'Сын Гарри Поттера',
])->getId();

$author = AuthorTable::getList([
    'filter' => [
        'ID' => $authorId
    ],
    'order' => [
        'ID' => 'DESC',
    ],
    'limit' => 1,
])->fetchObject();

$bookId = BookTable::add([
    'TITLE' => 'Книга, опубликованная в 2000 году',
    'YEAR' => 2000,
    'PAGES'=> 500,
    'DESCRIPTION' => 'Some book',
    'PUBLISH_DATE' => (new Date)->add('-25Y'), 
])->getId();

$book = BookTable::getList([
    'filter' => [
        'ID' => $bookId
    ],
    'order' => [
        'ID' => 'DESC',
    ],
    'limit' => 1,
])->fetchObject();

$book->addToAuthors($author);
$book->save();

echo sprintf(
    'Имя автора: %s; Второе имя автора: %s; Фамилия автора: %s; Биография автора: %s<br>',
    $author->getFirstName(),
    $author->getSecondName(),
    $author->getLastName(),
    $author->getBiography(),
);

$bookAuthors = $book->getAuthors();
foreach ($bookAuthors as $bookAuthor) {
    $firstBookAuthor = $bookAuthor;
    break;
}

$bookAuthorFullName = $firstBookAuthor->getFirstName() . ' ' . $firstBookAuthor->getSecondName() . ' ' . $firstBookAuthor->getLastName();
echo sprintf(
    'Имя автора: %s; Название: %s<br>',
    $bookAuthorFullName,
    $book->getTitle(),
);

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
