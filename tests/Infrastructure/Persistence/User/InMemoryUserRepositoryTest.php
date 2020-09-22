<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\Username;
use App\Domain\User\UserNotFoundException;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use Tests\TestCase;

class InMemoryUserRepositoryTest extends TestCase
{

    public function testFindUserOfId()
    {
        $user = new User('1', new Username('bill'), 'Bill', 'bill@example.com', password_hash('password', PASSWORD_ARGON2ID));


        $userRepository = new InMemoryUserRepository([$user]);

        try {
            $this->assertEquals($user, $userRepository->findUserOfId('1'));
        } catch (UserNotFoundException $e) {
            $this->fail('user not found');
        }
    }

    public function testFindUserOfIdThrowsNotFoundException()
    {
        $userRepository = new InMemoryUserRepository([]);
        $this->expectException(UserNotFoundException::class);
        $userRepository->findUserOfId('1');
    }
}
