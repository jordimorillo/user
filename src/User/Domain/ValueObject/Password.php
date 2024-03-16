<?php

declare(strict_types = 1);

namespace Source\User\Domain\ValueObject;

class Password implements StringValueObject
{
    private string $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function toString(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->password;
    }
}
