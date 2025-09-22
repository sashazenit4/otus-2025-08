<?php
use Bitrix\Main\Loader;

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->setTitle('Установка реквизитов компании');

if (!Loader::includeModule('crm')) {
    return;
}

$reqInfo = [
    'LAST_NAME' => 'Холин',
    'NAME' => 'Александр',
    'SECOND_NAME' => 'Владимирович',
    'INN' => 777766654212,
    'OGRNIP' => 456789056789056,
    'OKVED_CODE' => '00.00',
];
$companyId = 7;
$entityRequisite = new \Bitrix\Crm\EntityRequisite;
$reqFields = [
    'ENTITY_ID' => $companyId,
    'ENTITY_TYPE_ID' => CCrmOwnerType::Company,
    'PRESET_ID' => 2,
    'NAME' => 'ИП '.$reqInfo['LAST_NAME'].' '.$reqInfo['NAME'].' '.$reqInfo['SECOND_NAME'],
    'SORT' => 500,
    'ACTIVE' => 'Y',
    'RQ_LAST_NAME' => $reqInfo['LAST_NAME'],
    'RQ_FIRST_NAME' => $reqInfo['NAME'],
    'RQ_SECOND_NAME' => $reqInfo['SECOND_NAME'],
    'RQ_COMPANY_FULL_NAME' => $reqInfo['NAME'],
    'RQ_INN' => $reqInfo['INN'],
    'RQ_OGRNIP' => $reqInfo['OGRNIP'],
    'RQ_OKVED' => $reqInfo['OKVED_CODE'],
];
$result = $entityRequisite->add($reqFields);
dump($result);

$companyId = 7;
$entityRequisite = new \Bitrix\Crm\EntityRequisite ;
$rawRequisites = $entityRequisite->getList([
    'select'=> ['*'],
    'filter'=> [
        'ENTITY_ID' => $companyId,
        'ENTITY_TYPE_ID' =>\CCrmOwnerType::Company
    ],
]);
$companyRequisites = $rawRequisites ->fetchAll();
foreach ($companyRequisites as $companyRequisite ) {
    dump($companyRequisite);
}

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
