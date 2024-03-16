<?php

declare(strict_types = 1);

namespace Tests\User\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Source\User\Domain\Entity\User;
use Source\User\Domain\ValueObject\Password;
use Tests\Fixtures\Users;

class UserTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = Users::aUser();
    }

    public function testCanInstantiate(): void
    {
        self::assertInstanceOf(User::class, $this->user);
    }

    public function testCanHaveAUniqueIdentifier(): void
    {
        self::assertIsString(
            $this->user->getId()->toString()
        );
    }

    public function testCanHaveAnEmail(): void
    {
        self::assertIsString($this->user->getEmail()->toString());
    }

    public function testCanHaveAPassword(): void
    {
        self::assertIsString($this->user->getPassword()->toString());
    }

    public function testCanChangeAPassword(): void
    {
        $password = new Password('changed-password');
        $this->user->changePassword($password);
        self::assertEquals($password, $this->user->getPassword());
    }
}