<?php

declare(strict_types=1);

namespace Tests\User\Application\Controller;

use Source\Shared\MysqlClient\MysqlClient;
use Source\User\Domain\ValueObject\Email;
use Source\User\Infrastructure\Repository\UserRepositoryInMySQL;
use Tests\Acceptance\AcceptanceTestCase;

class CreateAUserControllerTest extends AcceptanceTestCase
{
    public function testCanCreateAUser(): void
    {
        $email = 'john@doe.com';
        $response = $this->client->post('/user', [
            'form_params' => [
                'email' => $email,
                'password' => '1234567',
            ],
        ]);

        self::assertEquals(200, $response->getStatusCode());
    }
}