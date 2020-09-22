<?php
declare(strict_types=1);

namespace App\Domain\User;

interface UserRepository
{
    /**
     * @param string $id
     * @return User
     * @throws UserNotFoundException
     */
    public function findUserOfId(string $id): User;

    /**
     * @param Username $username
     * @return User
     * @throws UserNotFoundException
     */
    public function findByUsername(Username $username): User;

    /**
     * @param User $user
     * @return User|null
     */
    public function findByUsernameOrEmail(User $user): ?User;

    /**
     * @param User $user
     */
    public function save(User  $user);
}
