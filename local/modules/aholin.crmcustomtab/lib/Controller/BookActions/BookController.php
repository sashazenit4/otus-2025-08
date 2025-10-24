<?php
namespace Aholin\Crmcustomtab\Controller\BookActions;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Engine\Response\Component;
use Otus\Orm\BookTable;

class BookController extends Controller
{
    public function configureActions(): array
    {
        return [
            'createTestElement' => [
                'prefilters' => [],
            ],
            'showNewGrid' => [
                'prefilters' => [],
            ],
        ];
    }

    public function createTestElementAction(): array
    {
        try {
            $addResult = BookTable::add([
                'TITLE' => 'Тестовая книга ' . rand(1000, 9999),
                'YEAR' => rand(1900, date('Y')),
                'PAGES' => rand(50, 500),
                'PUBLISH_DATE' => new \Bitrix\Main\Type\DateTime(),
            ]);

            if ($addResult->isSuccess()) {
                $result['BOOK_ID'] = $addResult->getId();
            } else {
                $this->errorCollection->add($addResult->getErrorMessages());
                return [];
            }
        } catch (\Exception $e) {
            $this->errorCollection->add([new Error($e->getMessage())]);
            return [];
        }

        return $result;
    }

    public function showNewGridAction(): Component
    {
        return new Component('bitrix:news.list', '', [
            'IBLOCK_ID' => 3,
        ]);
    }
}
