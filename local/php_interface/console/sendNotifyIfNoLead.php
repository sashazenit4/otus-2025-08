<?php
declare(strict_types=1);

use Bitrix\Main\Loader;
use Bitrix\Crm\LeadTable;
use Bitrix\Main\UserTable;

if (php_sapi_name() != 'cli') {
    die();
}

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('BX_NO_ACCELERATOR_RESET', true);
define('BX_CRONTAB', true);
define('STOP_STATISTICS', true);
define('NO_AGENT_STATISTIC', 'Y');
define('DisableEventsCheck', true);
define('NO_AGENT_CHECK', true);

$_SERVER['DOCUMENT_ROOT'] = realpath('/home/bitrix/www');
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

if (!Loader::includeModule('crm') || !Loader::includeModule('im')) {
    return;
}

$leadCount = LeadTable::getCount([
    'STATUS_ID' => 'NEW',
]);

$admin = UserTable::getById(1)->fetch();
$fio = sprintf('%s %s %s', $admin['LAST_NAME'], $admin['NAME'], $admin['SECOND_NAME']);
if (0 === $leadCount) {
    \CIMNotify::Add([
        'MESSAGE' => sprintf('Сегодня мало лидов, %s', $fio),
        'TO_USER_ID' => 1,
        'FROM_USER_ID' => 1,
        'NOTIFY_MODULE' => 'crm',
    ]);
}
