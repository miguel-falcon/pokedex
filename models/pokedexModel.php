<?php
class PokedexModel {
    private $name_pokemon;

    // Setter for $name_pokemon
    public function setNamePokemon($name_pokemon) {
        $this->name_pokemon = $name_pokemon;
    }

    // Getter for $name_pokemon
    public function getNamePokemon() {
        return $this->name_pokemon;
    }
}
?>