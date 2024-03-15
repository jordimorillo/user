<?php

declare(strict_types = 1);

namespace Source\User\Domain\ValueObject;

interface StringValueObject
{
    public function toString(): string;

    public function __toString(): string;
}