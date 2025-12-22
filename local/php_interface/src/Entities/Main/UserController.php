<?php
namespace Otus\Entities\Main;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;

class UserController
{
    public function __construct(private readonly UserRepository $userRepository)
    {

    }

    /**
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws ArgumentException
     * @throws \Exception
     */
    public function handle(string $email): string
    {
        $user = $this->userRepository->findByEmail($email);
        if (empty($user)) {
            throw new \Exception('Пользователь не найден!');
        }
        return <<<RESPONSE
Имя пользователя: $user->name
RESPONSE;
    }
}