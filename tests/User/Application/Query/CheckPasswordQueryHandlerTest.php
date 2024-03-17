<?php

declare(strict_types=1);

namespace Tests\User\Application\Query;

use PHPUnit\Framework\TestCase;
use Source\User\Application\Query\CheckPasswordQuery;
use Source\User\Application\Query\CheckPasswordQueryHandler;
use Source\User\Infrastructure\Repository\UserRepositoryInMemory;
use Tests\Fixtures\Users;

class CheckPasswordQueryHandlerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->user = Users::aUser();
        $this->repository = new UserRepositoryInMemory([
            $this->user->getId()->toString() => $this->user,
        ]);
        $this->commandHandler = new CheckPasswordQueryHandler($this->repository);
    }

    public function testCanCheckEmailAndPassword(): void
    {
        $command = new CheckPasswordQuery(
            $this->user->getEmail()->toString(),
            $this->user->getPassword()->toString()
        );
        $result = $this->commandHandler->execute($command);
        self::assertTrue($result);
    }
}