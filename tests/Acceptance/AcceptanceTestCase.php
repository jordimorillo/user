<?php

declare(strict_types = 1);

namespace Tests\Acceptance;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Source\Shared\MysqlClient\MysqlClient;

class AcceptanceTestCase extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();
        self::setupDatabase();
        MysqlClient::resetDatabase($_ENV['MYSQL_DB']);
        $this->client = new Client([
            'base_uri' => 'http://localhost'
        ]);
    }

    /**
     * @return void
     */
    public static function setupDatabase(): void
    {
        MysqlClient::connect($_ENV['MYSQL_HOST'], $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASS'], (int)$_ENV['MYSQL_PORT']);
        MysqlClient::selectDatabase($_ENV['MYSQL_DB']);
    }
}