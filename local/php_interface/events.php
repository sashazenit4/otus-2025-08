<?php
$eventManager = \Bitrix\Main\EventManager::getInstance();

//также есть суффиксы OnBeforeUpdate OnAfterAdd OnAfterUpdate OnBeforeDelete OnAfterDelete
$eventManager->addEventHandler('', 'PantoneColorsOnBeforeAdd', [
    '\Otus\Hlblock\Handlers\PantoneColors',
    'onBeforeAddHandler',
]);
$eventManager->addEventHandlerCompatible('rest', 'OnRestServiceBuildDescription', ['Otus\Rest\Events', 'OnRestServiceBuildDescriptionHandler']);
