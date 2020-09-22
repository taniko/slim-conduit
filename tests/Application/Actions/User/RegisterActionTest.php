<?php


namespace Tests\Application\Actions\User;


use Tests\TestCase;

class RegisterActionTest extends TestCase
{
    public function testSuccessRegister()
    {
        $app      = $this->getAppInstance();

        $request  = $this->createRequest('POST', "/users", [
            'content-type' => 'application/json',
        ])->withParsedBody([
            'username' => 'alice',
            'name'     => 'Alice',
            'email'    => 'alice@example.com',
            'password' => 'password',
        ]);
        $response = $app->handle($request);

        $payload           = json_decode((string)$response->getBody(), true);
        $this->assertIsString($payload['data']['jwt']);
    }

    public function testFailedByEmail()
    {
        $app      = $this->getAppInstance();

        $request  = $this->createRequest('POST', "/users", [
            'content-type' => 'application/json',
        ])->withParsedBody([
            'username' => 'bill1',
            'name'     => 'Bill',
            'email'    => 'bill@example.com',
            'password' => 'password',
        ]);
        $response = $app->handle($request);

        $payload           = json_decode((string)$response->getBody(), true);
        $this->assertIsString($payload['error']['email']);
    }

    public function testFailedByUsername()
    {
        $app      = $this->getAppInstance();

        $request  = $this->createRequest('POST', "/users", [
            'content-type' => 'application/json',
        ])->withParsedBody([
            'username' => 'bill',
            'name'     => 'Bill',
            'email'    => 'bill_1@example.com',
            'password' => 'password',
        ]);
        $response = $app->handle($request);

        $payload           = json_decode((string)$response->getBody(), true);
        $this->assertIsString($payload['error']['username']);
    }
}