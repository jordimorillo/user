<?php

declare(strict_types=1);

namespace Source\Shared\EventBus;

interface EventRepository
{
    public function store(Event $event): void;

    public function findAll(): array;
}