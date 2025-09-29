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

class BookTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'aholin_book';
    }

    public static function getMap(): array
    {
        return [
            (new IntegerField('ID'))
                ->configurePrimary()
                ->configureAutocomplete(),

            (new StringField('TITLE'))
                ->configureRequired()
                ->configureSize(255),

            (new IntegerField('YEAR')),

            (new IntegerField('PAGES')),

            (new TextField('DESCRIPTION')),

            (new DateField('PUBLISH_DATE')),

            (new ManyToMany('AUTHORS', AuthorTable::class))
                ->configureTableName('aholin_book_author')
                ->configureLocalPrimary('ID', 'BOOK_ID')
                ->configureRemotePrimary('ID', 'AUTHOR_ID'),

            (new ManyToMany('EDITORS', PersonalEditorTable::class))
                ->configureTableName('aholin_editor_book')
                ->configureLocalPrimary('ID', 'BOOK_ID')
                ->configureRemotePrimary('ID', 'EDITOR_ID'),

            (new IntegerField('PUBLISHER_ID')),

            (new Reference(
                'PUBLISHER',
                PublisherTable::class,
                Join::on('this.PUBLISHER_ID', 'ref.ID')
            ))
                ->configureJoinType('inner'),
        ];
    }
}
