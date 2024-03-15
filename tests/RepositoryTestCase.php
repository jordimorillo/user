<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Source\Shared\MysqlClient\MysqlClient;

class RepositoryTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $provider = $this->providedData();
        if(strpos(get_class($provider[0]), 'InMySQL') > 0) {
            MysqlClient::resetDatabase($_ENV['MYSQL_DB'], false);
            MysqlClient::connect($_ENV['MYSQL_HOST'], $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASS'], $_ENV['MYSQL_PORT']);
            MysqlClient::selectDatabase($_ENV['MYSQL_DB']);
        }
    }
}