<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\Username;
use App\Domain\User\UserNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;

class ViewUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        try {
            $username = new Username($this->resolveArg('username'));
            $user     = $this->userRepository->findByUsername($username);
        } catch (\InvalidArgumentException $exception) {
            return $this->respondWithData([], 400);
        } catch (UserNotFoundException $exception) {
            return $this->respondWithData([], 404);
        }
        return $this->respondWithData($user);
    }
}
