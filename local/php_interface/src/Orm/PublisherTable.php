<?php
namespace Otus\Orm;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;

class PublisherTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'aholin_publisher';
    }

    public static function getMap()
    {
        return [
            (new IntegerField('ID'))
                ->configurePrimary()
                ->configureAutocomplete(),

            (new StringField('TITLE'))
                ->configureRequired()
                ->configureSize(255),

            (new OneToMany('BOOKS', BookTable::class, 'PUBLISHER'))
                ->configureJoinType('inner'),
        ];
    }
}
