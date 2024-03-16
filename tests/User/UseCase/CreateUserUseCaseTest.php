<?php

declare(strict_types=1);

namespace Tests\User\UseCase;

use PHPUnit\Framework\TestCase;
use Source\User\Domain\Entity\User;
use Source\User\Domain\UseCase\CreateUserUseCase;
use Source\User\Domain\ValueObject\UserRepositoryInterface;
use Source\User\Infrastructure\Repository\UserRepositoryInMemory;
use Tests\Fixtures\Users;

class CreateUserUseCaseTest extends TestCase
{
    private CreateUserUseCase $useCase;
    private UserRepositoryInterface $userRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepositoryInMemory();
        $this->useCase = new CreateUserUseCase($this->userRepository);
    }

    public function testCanCreateAUser(): void
    {
        $user = Users::aUser();
        $this->useCase->execute($user->getEmail()->toString(), $user->getPassword()->toString());
        $actual = $this->userRepository->findByEmail($user->getEmail());
        self::assertEquals($user->getEmail(), $actual->getEmail());
        self::assertEquals($user->getPassword(), $actual->getPassword());
    }
}
