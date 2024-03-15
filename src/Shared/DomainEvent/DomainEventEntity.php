<?php

declare(strict_types=1);

namespace Source\Shared\DomainEvent;


interface DomainEventEntity
{
    public function pushDomainEvent(DomainEvent $domainEvent): void;

    public function pullDomainEvents(): array;
}