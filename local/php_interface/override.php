<?php

use Bitrix\Main\DI\ServiceLocator;
use Otus\Crm\Service\Container;

$crmServiceContainerClassName = Container::class;
ServiceLocator::getInstance()->addInstanceLazy('crm.service.container', [
    'className' => $crmServiceContainerClassName,
]);
