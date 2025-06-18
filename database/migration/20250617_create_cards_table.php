<?php
// database/migration/20250617_create_cards_table.php

return function (PDO $db) {
    $db->exec(
        "
        CREATE TABLE IF NOT EXISTS cards (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            pokemon_id VARCHAR(50) NOT NULL,
            pokemon_category VARCHAR(50) NOT NULL,
            name VARCHAR(100) NOT NULL,
            image_url VARCHAR(500),
            hp INTEGER,
            types TEXT, -- JSON array of types
            attack INTEGER,
            defense INTEGER,
            special_attack INTEGER,
            special_defense INTEGER,
            speed INTEGER,

            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            UNIQUE(pokemon_id)
        );
        "
    );
};