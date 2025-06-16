<?php

namespace App\Class;

use Exception;

class Booster{
    private static array $randomIDs = [];
    public static array $booster = [];
    public function __construct(){
        self::$randomIDs;
    }
    private static function createRandomID(): array
    {
        for($i = 1; $i <= 10; $i++){
            array_push(self::$randomIDs, random_int(1, 1025));
        }
        return self::$randomIDs;
    }

    public static function generateBooster(): ?array{
        $ids = self::createRandomID();
        foreach ($ids as $id) {
            $url = "https://tyradex.app/api/v1/pokemon/{$id}";
            
            try {
                $ch = curl_init($url);

                if ($ch === false) {
                    throw new Exception("Erreur lors de l'initialisation de cURL pour l'ID $id.");
                }
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "Accept: application/json"
                ]);

                $response = curl_exec($ch);

                if ($response === false) {
                    throw new Exception("Erreur cURL (ID $id) : " . curl_error($ch));
                }

                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($httpCode !== 200) {
                    throw new Exception("Code HTTP inattendu pour l'ID $id : $httpCode");
                }

                curl_close($ch);

                $data = json_decode($response, true);
                if ($data === null) {
                    throw new Exception("Erreur de décodage JSON pour l'ID $id.");
                }

                array_push(self::$booster, $data);
              

            } catch (Exception $e) {
                echo "Erreur : " . $e->getMessage() . "<br>";
            }
        
        }
          return self::$booster;
        
          
        }
        public static function getPokemonType($booster): string{
           
                foreach($booster['types'] as $type){
                    $pokemonType[] = $type['name'];
                }

            
            return $pokemonType[0];

        }

    
}
?>

