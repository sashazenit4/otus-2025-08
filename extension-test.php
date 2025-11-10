<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

use Bitrix\Main\UI\Extension;

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Расширение для демонстрации');
Extension::load(['otus.greetingmessage']);
?>
<script>
    BX.ready(() => {
        let m = new BX.Otus.Greetingmessage();
        m.helloWorld();
    });
</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
