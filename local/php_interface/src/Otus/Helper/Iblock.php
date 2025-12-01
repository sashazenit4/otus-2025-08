<?php
namespace Otus\Helper;

use Bitrix\Main\Loader;
use Bitrix\Iblock\IblockTable;
use Bitrix\Main\SystemException;

class Iblock
{
    public static function getIblockIdByCode(string $code): int
    {
        if (!Loader::includeModule('iblock')) {
            throw new SystemException('Не удалось загрузить модуль информационных блоков');
        }

        return IblockTable::getList([
            'filter' => [
                'CODE' => $code,
            ],
            'select' => [
                'ID',
            ],
            'limit' => 1,
            'cache' => [
                'ttl' => 360000000, 
            ],
        ])->fetch()['ID'] ?? throw new SystemException('Не найден инфоблок с символьным кодом ' . $code);
    }
}
