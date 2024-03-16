<?php

declare(strict_types = 1);

namespace Source\Shared\DomainEvent;

interface DomainEvent
{
    public function serialize(): array;
}
