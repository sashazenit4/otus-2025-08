<?php

use Bitrix\Main\UI\Extension;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/events.php';

function logAgents($agent, $event, $evalResult = null, $error = ''): void
{
    $isAgentLogging = match ($agent['ID']) {
        '1000000' => true,
        default => false,
    };
    if ($isAgentLogging) {
        \Bitrix\Main\Diag\Debug::writeToFile([
            'agent' => $agent,
            'event' => $event,
            'evalResult' => $evalResult,
            'error' => $error,
        ], null, str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__ . '/agent_log.log'));
    }
}

define('BX_AGENTS_LOG_FUNCTION', 'logAgents');

Extension::load([
    'otus.crm.negative_currency',
]);

require __DIR__ . '/override.php';
