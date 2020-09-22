<?php
declare(strict_types=1);

namespace Tests\Domain\User;

use App\Domain\User\User;
use App\Domain\User\Username;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function userProvider()
    {
        return [
            ['1', 'bill', 'Bill', 'Gates'],
            ['2', 'steve', 'Steve', 'Jobs'],
            ['3', 'mark', 'Mark', 'Zuckerberg'],
        ];
    }

    /**
     * @dataProvider userProvider
     * @param string $id
     * @param string $username
     * @param string $name
     * @param string $email
     */
    public function testGetters(string $id, string $username, string $name, string $email)
    {
        $user = new User($id, new Username($username), $name, $email, password_hash('password', PASSWORD_ARGON2ID));

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($username, $user->getUsername()->getValue());
        $this->assertEquals($name, $user->getName());
        $this->assertEquals($email, $user->getEmail());
        $this->assertTrue(password_verify('password', $user->getPassword()));
    }

    /**
     * @dataProvider userProvider
     * @param string $id
     * @param string $username
     * @param string $name
     * @param string $email
     */
    public function testJsonSerialize(string $id, string $username, string $name, string $email)
    {
        $user = new User($id, new Username($username), $name, $email, password_hash('password', PASSWORD_ARGON2ID));


        $expectedPayload = json_encode([
            'username' => $username,
            'name'     => $name,
        ]);

        $this->assertEquals($expectedPayload, json_encode($user));
    }
}
