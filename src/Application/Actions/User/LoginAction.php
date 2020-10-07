<?php


namespace App\Application\Actions\User;


use App\Application\Actions\Action;
use App\Application\Response\User\LoginResponse;
use App\Application\Usecase\User\Login\UserLoginCommand;
use App\Application\Usecase\User\UserApplicationService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class LoginAction extends Action
{
    /**
     * @var UserApplicationService
     */
    private UserApplicationService $userApplicationService;

    /**
     * LoginAction constructor.
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
        $body = $this->request->getParsedBody();
        $data = $this->userApplicationService->login(new UserLoginCommand($body['email'], $body['password']));
        return $data === null
            ? $this->respondWithError(['email' => ['メールアドレスとパスワードを確認してください']], 401)
            : $this->respondWithData(new LoginResponse($data->getJwt()));

    }
}