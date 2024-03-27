<?php

libxml_use_internal_errors(true);
$xml = simplexml_load_file('phpunit.xml') or die("Error: Cannot create object");

$dbHost = null;
$dbUser = null;
$dbPass = null;
$dbName = null;

foreach ($xml->php->env as $env) {
    $attributes = $env->attributes();

    if ($attributes['name'] == 'MYSQL_HOST') {
        $dbHost = (string)$attributes['value'];
    }

    if ($attributes['name'] == 'MYSQL_USER') {
        $dbUser = (string)$attributes['value'];
    }

    if ($attributes['name'] == 'MYSQL_PASS') {
        $dbPass = (string)$attributes['value'];
    }

    if ($attributes['name'] == 'MYSQL_DB') {
        $dbName = (string)$attributes['value'];
    }
}

if (!$dbHost || !$dbUser || !$dbPass || !$dbName) {
    die('DB configuration is missing in phpunit.xml');
}

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$sql = file_get_contents(dirname(__FILE__) . '/resources/structure.sql');

/* execute multi query */
if ($mysqli->multi_query($sql)) {
    do {
        /* store first result set */
        if ($result = $mysqli->store_result()) {
            $result->free();
        }
    } while ($mysqli->more_results() && $mysqli->next_result());
}

/* close connection */
$mysqli->close();