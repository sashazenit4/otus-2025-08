<?php
namespace Otus\DI;

use Bitrix\Main\UserTable;
use Psr\Container\ContainerInterface;
use Otus\Entities\Main\UserRepository;
use Otus\Entities\Main\UserController;

class Container implements ContainerInterface
{
    private array $objects = [];

    public function __construct()
    {
        // Ключи в этом массиве - строковые ID объектов
        // Значения - функции, строящие нужный объект
        $this->objects = [
            UserRepository::class => fn() => new UserRepository(UserTable::class),
            UserController::class => fn() => new UserController($this->get(UserRepository::class)),
        ];
    }

    public function has(string $id): bool
    {
        return isset($this->objects[$id]);
    }

    public function get(string $id): mixed
    {
        if ($id === 'source') {
            return $this->objects[$id];
        }

        return $this->objects[$id]();
    }
}
