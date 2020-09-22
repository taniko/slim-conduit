<?php


namespace App\Application\Usecase\User\Register;


class UserRegisterCommand
{
    private string $username;
    private string $name;
    private string $email;
    private string $password;

    /**
     * UserRegisterCommand constructor.
     *
     * @param string $username
     * @param string $name
     * @param string $email
     * @param string $password
     */
    public function __construct(string $username, string $name, string $email, string $password)
    {
        $this->username = $username;
        $this->name     = $name;
        $this->email    = $email;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}