<?php


namespace App\Application\Actions\User;


use App\Application\Actions\Action;
use App\Application\Response\User\RegisterResponse;
use App\Application\Usecase\User\Register\UserRegisterCommand;
use App\Application\Usecase\User\UserApplicationService;
use App\Domain\User\DuplicateEmailException;
use App\Domain\User\DuplicateUsernameException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class RegisterAction extends Action
{
    /**
     * @var UserApplicationService
     */
    private UserApplicationService $userApplicationService;

    /**
     * RegisterAction constructor.
     *
     * @param LoggerInterface        $logger
     * @param UserApplicationService $userApplicationService
     */
    public function __construct(LoggerInterface $logger, UserApplicationService $userApplicationService)
    {
        parent::__construct($logger);
        $this->userApplicationService = $userApplicationService;
    }

    protected function action(): Response
    {
        try {
            $body = $this->request->getParsedBody();
            $data = $this->userApplicationService->register(new UserRegisterCommand(
                $body['username'],
                $body['name'],
                $body['email'],
                $body['password'],
            ));
        } catch (DuplicateEmailException $e) {
            return $this->respondWithError(['email' => 'すでにメールアドレスは使用されています'], 400);
        } catch (DuplicateUsernameException $e) {
            return $this->respondWithError(['username' => 'すでにユーザ名は使用されています'], 400);
        }
        return $this->respondWithData(new RegisterResponse($data));
    }
}