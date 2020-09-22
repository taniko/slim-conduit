<?php


namespace App\Application\Response\User;


use App\Application\Usecase\User\Register\UserRegisterResult;

class RegisterResponse implements \JsonSerializable
{
    /**
     * @var UserRegisterResult
     */
    private UserRegisterResult $registerResult;

    /**
     * RegisterResponse constructor.
     *
     * @param UserRegisterResult $registerResult
     */
    public function __construct(UserRegisterResult $registerResult)
    {
        $this->registerResult = $registerResult;
    }

    public function jsonSerialize()
    {
        return [
            'jwt' => $this->registerResult->getJwt(),
        ];
    }
}