<?php
namespace Otus\Entities\Main;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Main\Entity\Query;

class UserRepository
{
    /**
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws ArgumentException
     */
    public function findByEmail(string $email): ?User
    {
        $userQuery = new Query($this->source);
        $userQuery->setFilter([
            'EMAIL' => $email,
        ]);
        $userQuery->setSelect([
            'EMAIL',
            'NAME',
        ]);

        $userBitrixObject = $userQuery->exec()->fetch();

        if (!$userBitrixObject) {
            return null;
        }

        $user = new User();
        $user->email = $userBitrixObject['EMAIL'] ?? '';
        $user->name = $userBitrixObject['NAME'] ?? '';

        return $user;
    }

    public function __construct(private readonly string $source)
    {
    }
}