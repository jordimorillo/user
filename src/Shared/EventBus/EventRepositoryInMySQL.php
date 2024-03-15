<?php

declare(strict_types = 1);

namespace Source\Shared\EventBus;

use DateTime;
use Exception;
use JsonException;
use mysqli;

class EventRepositoryInMySQL implements EventRepository
{
    private mysqli $mysqli;

    public function __construct(mysqli $mysqli)
    {
        $this->mysqli = $mysqli;
    }

    /**
     * @throws JsonException
     */
    public function store(Event $event): void
    {
        $stmt = $this->mysqli->prepare(
            "INSERT INTO `events` 
            (`eventId`, `domainEvent`, `commandHandlerFQN`, `occurredOn`) 
            VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE `domainEvent`=VALUES(`domainEvent`),
            `commandHandlerFQN`=VALUES(`commandHandlerFQN`), `occurredOn`=VALUES(`occurredOn`);
            "
        );
        $stmt->bind_param('ssss', $eventIdValue, $domainEventValue, $commandHandlerValue, $occurredOnValue);
        $eventIdValue = $event->getEventId()->toString();
        $domainEventValue = json_encode($event->getDomainEvent(), JSON_THROW_ON_ERROR);
        $commandHandlerValue = $event->getCommandHandlerFQN();
        $occurredOnValue = $event->getOccurredOn()->format('Y-m-d H:i:s');
        $stmt->execute();
    }

    /**
     * @throws JsonException
     */
    public function findAll(): array
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM `events`");
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $this->eventFromRow($row);
        }
        return $rows;
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    private function eventFromRow(array $row): Event
    {
        $domainEventParams = json_decode($row['domainEvent'], true, 512, JSON_THROW_ON_ERROR);
        return new Event(
            new EventId($row['eventId']),
            $domainEventParams,
            $row['commandHandlerFQN'],
            new DateTime($row['occurredOn'])
        );
    }
}