<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\Username;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;

class InMemoryUserRepository implements UserRepository
{
    /**
     * @var User[]
     */
    private array $users;

    /**
     * InMemoryUserRepository constructor.
     *
     * @param array|null $users
     */
    public function __construct(array $users = null)
    {
        $this->users = $users ?? [
                new User('1', new Username('bill'), 'Bill', 'bill@example.com', password_hash('password', PASSWORD_ARGON2ID)),
                new User('2', new Username('steve'), 'Steve', 'steve@example.com', password_hash('password', PASSWORD_ARGON2ID)),
                new User('3', new Username('mark'), 'Mark', 'mark@example.com', password_hash('password', PASSWORD_ARGON2ID)),
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function findUserOfId(string $id): User
    {
        $result = null;
        foreach ($this->users as $user) {
            if ($user->getId() === $id) {
                $result = $user;
            }
        }
        if ($result === null) {
            throw new UserNotFoundException();
        }
        return $result;
    }

    /**
     * @param Username $username
     * @return User
     * @throws UserNotFoundException
     */
    public function findByUsername(Username $username): User
    {
        $result = null;
        $value  = $username->getValue();
        foreach ($this->users as $user) {
            if ($user->getUsername()->getValue() === $value) {
                $result = $user;
            }
        }
        if ($result === null) {
            throw new UserNotFoundException();
        }
        return $result;
    }

    public function findByUsernameOrEmail(User $user): ?User
    {
        $result = null;
        foreach ($this->users as $item) {
            if ($user->getEmail() === $item->getEmail()
                || $user->getUsername()->getValue() === $item->getUsername()->getValue()
            ) {
                $result = $item;
            }
        }
        return $result;
    }

    public function save(User $user)
    {
        $exists = false;
        foreach ($this->users as $i => $u) {
            if ($user->getEmail() === $u->getEmail()
                || $user->getUsername()->getValue() === $u->getUsername()->getValue()
            ) {
                $exists          = true;
                $this->users[$i] = $user;
                break;
            }
        }
        if (!$exists) {
            $this->users[] = $user;
        }
    }
}
