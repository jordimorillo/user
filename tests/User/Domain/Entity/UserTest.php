<?php

declare(strict_types=1);

namespace Tests\User\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Source\User\Domain\Entity\User;
use Tests\Fixtures\Users;

class UserTest extends TestCase {
    private User $user;

    public function setUp(): void {
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
            $this->user->getId()->toString());
    }

    public function testCanHaveAnEmail(): void
    {
        self::assertIsString($this->user->getEmail()->toString());
    }

    public function testCanHaveAPassword(): void
    {
        self::assertIsString($this->user->getPassword()->toString());
    }
}