<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PokemonController extends AbstractController
{
    #[Route("/pokemon")]
    public function showPokemon()
    {

        $pokemon = [
            "name" => "Pikachu",
            "description" => "Cuando se enfada, este Pokémon descarga la energía que almacena en el interior de las bolsas de las mejillas.",
            "image" => "https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/025.png",
            "code" => "0025"

        ];
        return $this->render("pokemons/showPokemon.html.twig", ["pokemon" => $pokemon]);
    }
    #[Route("/pokemons")]
    public function showPokemons()
    {

        $pokemons = [
            [
                "name" => "Pikachu",
                "description" => "Cuando se enfada, este Pokémon descarga la energía que almacena en el interior de las bolsas de las mejillas.",
                "image" => "https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/025.png",
                "code" => "0025"
            ],
            [
                "name" => "Drakloak",
                "description" => "Vuela a 200 km/h. Si pierde un combate, el Dreepy que lo acompaña no dudará un segundo en emprender la huida.",
                "image" => "https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/886.png",
                "code" => "0886"
            ],
            [
                "name" => "0001",
                "description" => "Tras nacer, crece alimentándose durante un tiempo de los nutrientes que contiene el bulbo de su lomo.",
                "image" => "https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/001.png",
                "code" => "0001"
            ],

        ];
        return $this->render("pokemons/showPokemons.html.twig", ["pokemons" => $pokemons]);
    }
}
