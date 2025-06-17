`
<?php

$basePath = dirname(__DIR__);
$databasePath = $basePath . '/database/db.sqlite';

if (!file_exists($databasePath)) {
    echo "La base de données n'existe pas.\n";
    exit;
}

$db = new PDO("sqlite:" . $databasePath);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "🔄 Suppression des tables existantes...\n";

// Récupère toutes les tables (sauf les internes de SQLite)
$tables = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'")
             ->fetchAll(PDO::FETCH_COLUMN);

foreach ($tables as $table) {
    $db->exec("DROP TABLE IF EXISTS \"$table\"");
    echo "❌ Table supprimée : $table\n";
}

echo "✅ Base nettoyée.\n";

// Appelle le script migrate.php
echo "🚀 Lancement des migrations...\n";
require __DIR__ . '/migrate.php';