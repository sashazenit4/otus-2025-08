<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Решение задачи FizzBuzz для 100');

function fizzBuzz(int $limit): void
{
    for ($i = 0; $i <= $limit; $i++) {
        if ($i % 3 == 0) {
            echo 'FIZZ';
        } elseif ($i % 5 == 0) {
            echo 'BUZZ';
        } else {
            echo $i;
        }
        echo '</br>';
    }
}

fizzBuzz(100);

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
?>