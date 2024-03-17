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

    public function handle(CheckPasswordQuery $query): bool
    {
        try {
            $user = $this->repository->findByEmail(
                new Email($query->getEmail())
            );
            return password_verify($user->getPassword()->toString(), $query->getPassword());
        } catch (\Exception $e) {
            return false;
        }
    }
}
