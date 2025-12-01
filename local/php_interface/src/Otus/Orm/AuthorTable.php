<?php

namespace Otus\Orm;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\TextField;
use Bitrix\Main\ORM\Fields\DateField;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Query\Join;

Loc::loadMessages(__FILE__);

class AuthorTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'aholin_author';
    }

    public static function getMap(): array
    {
        return [
            (new IntegerField('ID'))
                ->configurePrimary()
                ->configureAutocomplete()
                ->configureTitle(Loc::getMessage('AHOLIN_CRMCUSTOMTAB_AUTHOR_TABLE_ID')),

            (new StringField('FIRST_NAME'))
                ->configureRequired()
                ->configureSize(100),

            (new StringField('LAST_NAME'))
                ->configureRequired()
                ->configureSize(100),

            (new StringField('SECOND_NAME'))
                ->configureSize(100),

            (new DateField('BIRTH_DATE')),

            (new TextField('BIOGRAPHY')),

            (new ManyToMany('BOOKS', BookTable::class))
                ->configureTableName('aholin_book_author')
                ->configureLocalPrimary('ID', 'AUTHOR_ID')
                ->configureRemotePrimary('ID', 'BOOK_ID'),

            (new Reference('PERSONAL_EDITOR', PersonalEditorTable::class, Join::on('this.ID', 'ref.AUTHOR_ID')))
                ->configureJoinType('inner'),
        ];
    }
}
