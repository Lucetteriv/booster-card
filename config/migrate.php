<?php

$databasePath = dirname(__DIR__) . "/database/db.sqlite";
$migrationPath = dirname(__DIR__) . "/database/migration";

if (!file_exists($databasePath)){
    touch($databasePath);
}

$db = new PDO("sqlite:" . $databasePath);

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$migrationFiles = glob($migrationPath . "/*.php");

sort($migrationFiles);

foreach($migrationFiles as $file){
    echo "executing migration : " . basename($file) . PHP_EOL;
    $migration = require $file;
    $migration($db);
}

echo "migration terminee";