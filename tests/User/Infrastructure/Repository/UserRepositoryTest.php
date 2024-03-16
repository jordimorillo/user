<?php

declare(strict_types = 1);

namespace Tests\User\Infrastructure\Repository;

use Source\Shared\MysqlClient\MysqlClient;
use Source\User\Domain\ValueObject\UserId;
use Source\User\Domain\ValueObject\UserRepositoryInterface;
use Source\User\Infrastructure\Repository\Exception\UserNotFoundException;
use Source\User\Infrastructure\Repository\UserRepositoryInMemory;
use Source\User\Infrastructure\Repository\UserRepositoryInMySQL;
use Tests\Fixtures\Users;
use Tests\RepositoryTestCase;

class UserRepositoryTest extends RepositoryTestCase
{
    public static function dataProvider(): array
    {
        self::setupDatabase();
        return [
            'In Memory' => [new UserRepositoryInMemory()],
            'In MySQL' => [new UserRepositoryInMySQL(MysqlClient::getConnection())],
        ];
    }

    /** @dataProvider dataProvider() */
    public function testCanInstantiate(UserRepositoryInterface $userRepository): void
    {
        self::assertInstanceOf(UserRepositoryInterface::class, $userRepository);
    }

    /** @dataProvider dataProvider() */
    public function testCanSave(UserRepositoryInterface $userRepository): void
    {
        $user = Users::aUser();
        $userRepository->save($user);
        $actualUser = $userRepository->findById($user->getId());
        self::assertEquals($user, $actualUser);
    }

    /** @dataProvider dataProvider() */
    public function testCanReturnUserNotFoundException(UserRepositoryInterface $userRepository): void
    {
        $this->expectException(UserNotFoundException::class);
        $userRepository->findById(new UserId());
    }

    /** @dataProvider dataProvider() */
    public function testCanFindByEmail(UserRepositoryInterface $userRepository): void
    {
        $user = Users::aUser();
        $userRepository->save($user);
        $actual = $userRepository->findByEmail($user->getEmail());
        self::assertEquals($user, $actual);
    }

    /** @dataProvider dataProvider() */
    public function testCanCheckIfAUserExists(UserRepositoryInterface $userRepository): void
    {
        $user = Users::aUser();
        $userRepository->save($user);
        $exists = $userRepository->exists($user->getEmail(), $user->getPassword());
        self::assertTrue($exists);
    }
}
