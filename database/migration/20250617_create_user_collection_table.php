<?php

return function (PDO $db){
   $db->exec(
    "
    CREATE TABLE IF NOT EXISTS user_collection (
        fk_user_id INTEGER NOT NULL,
        fk_collection_id INTEGER NOT NULL,
        PRIMARY KEY (fk_user_id, fk_collection_id),  
        FOREIGN KEY (fk_user_id) REFERENCES user(id) ON DELETE CASCADE,
        FOREIGN KEY (fk_collection_id) REFERENCES collection(id) ON DELETE CASCADE);
    "
   );

};