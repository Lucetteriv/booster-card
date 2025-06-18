<?php
// database/migration/20250617_create_user_collections_table.php

return function (PDO $db) {
    $db->exec(
        "
        CREATE TABLE IF NOT EXISTS user_collections (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            card_id INTEGER NOT NULL,
            quantity INTEGER DEFAULT 1,
            obtained_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (card_id) REFERENCES cards(id) ON DELETE CASCADE,
            UNIQUE(user_id, card_id)
        );
        "
    );
};