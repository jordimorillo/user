<?php

declare(strict_types=1);

namespace Source\Shared\EventBus;


class EventRepositoryInMemory implements EventRepository
{
    private array $events;

    public function store(Event $event): void
    {
        $this->events[$event->getEventId()->toString()] = $event;
    }

    public function findAll(): array
    {
        return $this->events;
    }
}