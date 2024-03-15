<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Source\User\Domain\Entity\User;

class Users {

    public static function aUser(): User {
        return new User();
    }
}