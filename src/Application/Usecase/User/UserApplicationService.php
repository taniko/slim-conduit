<?php


namespace App\Application\Usecase\User;


use App\Application\Usecase\User\Register\UserRegisterCommand;
use App\Application\Usecase\User\Register\UserRegisterResult;
use App\Domain\Service\UserService;
use App\Domain\User\DuplicateEmailException;
use App\Domain\User\DuplicateUsernameException;
use App\Domain\User\UserFactoryInterface;
use App\Domain\User\Username;
use App\Domain\User\UserRepository;
use Firebase\JWT\JWT;
use LogicException;

class UserApplicationService
{
    /**
     * @var UserFactoryInterface
     */
    private UserFactoryInterface $factory;
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * UserApplicationService constructor.
     *
     * @param UserFactoryInterface $factory
     * @param UserRepository       $userRepository
     * @param UserService          $userService
     */
    public function __construct(UserFactoryInterface $factory, UserRepository $userRepository, UserService $userService)
    {
        $this->factory        = $factory;
        $this->userRepository = $userRepository;
        $this->userService    = $userService;
    }

    /**
     * @param UserRegisterCommand $command
     * @return UserRegisterResult
     * @throws DuplicateEmailException
     * @throws DuplicateUsernameException
     */
    public function register(UserRegisterCommand $command): UserRegisterResult
    {
        $username  = new Username($command->getUsername());
        $user      = $this->factory->create($username, $command->getName(), $command->getEmail(), $command->getPassword());
        $foundUser = $this->userRepository->findByUsernameOrEmail($user);
        if ($foundUser !== null) {
            if ($user->getEmail() === $foundUser->getEmail()) {
                throw new DuplicateEmailException("すでにメールアドレスは使用されています");
            } elseif ($user->getUsername()->getValue() === $foundUser->getUsername()->getValue()) {
                throw new DuplicateUsernameException("すでにユーザ名は使用されています");
            } else {
                throw new LogicException();
            }
        }
        $this->userRepository->save($user);
        return new UserRegisterResult(JWT::encode(['id' => $user->getId()], $_ENV['JWT_KEY']));
    }
}