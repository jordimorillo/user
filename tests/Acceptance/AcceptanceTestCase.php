<?php

declare(strict_types = 1);

namespace Tests\Acceptance;

use Exception;
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
     * @throws Exception
     */
    public static function setupDatabase(): void
    {
        $required_keys = ['MYSQL_HOST','MYSQL_USER','MYSQL_PASS','MYSQL_PORT','MYSQL_DB'];
        foreach ($required_keys as $key) {
            if (!key_exists($key, $_ENV) || empty($_ENV[$key])) {
                throw new Exception('Error: ' . $key . ' is not set or empty in environment variables.');
            }
        }
        // Your MySQL connection code
        MysqlClient::connect($_ENV['MYSQL_HOST'], $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASS'], (int)$_ENV['MYSQL_PORT']);
        MysqlClient::selectDatabase($_ENV['MYSQL_DB']);
    }
}