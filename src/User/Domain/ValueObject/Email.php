<?php

declare(strict_types=1);

namespace Source\User\Domain\ValueObject;

class Email implements StringValueObject {
    private string $email;

    public function __construct(string $email = '') {
        $this->email = $email;
    }

    public function toString(): string {
        return (string)$this;
    }

    public function __toString(): string {
        return $this->email;
    }
}