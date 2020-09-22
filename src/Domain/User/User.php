<?php
declare(strict_types=1);

namespace App\Domain\User;

use JsonSerializable;
use Ramsey\Uuid\Uuid;

class User implements JsonSerializable
{
    private string $id;
    private Username $username;
    private string $email;
    private string $password;
    private string $name;

    /**
     * User constructor.
     *
     * @param string|null $id
     * @param Username    $username
     * @param string      $name
     * @param string      $email
     * @param string      $password
     */
    public function __construct(?string $id, Username $username, string $name, string $email, string $password)
    {
        $this->id       = $id ?? Uuid::uuid6()->toString();
        $this->username = $username;
        $this->name     = $name;
        $this->email    = $email;
        $this->password = $password;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return Username
     */
    public function getUsername(): Username
    {
        return $this->username;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'username' => $this->username,
            'name'     => $this->name,
        ];
    }
}
