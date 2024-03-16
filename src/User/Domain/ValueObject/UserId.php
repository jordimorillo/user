<?php

declare(strict_types = 1);

namespace Source\User\Domain\ValueObject;

use Ramsey\Uuid\Uuid;

class UserId implements StringValueObject
{
    private string $identifier;

    public function __construct(?string $identifier = null)
    {
        if ($identifier === null) {
            $this->identifier = Uuid::uuid4()->toString();
        } else {
            $this->identifier = $identifier;
        }
    }

    public function toString(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->identifier;
    }
}
