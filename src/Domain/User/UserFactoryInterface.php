<?php


namespace App\Domain\User;


interface UserFactoryInterface
{
    public function create(Username $username, string $name,string $email, string $password): User;
}