<?php

use Bitrix\Main\Web\Json;
use Bitrix\UI\Toolbar\Facade\Toolbar;
use Bitrix\Main\Loader;
use Bitrix\Main\UI\Extension;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

/**
 * @var array $arResult
 * @var array $arParams
 * @global $APPLICATION
 * @global $component
 */

Loader::includeModule('ui');
Extension::load(['otus.modal.dialog', 'date']);
foreach ($arResult['BUTTONS'] as $button) {
    Toolbar::addButton($button);
}

Toolbar::addFilter([
    'FILTER_ID' => $arResult['FILTER_ID'],
    'GRID_ID' => $arResult['FILTER_ID'],
    'ENABLE_FIELDS_SEARCH' => false,
    'FILTER' => $arResult['UI_FILTER'],
    'ENABLE_LIVE_SEARCH' => true,
    'ENABLE_LABEL' => true
]);

$APPLICATION->IncludeComponent(
    'bitrix:main.ui.grid',
    '',
    [
        /**
         * GRID_ID идентификатор, по которому можно обращаться к гриду и php и js, менять его настройки, а также
         * можно сделать связь грида и фильтра
        */
        'GRID_ID' => $arResult['FILTER_ID'],
        /**
         * Массив заголовков таблицы
         */
        'HEADERS' => $arResult['HEADERS'],
        /**
         * записи
         */
        'ROWS' => $arResult['GRID_LIST'],
        /**
         * Сколько всего есть записей
         */
        'TOTAL_ROWS_COUNT' => $arResult['NAV']->getRecordCount(),
        'NAV_OBJECT' => $arResult['NAV'],
        'AJAX_MODE' => 'Y',
        'AJAX_LOADER' => $arParams['AJAX_LOADER'],
        'ALLOW_COLUMNS_SORT' => true,
        'ALLOW_ROWS_SORT' => [],
        'ALLOW_COLUMNS_RESIZE' => true,
        'ALLOW_HORIZONTAL_SCROLL' => true,
        'ALLOW_SORT' => true,
        'ALLOW_PIN_HEADER' => true,
        /**
         * Описытаельный массив групповых действий
         */
        'ACTION_PANEL' => [],
        'SHOW_CHECK_ALL_CHECKBOXES' => false,
        'SHOW_ROW_CHECKBOXES' => false,
        'SHOW_ROW_ACTIONS_MENU' => true,
        'SHOW_GRID_SETTINGS_MENU' => true,
        'SHOW_NAVIGATION_PANEL' => true,
        'SHOW_PAGINATION' => true,
        'SHOW_SELECTED_COUNTER' => true,
        'SHOW_TOTAL_COUNTER' => true,
        'SHOW_PAGESIZE' => true,
        'SHOW_ACTION_PANEL' => true,
        'ENABLE_COLLAPSIBLE_ROWS' => true,
        'ALLOW_SAVE_ROWS_STATE' => true,
        'SHOW_MORE_BUTTON' => false,
        'CURRENT_PAGE' => '',
        'DEFAULT_PAGE_SIZE' => 20,
        'PAGE_SIZES' => [
            ['NAME' => 1, 'VALUE' => 1],
            ['NAME' => 5, 'VALUE' => 5],
            ['NAME' => 10, 'VALUE' => 10],
            ['NAME' => 20, 'VALUE' => 20],
            ['NAME' => 50, 'VALUE' => 50],
        ],
    ],
    $component,
);?>
<script>
    function redirectToExcel() {
        // если гет параметров нет то добавляй новый
        window.open(window.location.href + '&EXPORT_MODE=Y', '_self');
    }
</script>
<?php if (!empty($arParams['AJAX_LOADER'])) { ?>
    <script>
        BX.addCustomEvent('Grid::beforeRequest', function (gridData, argse) {
            if (argse.gridId !== '<?=$arResult['FILTER_ID'];?>') {
                return;
            }

            if (argse.url === '') {
                argse.url = "<?=$component->getPath()?>/lazyload.ajax.php?site=<?=\SITE_ID?>&internal=true&grid_id=<?=$arResult['FILTER_ID']?>&grid_action=filter&"
            }

            argse.method = 'POST'
            argse.data = <?= Json::encode($arParams['AJAX_LOADER']['data']) ?>;
        });
    </script>
<?php } ?>
