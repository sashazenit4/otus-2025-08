<?php

namespace Otus\Orm;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Query\Join;

Loc::loadMessages(__FILE__);

class PersonalEditorTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'aholin_personal_editor';
    }

    public static function getMap(): array
    {
        return [
            (new IntegerField('ID'))
                ->configurePrimary()
                ->configureAutocomplete(),

            (new StringField('FIRST_NAME'))
                ->configureRequired()
                ->configureSize(100),

            (new StringField('LAST_NAME'))
                ->configureRequired()
                ->configureSize(100),

            (new StringField('SECOND_NAME'))
                ->configureSize(100),

            (new IntegerField('AUTHOR_ID'))
                ->configureUnique(),

            (new Reference('AUTHOR', AuthorTable::class, Join::on('this.AUTHOR_ID', 'ref.ID')))
                ->configureJoinType('inner'),
        
            (new ManyToMany('BOOKS', BookTable::class))
                ->configureTableName('aholin_editor_book')
                ->configureLocalPrimary('ID', 'EDITOR_ID')
                ->configureRemotePrimary('ID', 'BOOK_ID'),
        ];
    }
}
