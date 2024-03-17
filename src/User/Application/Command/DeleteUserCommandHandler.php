<?php

declare(strict_types=1);

namespace Source\User\Application\Command;

use Source\User\Domain\ValueObject\UserId;
use Source\User\Domain\ValueObject\UserRepositoryInterface;

class DeleteUserCommandHandler
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(DeleteUserCommand $command): void
    {
        $this->repository->delete(new UserId($command->getUserId()));
    }
}
