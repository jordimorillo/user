<?php

declare(strict_types=1);

namespace Tests\User\Application\Command;

use MongoDB\Driver\Command;
use PHPUnit\Framework\TestCase;
use Source\User\Application\Command\CheckPasswordCommand;
use Source\User\Application\Command\CheckPasswordCommandHandler;
use Source\User\Infrastructure\Repository\UserRepositoryInMemory;
use Tests\Fixtures\Users;

class CheckPasswordCommandHandlerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->user = Users::aUser();
        $this->repository = new UserRepositoryInMemory([
            $this->user->getId()->toString() => $this->user,
        ]);
        $this->commandHandler = new CheckPasswordCommandHandler($this->repository);
    }

    public function testCanCheckEmailAndPassword(): void
    {
        $command = new CheckPasswordCommand($this->user->getEmail()->toString(), $this->user->getPassword()->toString());
        $result = $this->commandHandler->execute($command);
        self::assertTrue($result);
    }
}