<!-- filepath: c:\xampp\htdocs\pokedex\index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Pokedex</h1>
        <p class="text-center">Search for your favorite Pokémon by name or browse the full list!</p>

        <!-- Search Form -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="pokemonName" placeholder="Enter Pokémon Name">
                    <label for="pokemonName">Enter Pokémon Name</label>
                </div>
                <button class="btn btn-primary w-100" onclick="buscarPokedex()">Search</button>
            </div>
        </div>

        <!-- Results Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div id="pokeList" class="d-flex flex-wrap justify-content-center">
                    <!-- Pokémon cards will be dynamically added here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="script/script.js"></script>
</body>
</html>