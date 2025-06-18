<?php
// app/class/Card.php

namespace App\Class;

use App\Database\Database;
use PDO;

class Card
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Sauvegarde une carte en base de données
     */
    public function saveCard(array $cardData): int
    {
        // Vérifier si la carte existe déjà
        $existingCard = $this->getCardByPokemonId($cardData['pokedex_id']);

        if ($existingCard) {
            return $existingCard['id'];
        }

        // Adapter les données TyraDex pour notre structure
        $pokemonName = is_array($cardData['name']) ? $cardData['name']['fr'] : $cardData['name'];
        $imageUrl = $cardData['sprites']['regular'] ?? '';
        $types = json_encode(array_column($cardData['types'] ?? [], 'name'));

        // Préparer les données pour l'insertion
        $stmt = $this->db->prepare(
            "INSERT INTO cards (
                pokemon_id, pokemon_category, name, image_url, hp, types,
                attack, defense, special_attack, special_defense, speed
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->execute([
            $cardData['pokedex_id'],
            $cardData['category'] ?? '',
            $pokemonName,
            $imageUrl,
            $cardData['stats']['hp'] ?? null,
            $types,
            $cardData['stats']['atk'] ?? null,
            $cardData['stats']['def'] ?? null,
            $cardData['stats']['spe_atk'] ?? null,
            $cardData['stats']['spe_def'] ?? null,
            $cardData['stats']['vit'] ?? null
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Récupère une carte par son pokemon_id
     */
    public function getCardByPokemonId(string $pokemonId): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM cards WHERE pokemon_id = ?");
        $stmt->execute([$pokemonId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    /**
     * Récupère une carte par son ID
     */
    public function getCardById(int $cardId): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM cards WHERE id = ?");
        $stmt->execute([$cardId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }
}