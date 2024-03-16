<?php

declare(strict_types = 1);

namespace Source\Shared\MysqlClient;

use mysqli;

class MysqlClient
{
    public static mysqli $mysqli;

    public static function connect(string $host, string $user, string $pass, int $port = 3306): void
    {
        if (!isset(self::$mysqli)) {
            self::$mysqli = new mysqli($host, $user, $pass, null, $port);
        }
    }

    public static function selectDatabase(string $database): void
    {
        self::$mysqli->select_db($database);
    }

    public static function getConnection(): mysqli
    {
        return self::$mysqli;
    }

    public static function resetDatabase(string $database, bool $importFixtures = true): void
    {
        $structureFile = dirname(__DIR__, 3) . '/resources/structure.sql';
        $testDataFile = dirname(__DIR__, 3) . '/resources/test_fixtures.sql';
        $startMysqlQuery = 'mysql -u' . $_ENV['MYSQL_USER'] . ' -p' . $_ENV['MYSQL_PASS'];
        shell_exec($startMysqlQuery . ' -e \'DROP DATABASE IF EXISTS `' . $database . '`\' 2>&1');
        shell_exec($startMysqlQuery . ' --execute=\'CREATE DATABASE `' . $database . '`\' 2>&1');
        shell_exec($startMysqlQuery . ' ' . $database . ' < ' . $structureFile . ' 2>&1');
        if ($importFixtures === true) {
            shell_exec($startMysqlQuery . ' ' . $database . ' < ' . $testDataFile . ' 2>&1');
        }
    }
}
