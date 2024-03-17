<?php

declare(strict_types=1);

namespace Tests\User\Application\Controller;

use Source\Shared\MysqlClient\MysqlClient;
use Source\User\Infrastructure\Repository\UserRepositoryInMySQL;
use Tests\Acceptance\AcceptanceTestCase;
use Tests\Fixtures\Users;

class DeleteUserControllerTest extends AcceptanceTestCase
{
    public function testCanDeleteAUser(): void
    {
        $user = Users::aUser();
        $userRepository = new UserRepositoryInMySQL(MysqlClient::getConnection());
        $userRepository->save($user);
        $response = $this->client->delete('/user', [
            'form_params' => [
                'user_id' => $user->getId()->toString(),
            ]
        ]);
        self::assertEquals(200, $response->getStatusCode());
    }
}
