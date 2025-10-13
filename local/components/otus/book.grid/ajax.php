<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Otus\Orm\BookTable;
use Bitrix\Main\Error;

class BookGridAjaxController extends \Bitrix\Main\Engine\Controller
{
    public function configureActions(): array
    {
        return [
            'deleteElement' => [
                'prefilters' => [],
            ],
            'createTestElement' => [
                'prefilters' => [],
                'postfilters' => [],
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
}
