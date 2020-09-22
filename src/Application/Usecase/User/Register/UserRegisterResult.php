<?php


namespace App\Application\Usecase\User\Register;


class UserRegisterResult
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