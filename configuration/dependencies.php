<?php

declare(strict_types=1);

namespace Configuration;

use Source\Shared\EventBus\EventRepository;
use Source\Shared\EventBus\EventRepositoryInMySQL;
use Source\Shared\MysqlClient\MysqlClient;

return [
    EventRepository::class => new EventRepositoryInMySQL(MysqlClient::getConnection()),
];
