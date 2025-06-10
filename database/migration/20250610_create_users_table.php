<?php

return function (PDO $db){
   $db->exec(
    "
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE, 
        password VARCHAR(255) NOT NULL, 
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP);
    "
   );

};