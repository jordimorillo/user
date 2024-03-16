<?php

declare(strict_types = 1);

namespace Tests\User\Application\Command;

use PHPUnit\Framework\TestCase;
use Source\User\Application\Command\DeleteUserCommand;
use Source\User\Application\Command\DeleteUserCommandHanler;
use Source\User\Infrastructure\Repository\UserRepositoryInMemory;
use Tests\Fixtures\Users;

class DeleteUserCommandHandlerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->user = Users::aUser();
        $this->repository = new UserRepositoryInMemory([
            $this->user->getId()->toString() => $this->user,
        ]);
        $this->commandHandler = new DeleteUserCommandHanler($this->repository);
    }

    public function testCanDeleteAUser(): void
    {
        $command = new DeleteUserCommand($this->user->getId()->toString());
        $this->commandHandler->execute($command);
        self::assertFalse($this->repository->exists($this->user->getEmail(), $this->user->getPassword()));
    }
}
