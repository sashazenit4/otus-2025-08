<?php
namespace Otus\Crm\Lead;

use Bitrix\Crm\LeadTable;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Main\Type\DateTime;

class Agents
{
    /**
     * @throws LoaderException
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public static function cleanOldLeads(int $days): string
    {
        Loader::includeModule('crm');
        $now = new DateTime();
        $now->add(sprintf('-%d days', $days));
        $leadsToTransfer = LeadTable::getList([
            'filter' => [
                '<DATE_CREATE' => $now->format('d.m.Y h:i:s'),
                'STATUS_ID' => 'NEW',
            ],
            'select' => [
                'ID',
            ],
        ])?->fetchAll() ?? [];
        if (count($leadsToTransfer) === 0) {
            return sprintf('\Otus\Crm\Lead\Agents::cleanOldLeads(%d);', $days);
        }

        $leadIdsToMove = array_column($leadsToTransfer, 'ID');
        LeadTable::updateMulti($leadIdsToMove, [
            'STATUS_ID' => 'JUNK',
        ]);

        return sprintf('\Otus\Crm\Lead\Agents::cleanOldLeads(%d);', $days);
    }
}
