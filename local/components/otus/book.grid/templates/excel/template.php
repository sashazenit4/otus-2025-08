<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet; // Импорт класса Spreadsheet из библиотеки PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; // Импорт класса Xlsx из библиотеки PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Style\Alignment;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

/**
 * @var array $arResult
 * @var array $arParams
 * @global $APPLICATION
 * @global $component
 */

while (ob_get_level()) {
    ob_end_clean();
}

$spreadSheet = new Spreadsheet(); // Создание нового объекта класса Spreadsheet

$activeSheet = $spreadSheet->getActiveSheet(); // Получение активного листа из объекта $spreadSheet

$column = 'A'; // Инициализация переменной $column со значением 'A'
foreach ($arResult['HEADERS'] as $value) { // Цикл по элементам массива $arResult['COLUMNS']
    if (in_array($value['id'], $arResult['USED_HEADERS'])) {
        $activeSheet->setCellValue($column.'1', $value['name']); // Установка значения ячейки с помощью метода setCellValue для текущего столбца и строки 1
        $column++; // Инкрементация переменной $column для перехода к следующему столбцу
    }
}

$headersStyleArray = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => '444444'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
    ],
];

$rowStyleArray = [
    'font' => [
        'italic' => true,
        'color' => ['rgb' => '00ff00'],
    ],
];

$activeSheet->getStyle('A1:' . $column . '1')->applyFromArray($headersStyleArray);

$row = 2; // Установка начального значения переменной $row равным 2 для начала заполнения строк со второй
foreach ($arResult['GRID_LIST'] as $value) { // Цикл по элементам массива $arResult['LIST']
    $column = 'A'; // Сброс переменной $column в начало столбца перед каждой строкой
    foreach ($value['data'] as $fieldId => $itemText) { // Цикл по элементам массива $value['data']
        if (in_array($fieldId, $arResult['USED_HEADERS'])) {
            $activeSheet->setCellValue($column.$row, $itemText); // Установка значения ячейки с помощью метода setCellValue для текущего столбца и строки $row
            $column++; // Инкрементация переменной $column для перехода к следующему столбцу
        }
    }

    if ($row % 2 == 0) {
        $activeSheet->getStyle('A' . $row . ':' . $column . $row)->applyFromArray($rowStyleArray);
    }

    $row++; // Инкрементация переменной $row для перехода к следующей строке
}

foreach ($activeSheet->getColumnIterator() as $column) {
    $activeSheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
}

$activeSheet->setTitle('Книги');

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="books.xlsx"');
// header('Content-Type: application/pdf');
// header('Content-Disposition: attachment;filename="books.pdf"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadSheet); // Создание нового объекта класса Xlsx с передачей объекта $spreadSheet в конструктор
// $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadSheet);
$writer->save('php://output');

die();
