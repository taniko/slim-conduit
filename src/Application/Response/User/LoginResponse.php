<?php


namespace App\Application\Response\User;


use JsonSerializable;

class LoginResponse implements JsonSerializable
{
    private string $jwt;

    /**
     * LoginResponse constructor.
     *
     * @param string $jwt
     */
    public function __construct(string $jwt)
    {
        $this->jwt = $jwt;
    }

    public function jsonSerialize()
    {
        return [
            'jwt' => $this->jwt,
        ];
    }
}