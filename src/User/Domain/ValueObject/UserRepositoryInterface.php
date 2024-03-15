<?php

declare(strict_types=1);

namespace Source\User\Domain\ValueObject;

use Source\User\Domain\Entity\User;

interface UserRepositoryInterface {

    public function save(User $user): void;
}