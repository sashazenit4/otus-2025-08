<?php
namespace Otus\Hlblock\Handlers;

use Bitrix\Main\Entity\Event;
use Bitrix\Main\Entity\EventResult;
use Bitrix\Highloadblock\HighloadblockTable;
use Bitrix\Main\Loader;

class PantoneColors
{
    public static function onBeforeAddHandler(Event $event): EventResult
    {
        $fields = $event->getParameters()['fields'];
        // $colorCode = $event->getParameter('UF_NAME'); # Pantone code
        $elementsCountWithSameName = self::getElementsWithSameNameCount($fields['UF_NAME']);
        if ($elementsCountWithSameName > 0) {
            $fields['UF_NAME'] .= sprintf('(%d)', $elementsCountWithSameName);
        }

        $result = new EventResult;

        $result->modifyFields($fields);

        $event->getEntity()->cleanCache();

        return $result;
    }

    protected static function getElementsWithSameNameCount(string $name): int
    {
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
            return 0;
        }

        $pantoneColorsEntity = HighloadblockTable::compileEntity($highloadBlockId);
        $pantoneColorsTableClass = $pantoneColorsEntity->getDataClass();
        return $pantoneColorsCollection = $pantoneColorsTableClass::getCount([
            '%UF_NAME' => $name,
        ]);
    }
}
