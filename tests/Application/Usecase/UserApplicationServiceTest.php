<?php


namespace Tests\Application\Usecase;


use App\Application\Usecase\User\Login\UserLoginCommand;
use App\Application\Usecase\User\UserApplicationService;
use App\Domain\Service\UserService;
use App\Domain\User\UserFactoryInterface;
use App\Domain\User\Username;
use App\Domain\User\UserRepository;
use Tests\TestCase;

class UserApplicationServiceTest extends TestCase
{
    public function testLogin()
    {
        $email      = 'alice@example.com';
        $password   = 'password';
        $repository = $this->getAppInstance()->getContainer()->get(UserRepository::class);
        $factory    = $this->getAppInstance()->getContainer()->get(UserFactoryInterface::class);
        $user       = $factory->create(
            new Username('alice'),
            'Alice',
            $email,
            $password
        );
        $repository->save($user);
        $service = new UserApplicationService(
            $factory,
            $repository,
            new UserService(),
        );
        $command = new UserLoginCommand($email, $password);
        $res     = $service->login($command);
        $this->assertNotNull($res);
        $this->assertIsString($res->getJwt());

        $command = new UserLoginCommand($email, 'Password');
        $res     = $service->login($command);
        $this->assertNull($res);

        $command = new UserLoginCommand('Alice@example.com', $password);
        $res     = $service->login($command);
        $this->assertNull($res);
    }
}