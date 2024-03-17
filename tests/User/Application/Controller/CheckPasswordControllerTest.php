<?php

declare(strict_types=1);

namespace Tests\User\Application\Controller;

use Source\Shared\MysqlClient\MysqlClient;
use Source\User\Infrastructure\Repository\UserRepositoryInMySQL;
use Tests\Acceptance\AcceptanceTestCase;
use Tests\Fixtures\Users;

class CheckPasswordControllerTest extends AcceptanceTestCase
{
    public function testCanValidateAUserPassword(): void
    {
        $user = Users::aUser();
        $userRepository = new UserRepositoryInMySQL(MysqlClient::getConnection());
        $userRepository->save($user);
        $response = $this->client->get('/user/check-password', [
            'form_params' => [
                'email' => $user->getEmail()->toString(),
                'password' => $user->getPassword()->toString(),
            ]
        ]);
        $arrayResponse = json_decode($response->getBody()->getContents(), true);
        self::assertTrue($arrayResponse['is_valid']);
    }
}