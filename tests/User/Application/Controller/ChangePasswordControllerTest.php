<?php

declare(strict_types = 1);

namespace Tests\User\Application\Controller;

use Source\Shared\MysqlClient\MysqlClient;
use Source\User\Infrastructure\Repository\UserRepositoryInMySQL;
use Tests\Acceptance\AcceptanceTestCase;
use Tests\Fixtures\Users;

class ChangePasswordControllerTest extends AcceptanceTestCase
{
    public function testCanChangeAPassword(): void
    {
        $user = Users::aUser();
        $userRepository = new UserRepositoryInMySQL(MysqlClient::getConnection());
        $userRepository->save($user);
        $response = $this->client->put('/user', [
            'form_params' => [
                'email' => $user->getEmail()->toString(),
                'password' => 'changed-password',
            ],
        ]);
        self::assertEquals(200, $response->getStatusCode());
    }
}