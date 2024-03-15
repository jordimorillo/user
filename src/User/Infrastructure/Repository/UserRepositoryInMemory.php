<?php

declare(strict_types=1);

namespace Source\User\Infrastructure\Repository;

use Source\User\Domain\Entity\User;
use Source\User\Domain\ValueObject\UserRepositoryInterface;

class UserRepositoryInMemory implements UserRepositoryInterface {
    private array $users;

    public function __construct(array $users = []) {
        $this->users = $users;
    }

    public function save(User $user): void {
        $this->users[$user->getId()->toString()] = $user;
    }
}