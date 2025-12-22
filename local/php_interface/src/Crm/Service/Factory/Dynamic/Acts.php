<?php
namespace Otus\Crm\Service\Factory\Dynamic;

use Bitrix\Crm\Item;
use Bitrix\Crm\Service\Context;
use Bitrix\Crm\Service\Operation;
use Otus\Crm\Service\Factory\Dynamic as OtusDynamic;
use Bitrix\Main\Result;
use Bitrix\Crm\Service\Operation\Action;

class Acts extends OtusDynamic
{
    public function getAddOperation(Item $item, Context $context = null): Operation\Add
    {
        $addOperation = parent::getAddOperation($item, $context);

        $addOperation->addAction($addOperation::ACTION_AFTER_SAVE, new class extends Action {
            public function process(Item $item): Result
            {
                $result = new Result();

                $item->setTitle(sprintf('Акт 32132123231321 № %d', $item->getId()));
                $item->save();
                $result->setData([
                    'item' => $item,
                ]);

                return $result;
            }
        });
        return $addOperation;
    }
}
