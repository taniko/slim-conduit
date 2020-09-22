<?php


namespace App\Infrastructure\Persistence\User;


use App\Domain\User\User;
use App\Domain\User\UserFactoryInterface;
use App\Domain\User\Username;
use Ramsey\Uuid\Uuid;

class InMemoryUserFactory implements UserFactoryInterface
{
    /**
     * @param Username $username
     * @param string   $name
     * @param string   $email
     * @param string   $password
     * @return User
     */
    public function create(Username $username, string $name, string $email, string $password): User
    {
        return new User(Uuid::uuid6(), $username, $name, $email, password_hash($password, PASSWORD_ARGON2ID));
    }
}