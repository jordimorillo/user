<?php

declare(strict_types = 1);

namespace Tests\User\Infrastructure\Repository;

use Source\Shared\MysqlClient\MysqlClient;
use Source\User\Domain\ValueObject\UserRepositoryInterface;
use Source\User\Infrastructure\Repository\UserRepositoryInMemory;
use Source\User\Infrastructure\Repository\UserRepositoryInMysql;
use Tests\Fixtures\Users;
use Tests\RepositoryTestCase;

class UserRepositoryTest extends RepositoryTestCase {
    public function dataProvider(): array {
        return [
            'In Memory' => [new UserRepositoryInMemory()],
            'In MySQL' => [new UserRepositoryInMysql(MysqlClient::getConnection())],
        ];
    }

    /** @dataProvider dataProvider() */
    public function testCanInstantiate(UserRepositoryInterface $userRepository): void {
        self::assertInstanceOf(UserRepositoryInterface::class, $userRepository);
    }

    /** @dataProvider dataProvider() */
    public function testCanSave(UserRepositoryInterface $userRepository): void {
        $user = Users::aUser();
        $userRepository->save($user);
        self::assertTrue(true);
    }
}