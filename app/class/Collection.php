<<<<<<< HEAD
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
=======
<?php
// app/class/Collection.php

namespace App\Class;

use App\Database\Database;
use PDO;

class Collection
{
    private PDO $db;
    private Card $cardManager;

    public function __construct()
    {
        $this->db = Database::getConnection();
        $this->cardManager = new Card();
    }

    /**
     * Ajoute un booster complet à la collection d'un utilisateur
     */
    public function addBoosterToCollection(int $userId, array $boosterData): array
    {
        $results = [
            'success' => true,
            'message' => '',
            'added_cards' => [],
            'updated_cards' => [],
            'errors' => []
        ];

        try {
            $this->db->beginTransaction();

            foreach ($boosterData as $cardData) {
                // Valider les données de la carte
                if (!$this->validateCardData($cardData)) {
                    $results['errors'][] = "Données invalides pour la carte: " . ($cardData['name'] ?? 'inconnue');
                    continue;
                }

                // Sauvegarder la carte en base
                $cardId = $this->cardManager->saveCard($cardData);

                // Ajouter/mettre à jour dans la collection
                $addResult = $this->addCardToUserCollection($userId, $cardId);

                if ($addResult['action'] === 'added') {
                    $results['added_cards'][] = $cardData['name'];
                } else {
                    $results['updated_cards'][] = $cardData['name'];
                }
            }

            $this->db->commit();

            $totalAdded = count($results['added_cards']);
            $totalUpdated = count($results['updated_cards']);

            if ($totalAdded > 0 && $totalUpdated > 0) {
                $results['message'] = "{$totalAdded} nouvelles cartes ajoutées et {$totalUpdated} cartes mises à jour dans votre collection !";
            } elseif ($totalAdded > 0) {
                $results['message'] = "{$totalAdded} nouvelles cartes ajoutées à votre collection !";
            } elseif ($totalUpdated > 0) {
                $results['message'] = "{$totalUpdated} cartes mises à jour dans votre collection !";
            } else {
                $results['message'] = "Aucune carte n'a pu être ajoutée.";
                $results['success'] = false;
            }

        } catch (\Exception $e) {
            $this->db->rollBack();
            $results['success'] = false;
            $results['message'] = "Erreur lors de l'ajout du booster : " . $e->getMessage();
        }

        return $results;
    }

    /**
     * Ajoute une carte à la collection d'un utilisateur
     */
    private function addCardToUserCollection(int $userId, int $cardId): array
    {
        // Vérifier si l'utilisateur possède déjà cette carte
        $stmt = $this->db->prepare("SELECT quantity FROM user_collections WHERE user_id = ? AND card_id = ?");
        $stmt->execute([$userId, $cardId]);
        $existing = $stmt->fetch();

        if ($existing) {
            // Mettre à jour la quantité
            $newQuantity = $existing['quantity'] + 1;
            $stmt = $this->db->prepare("UPDATE user_collections SET quantity = ? WHERE user_id = ? AND card_id = ?");
            $stmt->execute([$newQuantity, $userId, $cardId]);
            return ['action' => 'updated', 'quantity' => $newQuantity];
        } else {
            // Ajouter nouvelle carte
            $stmt = $this->db->prepare("INSERT INTO user_collections (user_id, card_id, quantity) VALUES (?, ?, 1)");
            $stmt->execute([$userId, $cardId]);
            return ['action' => 'added', 'quantity' => 1];
        }
    }

    /**
     * Récupère la collection complète d'un utilisateur
     */
    public function getUserCollection(int $userId): array
    {
        $stmt = $this->db->prepare(
            "SELECT c.*, uc.quantity, uc.obtained_at
             FROM cards c
             JOIN user_collections uc ON c.id = uc.card_id
             WHERE uc.user_id = ?
             ORDER BY uc.obtained_at DESC"
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Valide les données d'une carte
     */
    private function validateCardData(array $cardData): bool
    {
        return isset($cardData['pokedex_id']) &&
               isset($cardData['name']['fr']) &&
               !empty($cardData['pokedex_id']) &&
               !empty($cardData['name']['fr']);
    }

    /**
     * Compte le nombre total de cartes dans la collection d'un utilisateur
     */
    public function getUserCollectionCount(int $userId): int
    {
        $stmt = $this->db->prepare("SELECT SUM(quantity) as total FROM user_collections WHERE user_id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
>>>>>>> 96b9879 (finito)
    }
}