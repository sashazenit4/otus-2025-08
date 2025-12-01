<?php

use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\PageNavigation;
use Bitrix\Main\Grid\Options as GridOptions;
use Bitrix\Main\UI\Filter\Options as FilterOptions;
use Otus\Orm\BookTable;
use Otus\Orm\AuthorTable;
use Bitrix\Main\ORM\Query\Result;
use Bitrix\UI\Buttons\Color;
use Bitrix\Main\Error;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Errorable;
use Bitrix\Main\ErrorableImplementation;

class BookGrid extends \CBitrixComponent implements Controllerable, Errorable
{
    use ErrorableImplementation;

    protected const GRID_ID = 'BOOK_GRID';
    public function onPrepareComponentParams($arParams): array
    {
        $arParams['BOOK_PREFIX'] = strtolower($arParams['BOOK_PREFIX']);
        return $arParams;
    }

    public function listKeysSignedParameters(): array
    {
        return [
            'ORM_CLASS',
        ];
    }

    public function configureActions(): array
    {
        return [
            'deleteElement' => [
                'preFilters' => [
                    new \Bitrix\Main\Engine\ActionFilter\Authentication,
                ],
            ],
            'addElement' => [],
        ];
    }

    private function getElementActions(array $fields): array
    {
        return [
            [
                'onclick' => "window.open('http://otus-08.localhost/bitrix/admin/perfmon_row_edit.php?lang=ru&table_name=aholin_book&pk%5BID%5D={$fields['ID']}')", // метод обработчик в js
                'text' => Loc::getMessage('BOOK_GRID_OPEN_BOOK', [
                    '#BOOK_NAME#' => $fields['TITLE'],
                ]),
                'default' => true,
            ],
            [
                'onclick' => sprintf('BX.Otus.BookGrid.deleteBook(%d)', $fields['ID']),
                'text' => Loc::getMessage('BOOK_GRID_DELETE'),
                'default' => true,
            ],
            [
                'onclick' => sprintf('BX.Otus.BookGrid.deleteBookViaAjax(%d)', $fields['ID']),
                'text' => Loc::getMessage('BOOK_GRID_DELETE') . ' через AJAX',
                'default' => true,
            ],
        ];
    }

    /**
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     */
    public function addTestBookElementAction(array $bookData): array
    {
        $newBookData = [
            'TITLE' => $this->arParams['BOOK_PREFIX'] . $bookData['bookTitle'] ?? '',
            'YEAR' => $bookData['publishYear'] ?? 2000,
            'PAGES' => $bookData['pageCount'] ?? 0,
            'PUBLISH_DATE' => DateTime::createFromText($bookData['publishDate'] ?? ''),
        ];

        $addResult = BookTable::add($newBookData);
        if (!$addResult->isSuccess()) {
            $this->errorCollection->add([new Error('Не удалось создать книгу')]);
            return [];
        }

        $bookId = $addResult->getId();
        $book = BookTable::getByPrimary($bookId)->fetchObject();

        $authorIds = $bookData['authors'];
        foreach ($authorIds as $authorId) {
            $author = AuthorTable::getByPrimary($authorId)->fetchObject();
            if ($author) {
                $book->addToAuthors($author);
            }
        }

        $updateResult = $book->save();

        if (!$updateResult->isSuccess()) {
            $this->errorCollection->add([new Error('Не удалось добавить авторов')]);
            return [];
        }

        return [
            'BOOK_ID' => $bookId
        ];
    }

    private function getHeaders(): array
    {
        return [
            [
                'id' => 'ID',
                'name' => 'ID',
                'sort' => 'ID',
                'default' => true,
            ],
            [
                'id' => 'TITLE',
                'name' => Loc::getMessage('BOOK_GRID_BOOK_TITLE_LABEL'),
                'sort' => 'TITLE',
                'default' => true,
            ],
            [
                'id' => 'YEAR',
                'name' => Loc::getMessage('BOOK_GRID_BOOK_PUBLISHING_YEAR_LABEL'),
                'sort' => 'YEAR',
                'default' => true,
            ],
            [
                'id' => 'PAGES',
                'name' => Loc::getMessage('BOOK_GRID_BOOK_PAGES_LABEL'),
                'sort' => 'PAGES',
                'default' => true,
            ],
            [
                'id' => 'AUTHORS',
                'name' => Loc::getMessage('BOOK_GRID_BOOK_AUTHORS_LABEL'),
                'default' => true,
            ],
            [
                'id' => 'PUBLISH_DATE',
                'name' => Loc::getMessage('BOOK_GRID_BOOK_PUBLISHING_DATE_LABEL'),
                'sort' => 'PUBLISH_DATE',
                'default' => true,
            ],
        ];
    }

    protected function getButtons(): array
    {
        return [
            [
                // 'link' - ссылка
                'click' => 'redirectToExcel', // метод обработчик в js
                'text' => Loc::getMessage('EXPORT_XLSX_BUTTON_TITLE'),
                'color' => Color::PRIMARY,
            ],
            [
                'link' => '/stream/',
                'text' => Loc::getMessage('BOOK_GRID_GO_TO_LIVE_STREAM'),
                'color' => Color::SECONDARY,
            ],
            [
                'click' => 'BX.Otus.BookGrid.addBook',
                'text' => 'Добавить книгу',
                'color' => Color::PRIMARY_DARK,
            ],
            [
                'click' => 'BX.Otus.BookGrid.createTestElementViaModule',
                'text' => 'Добавить тестовую книгу',
                'color' => Color::DANGER_DARK,
            ],
            [
                'onclick' => 'showConfirmationBookPopup',
                'text' => 'Подтвердите согласие на чтение книг',
                'color' => Color::DANGER,
            ],
        ];
    }

    public function executeComponent(): void
    {
        if ($this->request->get('EXPORT_MODE') == 'Y') {
            $this->setTemplateName('excel');
        }

        $this->arResult['BUTTONS'] = $this->getButtons();
        $this->prepareGridData();

        $this->includeComponentTemplate();
    }

    /**
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     */
    private function prepareGridData(): void
    {
        $this->arResult['HEADERS'] = $this->getHeaders();
        $this->arResult['FILTER_ID'] = self::GRID_ID;

        $gridOptions = new GridOptions($this->arResult['FILTER_ID']);
        $this->arResult['USED_HEADERS'] = $gridOptions->getUsedColumns($this->arResult['HEADERS']);
        $navParams = $gridOptions->getNavParams();

        $nav = new PageNavigation($this->arResult['FILTER_ID']);

        $nav->allowAllRecords(true)
            ->setPageSize($navParams['nPageSize'])
            ->initFromUri();

        $filterOption = new FilterOptions($this->arResult['FILTER_ID']);
        $filterData = $filterOption->getFilter([]);
        $filter = $this->prepareFilter($filterData);

        $sort = $gridOptions->getSorting([
            'sort' => [
                'ID' => 'DESC',
            ],
            'vars' => [
                'by' => 'by',
                'order' => 'order',
            ],
        ]);

        $bookIdsQuery = BookTable::query()
            ->setSelect(['ID'])
            ->setFilter($filter)
            ->setLimit($nav->getLimit())
            ->setOffset($nav->getOffset())
            ->setOrder($sort['sort'])
        ;

        $countQuery = BookTable::query()
            ->setSelect(['ID'])
            ->setFilter($filter)
        ;
        $nav->setRecordCount($countQuery->queryCountTotal());

        $bookIds = array_column($bookIdsQuery->exec()->fetchAll() ?? [], 'ID');

        if (!empty($bookIds)) {
            $books = BookTable::getList([
                'filter' => ['ID' => $bookIds] + $filter,
                'select' => [
                    'ID',
                    'TITLE',
                    'YEAR',
                    'PAGES',
                    'PUBLISH_DATE',
                    'AUTHOR_ID' => 'AUTHORS.ID',
                    'AUTHOR_FIRST_NAME' => 'AUTHORS.FIRST_NAME',
                    'AUTHOR_LAST_NAME' => 'AUTHORS.LAST_NAME',
                    'AUTHOR_SECOND_NAME' => 'AUTHORS.SECOND_NAME',
                ],
                'order' => $sort['sort'],
            ]);

            $this->arResult['GRID_LIST'] = $this->prepareGridList($books);
        } else {
            $this->arResult['GRID_LIST'] = [];
        }

        $this->arResult['NAV'] = $nav;
        $this->arResult['UI_FILTER'] = $this->getFilterFields();
    }

    private function prepareFilter(array $filterData): array
    {
        $filter = [];

        if (!empty($filterData['FIND'])) {
            $filter['%TITLE'] = $filterData['FIND'];
        }

        if (!empty($filterData['TITLE'])) {
            $filter['%TITLE'] = $filterData['TITLE'];
        }

        if (!empty($filterData['YEAR_from'])) {
            $filter['>=YEAR'] = $filterData['YEAR_from'];
        }

        if (!empty($filterData['YEAR_to'])) {
            $filter['<=YEAR'] = $filterData['YEAR_to'];
        }

        if (!empty($filterData['PUBLISH_DATE_from'])) {
            $filter['>=PUBLISH_DATE'] = $filterData['PUBLISH_DATE_from'];
        }

        if (!empty($filterData['PUBLISH_DATE_to'])) {
            $filter['<=PUBLISH_DATE'] = $filterData['PUBLISH_DATE_to'];
        }

        return $filter;
    }

    private function prepareGridList(Result $books): array
    {
        $gridList = [];
        $groupedBooks = [];

        while ($book = $books->fetch()) {
            $bookId = $book['ID'];

            if (!isset($groupedBooks[$bookId])) {
                $groupedBooks[$bookId] = [
                    'ID' => $book['ID'],
                    'TITLE' => $book['TITLE'],
                    'YEAR' => $book['YEAR'],
                    'PAGES' => $book['PAGES'],
                    'PUBLISH_DATE' => $book['PUBLISH_DATE'],
                    'AUTHORS' => [],
                ];
            }

            if ($book['AUTHOR_ID']) {
                $groupedBooks[$bookId]['AUTHORS'][] = implode(' ', array_filter([
                    $book['AUTHOR_LAST_NAME'],
                    $book['AUTHOR_FIRST_NAME'],
                    $book['AUTHOR_SECOND_NAME']
                ]));
            }
        }

        $i = 1;
        foreach ($groupedBooks as $book) {
            $parentId = null;
            if (0 === $i % 2) { // usage of YODA conditions
                $parentId = $i - 1;
            }

            $gridList[] = [
                'id' => $i,
                'data' => [
                    'ID' => $book['ID'],
                    'TITLE' => $book['TITLE'],
                    'YEAR' => $book['YEAR'],
                    'PAGES' => $book['PAGES'],
                    'AUTHORS' => implode(', ', $book['AUTHORS']),
                    'PUBLISH_DATE' => $book['PUBLISH_DATE']?->format('d.m.Y'),
                ],
                'actions' => $this->getElementActions($book),
                'attrs' => [
                    'parent' => $parentId,
                    'is-section' => is_null($parentId),
                ],
            ];
            $i++;
        }

        return $gridList;
    }

    private function getFilterFields(): array
    {
        return [
            [
                'id' => 'TITLE',
                'name' => Loc::getMessage('BOOK_GRID_BOOK_TITLE_LABEL'),
                'type' => 'string',
                'default' => true,
            ],
            [
                'id' => 'YEAR',
                'name' => Loc::getMessage('BOOK_GRID_BOOK_PUBLISHING_YEAR_LABEL'),
                'type' => 'number',
                'default' => true,
            ],
            [
                'id' => 'PUBLISH_DATE',
                'name' => Loc::getMessage('BOOK_GRID_BOOK_PUBLISHING_DATE_LABEL'),
                'type' => 'date',
                'default' => true,
            ],
        ];
    }

    public function deleteElementAction(int $bookId): array
    {
        $this->errorCollection = new ErrorCollection();
        try {
            $ormClass = $this->arParams['ORM_CLASS'];
            $ormClass::delete($bookId);
        } catch (Exception $e) {
            $this->errorCollection->add([new Error($e->getMessage())]);
        }

        return [];
    }
}
