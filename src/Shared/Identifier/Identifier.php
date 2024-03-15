<?php

declare(strict_types=1);

namespace Source\Shared\Identifier;

use Ramsey\Uuid\Uuid;
use Source\Shared\StringValueObject\StringValueObject;

class Identifier implements StringValueObject
{
    private string $identifier;

    public function __construct(string $identifier = null) {
        if($identifier === null) {
            $uuid = Uuid::uuid4();
            $this->identifier = $uuid->toString();
        } else {
            $this->identifier = $identifier;
        }
    }

    public function __toString(): string
    {
        return $this->identifier;
    }

    public function toString(): string
    {
        return (string)$this;
    }
}