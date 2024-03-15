<?php

declare(strict_types = 1);

namespace Source\Shared\EventBus;

use DateTime;

class Event
{
    private EventId $eventId;
    private array $domainEvent;
    private string $commandHandlerFQN;
    private DateTime $occurredOn;

    public function __construct(
        EventId $eventId,
        array $domainEvent,
        string $commandHandlerFQN,
        DateTime $occurredOn
    ) {
        $this->eventId = $eventId;
        $this->domainEvent = $domainEvent;
        $this->commandHandlerFQN = $commandHandlerFQN;
        $this->occurredOn = $occurredOn;
    }

    /**
     * @return EventId
     */
    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    /**
     * @return array
     */
    public function getDomainEvent(): array
    {
        return $this->domainEvent;
    }

    /**
     * @return string
     */
    public function getCommandHandlerFQN(): string
    {
        return $this->commandHandlerFQN;
    }

    /**
     * @return DateTime
     */
    public function getOccurredOn(): DateTime
    {
        return $this->occurredOn;
    }
}