<?php

declare(strict_types=1);

namespace Source\User\Application\Command;

use Source\Shared\CQRS\CommandBus\Command;

class DeleteUserCommand implements Command
{
    private string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
