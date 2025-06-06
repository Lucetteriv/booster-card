<?php

$db = $_ENV['DB_PATH'];

$dsn = "sqlite:$db";

try {
    $pdo = new \PDO($dsn);
    echo 'Connected to the SQLite database successfully!';
} catch (\PDOException $e) {
    echo $e->getMessage();
}