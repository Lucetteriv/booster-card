<?php 

namespace App\Class;
use PDO;
use Exception;
session_start();
require_once __DIR__ . '/../Database/Database.php';

use App\Database\Database;

class Collection{

    private PDO $db;

    public function __construct(){
        $this->db = Database::getConnection();
    }

    public function Store($booster): void{

         $sql = "INSERT INTO collection (pokemon_id, pokemon_name, pokemon_image, pokemon_category, pokemon_hp, pokemon_types, pokemon_atk, pokemon_def, pokemon_speAtk, pokemon_speDef, pokemon_vit) VALUES (:pokemon_id, :pokemon_name, :pokemon_image, :pokemon_category, :pokemon_hp, :pokemon_types, :pokemon_atk, :pokemon_def, :pokemon_speAtk, :pokemon_speDef, :pokemon_vit)";
         foreach($booster as $card){
             $pokemon_id = $card['pokedex_id'];
             $pokemon_name = $card['name']['fr'];
             $pokemon_image = $card['sprites']['regular'];
             $pokemon_category = $card['category'];
             $pokemon_hp = $card['stats']['hp'];
             $pokemon_types = json_encode($card['types']);
             $pokemon_atk = $card['stats']['atk'];
             $pokemon_def = $card['stats']['def'];
             $pokemon_speAtk = $card['stats']['spe_atk'];
             $pokemon_speDef = $card['stats']['spe_def'];
             $pokemon_vit = $card['stats']['vit'];


            // Appel de la méthode pour enregistrer le Pokémon
            $this->savePokemon($sql, $pokemon_id, $pokemon_name, $pokemon_image, $pokemon_category, 
                $pokemon_hp, $pokemon_types, 
                $pokemon_atk, 
                $pokemon_def, 
                $pokemon_speAtk, 
                $pokemon_speDef, 
                $pokemon_vit);
            }
    }

    private function savePokemon(string $sql, int $pokemon_id, string $pokemon_name, string $pokemon_image, string $pokemon_category, 
        int $pokemon_hp, string $pokemon_types, 
        int $pokemon_atk, 
        int $pokemon_def, 
        int $pokemon_speAtk, 
        int $pokemon_speDef, 
        int $pokemon_vit): void
    {
        
        try {
    if (isset($_SESSION['user'])) {
        $user_id = $_SESSION['user']['id'];
        

        // Requête préparée avec $this->db
        $stmt = $this->db->prepare("
            SELECT *
            FROM collection
            INNER JOIN user_collection ON collection.id = user_collection.fk_collection_id
            WHERE user_collection.fk_user_id = :user_id
        ");
        $stmt->execute(['user_id' => $user_id]);
        $collections = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Affichage (debug)
        foreach ($collections as $collection) {
            echo "Collection : " . htmlspecialchars($collection['title']) . "<br>";
        }

    } else {
        throw new Exception("Utilisateur non connecté.");
    }

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
    // Redirection ou autre gestion possible ici
}

        var_dump($pokemon_id, $pokemon_name, $pokemon_image, $pokemon_category, 
            $pokemon_hp, $pokemon_types, 
            $pokemon_atk, 
            $pokemon_def, 
            $pokemon_speAtk, 
            $pokemon_speDef, 
            $pokemon_vit);
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':pokemon_id', $pokemon_id, PDO::PARAM_INT); 
            $stmt->bindParam(':pokemon_name', $pokemon_name, PDO::PARAM_STR); 
            $stmt->bindParam(':pokemon_image', $pokemon_image, PDO::PARAM_STR); 
            $stmt->bindParam(':pokemon_category', $pokemon_category, PDO::PARAM_STR); 
            $stmt->bindParam(':pokemon_hp', $pokemon_hp, PDO::PARAM_INT); 
            $stmt->bindParam(':pokemon_types', $pokemon_types, PDO::PARAM_STR); 
            $stmt->bindParam(':pokemon_atk', $pokemon_atk, PDO::PARAM_INT); 
            $stmt->bindParam(':pokemon_def', $pokemon_def, PDO::PARAM_INT); 
            $stmt->bindParam(':pokemon_speAtk', $pokemon_speAtk, PDO::PARAM_INT); 
            $stmt->bindParam(':pokemon_speDef', $pokemon_speDef, PDO::PARAM_INT); 
            $stmt->bindParam(':pokemon_vit', $pokemon_vit, PDO::PARAM_INT); 

            if (!$stmt->execute()) {
                throw new Exception("Erreur lors de l'enregistrement du Pokémon : " . implode(", ",$stmt->errorInfo()));
            }
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}