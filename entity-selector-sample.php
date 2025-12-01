<?php

use Bitrix\Main\UI\Extension;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Форма с кастомизированными инпутами');
Extension::load('aclips.ui-selector');

?>

<form>
    <select name="service[]" multiple id="service">
        <option data-tab="tab_1" selected value="1c">1С</option>
        <option data-tab="tab_2" value="bitrix">Битрикс CMS</option>
        <option data-tab="tab_3" value="bitrix24">Битрикс 24</option>
    </select>
</form>
<script>
    BX.Plugin.UiSelector.createTagSelector(BX('service'), {
            tabs: [
                {id: 'tab_1', title: 'ERP', itemOrder: {title: 'asc'}},
                {id: 'tab_2', title: 'CMS', itemOrder: {title: 'asc'}},
                {id: 'tab_3', title: 'CRM', itemOrder: {title: 'asc'}},
            ]
        });
</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
