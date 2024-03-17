<?php

declare(strict_types=1);

namespace Configuration;

use Source\Shared\EventBus\EventRepository;
use Source\Shared\EventBus\EventRepositoryInMySQL;
use Source\Shared\MysqlClient\MysqlClient;
use Source\User\Domain\ValueObject\UserRepositoryInterface;
use Source\User\Infrastructure\Repository\UserRepositoryInMySQL;

return [
    EventRepository::class => new EventRepositoryInMySQL(MysqlClient::getConnection()),
    UserRepositoryInterface::class => new UserRepositoryInMySQL(MysqlClient::getConnection()),
];
