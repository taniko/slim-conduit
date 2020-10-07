<?php


namespace App\Application\Usecase\User\Login;


class UserLoginResult
{
    private string $jwt;

    /**
     * UserRegisterResult constructor.
     *
     * @param string $jwt
     */
    public function __construct(string $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * @return string
     */
    public function getJwt(): string
    {
        return $this->jwt;
    }
}