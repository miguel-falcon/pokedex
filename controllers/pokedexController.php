<?php
require_once '../models/pokedexModel.php';

class PokedexController {
    private $pokedexModel;
    private $urlAPI = 'https://pokeapi.co/api/v2/pokemon?limit=500';

    public function __construct() {
        $this->pokedexModel = new PokedexModel();
    }

    // Fetch the full list of Pokémon using cURL
    public function getPokedex() {
        $ch = curl_init($this->urlAPI);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Failed to fetch Pokémon list', 'details' => $error]);
            return;
        }

        curl_close($ch);

        // Decode the API response
        $data = json_decode($response, true);
        return $data['results'] ?? []; // Return the list of Pokémon or an empty array
    }

    // Fetch details of a specific Pokémon by name using cURL
    public function getPokemonByName($name) {
        $this->pokedexModel->setNamePokemon($name);
        $name_pokemon = $this->pokedexModel->getNamePokemon();
        $url = 'https://pokeapi.co/api/v2/pokemon/' . $name_pokemon;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Failed to fetch Pokémon details', 'details' => $error]);
            return;
        }

        curl_close($ch);

        // Decode the API response
        $data = json_decode($response, true);
        if (!$data) {
            return ['error' => 'Pokémon not found'];
        }

        return $data; // Return Pokémon details
    }

    // Search Pokémon by name from the full list
    public function searchPokemon($searchTerm) {
        $pokedex = $this->getPokedex();

        if (isset($pokedex['error'])) {
            return $pokedex; // Return error if fetching the list failed
        }

        $filteredPokedex = array_filter($pokedex, function ($pokemon) use ($searchTerm) {
            return strpos(strtolower($pokemon['name']), strtolower($searchTerm)) !== false;
        });

        return array_values($filteredPokedex); // Return filtered Pokémon list
    }
}

// Handle incoming requests
header('Content-Type: application/json');

try {
    $controller = new PokedexController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        $search = strtolower($input['search'] ?? '');

        if (!empty($search)) {
            // Search Pokémon by name
            $filteredPokedex = $controller->searchPokemon($search);
            echo json_encode(['pokedex' => $filteredPokedex]);
        } else {
            // Fetch the full list of Pokémon
            $pokedex = $controller->getPokedex();
            echo json_encode(['pokedex' => $pokedex]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
exit;
?>