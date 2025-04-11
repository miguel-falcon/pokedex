function buscarPokedex() {
    const pokedexValue = document.getElementById("pokemonName").value.toLowerCase();
    const divRegistro = document.getElementById("pokeList");

    // Clear previous content
    divRegistro.innerHTML = "<p>Loading...</p>";

    fetch('controllers/pokedexController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ search: pokedexValue }), // Send the search term
    })
        .then(res => {
            if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
            }
            return res.json();
        })
        .then(data => {
            divRegistro.innerHTML = ""; // Clear loading message

            if (data.error) {
                divRegistro.innerHTML = `<p>${data.error}</p>`;
                return;
            }

            const pokedex = data.pokedex || [data]; // Handle full list or single Pokémon

            if (pokedex.length > 0) {
                const ul = document.createElement("ul"); // Create a list container
                ul.className = "list-group"; // Add Bootstrap list group class

                pokedex.forEach(pokemon => {
                    const li = document.createElement("li");
                    li.className = "list-group-item list-group-item-primary"; // Add Bootstrap styling
                    li.textContent = pokemon.name; // Display only the Pokémon name
                    ul.appendChild(li);
                });

                divRegistro.appendChild(ul); // Append the list to the container
            } else {
                divRegistro.innerHTML = "<p>No Pokémon found.</p>";
            }
        })
        .catch(error => {
            console.error('Error:', error);
            divRegistro.innerHTML = "<p>There was an error fetching the data.</p>";
        });
}