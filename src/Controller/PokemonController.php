<?php

namespace App\Controller;

use App\Entity\Pokemon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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

    #[Route("/insert/pokemon")]
    public function insertPokemon(EntityManagerInterface $doctrine)
    {
        $pokemon = new Pokemon();
        $pokemon->setName("pikachu");
        $pokemon->setDescription("Cuando se enfada, este Pokémon descarga la energía que almacena en el interior de las bolsas de las mejillas.");
        $pokemon->setImage("https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/025.png");
        $pokemon->setCode(25);

        $pokemon2 = new Pokemon();
        $pokemon2->setName("Drakloak");
        $pokemon2->setDescription("Vuela a 200 km/h. Si pierde un combate, el Dreepy que lo acompaña no dudará un segundo en emprender la huida.");
        $pokemon2->setImage("https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/886.png");
        $pokemon2->setCode(886);

        $pokemon3 = new Pokemon();
        $pokemon3->setName("0001");
        $pokemon3->setDescription("Tras nacer, crece alimentándose durante un tiempo de los nutrientes que contiene el bulbo de su lomo.");
        $pokemon3->setImage("https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/001.png");
        $pokemon3->setCode(1);

        $doctrine->persist($pokemon);
        $doctrine->persist($pokemon2);
        $doctrine->persist($pokemon3);

        $doctrine->flush();

        return new Response("Pokemons insertados correctamente.");
    }
}
