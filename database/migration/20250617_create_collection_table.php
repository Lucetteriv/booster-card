<?php

return function (PDO $db){
   $db->exec(
    "
    CREATE TABLE IF NOT EXISTS collection (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        pokemon_id INTEGER NOT NULL,
        pokemon_name VARCHAR(255) NOT NULL, 
        pokemon_image VARCHAR(255) NOT NULL, 
        pokemon_category VARCHAR(255) NOT NULL,
        pokemon_hp INTEGER NOT NULL,
        pokemon_types JSON NOT NULL, 
        pokemon_atk INTEGER NOT NULL, 
        pokemon_def INTEGER NOT NULL,
        pokemon_speAtk INTEGER NOT NULL,
        pokemon_speDef INTEGER NOT NULL,
        pokemon_vit INTEGER NOT NULL);
    "
   );

};