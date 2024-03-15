<?php

declare(strict_types=1);

namespace Source\Shared\StringValueObject;

interface StringValueObject
{
    public function __toString(): string;

    public function toString(): string;
}