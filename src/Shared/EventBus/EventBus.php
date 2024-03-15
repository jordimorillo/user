<?php

declare(strict_types = 1);

namespace Source\Shared\EventBus;

use DateTime;
use Source\Shared\DomainEvent\DomainEvent;

class EventBus
{
    private EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function dispatch(DomainEvent $domainEvent, string $commandHandlerFQN, DateTime $occurredOn = null): void
    {
        $event = new Event(
            new EventId(),
            $domainEvent->serialize(),
            $commandHandlerFQN,
            $occurredOn ?? new DateTime(),
        );
        $this->eventRepository->store($event);
    }
}