<?php

declare(strict_types = 1);

namespace Tests\Acceptance;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Source\Shared\MysqlClient\MysqlClient;

class AcceptanceTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        MysqlClient::resetDatabase($_ENV('MYSQL_DB'));
        $this->client = new Client();
    }
}