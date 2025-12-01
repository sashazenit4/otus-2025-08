<?php

use Bitrix\UI\Toolbar\Facade\Toolbar;
use Bitrix\UI\Buttons\Color;
use Bitrix\Main\UI\Extension;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Кнопка, открывающая страницу в слайдере');
$button = [
    'click' => 'openSlider',
    'text' => 'Открыть список книг в слайдере',
    'color' => Color::SUCCESS,
];

Toolbar::addButton($button);
?>
<script>
    function openSlider() {
        BX.SidePanel.Instance.open('/excel-export.php');
    }
</script>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
