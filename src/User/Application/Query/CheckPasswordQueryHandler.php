<?php

declare(strict_types=1);

namespace Source\User\Application\Query;

use Source\User\Domain\ValueObject\Email;
use Source\User\Domain\ValueObject\Password;
use Source\User\Domain\ValueObject\UserRepositoryInterface;

class CheckPasswordQueryHandler
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CheckPasswordQuery $query): bool
    {
        return $this->repository->exists(
            new Email($query->getEmail()),
            new Password($query->getPassword())
        );
    }
}
