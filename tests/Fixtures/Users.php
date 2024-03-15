<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Source\User\Domain\Entity\User;
use Source\User\Domain\ValueObject\Email;
use Source\User\Domain\ValueObject\Password;
use Source\User\Domain\ValueObject\UserId;

class Users {

    public static function aUser(): User {
        return new User(
            new UserId(),
            new Email('john@doe.com'),
            new Password('a-password')
        );
    }
}