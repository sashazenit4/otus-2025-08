<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Vue app');
\Bitrix\Main\UI\Extension::load('otus.fruits');
?>
<div id="fruits">

</div>
<script>
    BX.ready(() => {
        const container = document.getElementById('fruits');
        const fruits = [
            {
                name: 'apple',
                img: 'apple.png',
            }
        ];
        new BX.Otus.Fruits({
            container,
            fruits
        });
    });
</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
