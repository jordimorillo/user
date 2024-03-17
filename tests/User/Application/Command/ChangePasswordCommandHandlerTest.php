<?php

declare(strict_types=1);

namespace Tests\User\Application\Command;

use PHPUnit\Framework\TestCase;
use Source\User\Application\Command\ChangePasswordCommand;
use Source\User\Application\Command\ChangePasswordCommandHandler;
use Source\User\Domain\Entity\User;
use Source\User\Infrastructure\Repository\UserRepositoryInMemory;
use Tests\Fixtures\Users;

class ChangePasswordCommandHandlerTest extends TestCase
{
    private ChangePasswordCommandHandler $commandHandler;
    private UserRepositoryInMemory $userRepository;
    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = Users::aUser();
        $this->userRepository = new UserRepositoryInMemory([
            $this->user->getId()->toString() => $this->user
        ]);
        $this->commandHandler = new ChangePasswordCommandHandler($this->userRepository);
    }

    public function testCanInstantiate(): void
    {
        self::assertInstanceOf(ChangePasswordCommandHandler::class, $this->commandHandler);
    }

    public function testCanChangePassword(): void
    {
        $password = 'a-new-password';
        $command = new ChangePasswordCommand($this->user->getEmail()->toString(), $password);
        $this->commandHandler->execute($command);
        $actual = $this->userRepository->findById($this->user->getId());
        self::assertTrue(password_verify($password, $actual->getPassword()->toString()));
    }
}
