<?php

namespace App\Controller;

use App\Entity\Debilidad;
use App\Entity\Pokemon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PokemonController extends AbstractController
{
    #[Route("/pokemon/{id}", name:"viewPokemon")]
    public function showPokemon(EntityManagerInterface $doctrine, $id)
    {
        $repository = $doctrine->getRepository(Pokemon::class);
       /*  $pokemons = $repository->findOneBy(["name"=>$name]); */
       $pokemon = $repository->find($id);

        return $this->render("pokemons/showPokemon.html.twig", ["pokemon" => $pokemon]);
    }
    #[Route("/pokemons", name:"listaPokemons")]
    public function showPokemons(EntityManagerInterface $doctrine)
    {
        $repository = $doctrine->getRepository(Pokemon::class);
        $pokemons = $repository->findAll();

        return $this->render("pokemons/showPokemons.html.twig", ["pokemons" => $pokemons]);
    }

    #[Route("/insert/pokemon")]
    public function insertPokemon(EntityManagerInterface $doctrine)
    {
        $pokemon = new Pokemon();
        $pokemon -> setName("pikachu");
        $pokemon -> setDescription("Cuando se enfada, este Pokémon descarga la energía que almacena en el interior de las bolsas de las mejillas.");
        $pokemon -> setImage("https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/025.png");
        $pokemon -> setCode(25);
        
        $pokemon2 = new Pokemon();
        $pokemon2 -> setName("drakloak");
        $pokemon2 -> setDescription("Vuela a 200 km/h. Si pierde un combate, el Dreepy que lo acompaña no dudará un segundo en emprender la huida.");
        $pokemon2 -> setImage("https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/886.png");
        $pokemon2 -> setCode(886);
        
        $pokemon3 = new Pokemon();
        $pokemon3 -> setName("bulbasur");
        $pokemon3 -> setDescription("Tras nacer, crece alimentándose durante un tiempo de los nutrientes que contiene el bulbo de su lomo.");
        $pokemon3 -> setImage("https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/001.png");
        $pokemon3 -> setCode(1);   
        
        $debilidad = new Debilidad();
        $debilidad->setName("fuego");
        $debilidad1 = new Debilidad();
        $debilidad1->setName("agua");
        $debilidad2 = new Debilidad();
        $debilidad2->setName("aire");
        $debilidad3 = new Debilidad();
        $debilidad3->setName("tierra");

        $pokemon->addDebilidade($debilidad);
        $pokemon->addDebilidade($debilidad1);
        $pokemon->addDebilidade($debilidad2);
        $pokemon->addDebilidade($debilidad3);

        $pokemon->addDebilidade($debilidad);
        $pokemon2->addDebilidade($debilidad2);
        $pokemon3->addDebilidade($debilidad3);


        $doctrine -> persist($debilidad);
        $doctrine -> persist($debilidad1);
        $doctrine -> persist($debilidad2);
        $doctrine -> persist($debilidad3);

        
        $doctrine -> persist($pokemon);
        $doctrine -> persist($pokemon2);
        $doctrine -> persist($pokemon3);
        $doctrine -> flush();

        return new Response("pokemons insertados correctamente");

    }
}
