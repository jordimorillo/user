<?php

declare(strict_types = 1);

namespace Tests\User\Application\Command;

use PHPUnit\Framework\TestCase;
use Source\User\Application\Command\CreateUserCommand;
use Source\User\Application\Command\CreateUserCommandHandler;
use Source\User\Domain\ValueObject\UserRepositoryInterface;
use Source\User\Infrastructure\Repository\UserRepositoryInMemory;
use Tests\Fixtures\Users;

class CreateUserCommandHandlerTest extends TestCase
{
    private CreateUserCommandHandler $commandHandler;
    private UserRepositoryInterface $userRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepositoryInMemory();
        $this->commandHandler = new CreateUserCommandHandler($this->userRepository);
    }

    public function testCanCreateAUser(): void
    {
        $user = Users::aUser();
        $command = new CreateUserCommand($user->getEmail()->toString(), $user->getPassword()->toString());
        $this->commandHandler->execute($command);
        $actual = $this->userRepository->findByEmail($user->getEmail());
        self::assertEquals($user->getEmail(), $actual->getEmail());
        self::assertTrue(password_verify($user->getPassword()->toString(), $actual->getPassword()->toString()));
    }
}
