<?php

declare(strict_types=1);

namespace Source\User\Application\Command;

use Exception;
use Source\User\Domain\ValueObject\Email;
use Source\User\Domain\ValueObject\Password;
use Source\User\Domain\ValueObject\UserRepositoryInterface;

class CheckPasswordCommandHandler
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CheckPasswordCommand $command): bool
    {
        return $this->repository->exists(
            new Email($command->getEmail()),
            new Password($command->getPassword())
        );
    }
}
