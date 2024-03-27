<?php

declare(strict_types = 1);

namespace Source\Shared\MysqlClient;

use Exception;
use mysqli;

class MysqlClient
{
    public static mysqli $mysqli;

    /**
     * @throws Exception
     */
    public static function connect(string $host, string $user, string $pass, int $port = 3306): void
    {
        if (!isset(self::$mysqli)) {
            self::$mysqli = new mysqli($host, $user, $pass, null, $port);

            // Add error handling
            if (self::$mysqli->connect_error) {
                throw new Exception('MySQL Connection Error: ('
                    . self::$mysqli->connect_errno . ') '
                    . self::$mysqli->connect_error);
            }
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
        self::$mysqli->query('DROP DATABASE IF EXISTS `'.$database.'`');
        self::$mysqli->query('CREATE DATABASE `'.$database.'`');
        self::$mysqli->query('USE `'.$database.'`;');
        if (self::$mysqli->multi_query(file_get_contents($structureFile))) {
            while (self::$mysqli->next_result()) {
                if ($result = self::$mysqli->store_result()) {
                    $result->free();
                }
            }
        }
        if ($importFixtures === true) {
            $testDataFile = dirname(__DIR__, 3) . '/resources/test_fixtures.sql';
            if (self::$mysqli->multi_query(file_get_contents($testDataFile))) {
                while (self::$mysqli->next_result()) {
                    if ($result = self::$mysqli->store_result()) {
                        $result->free();
                    }
                }
            }
        }
    }
}
