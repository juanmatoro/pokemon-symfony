<?php

namespace App\Controller;

use App\Entity\Debilidad;
use App\Entity\Pokemon;
use App\Form\PokemonType;
use App\Form\UserType;
use App\Manager\PokemonManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class PokemonController extends AbstractController
{       ///pokemon/{name}
    ///



    #[Route("/pokemon/{id}", name:"viewpokemon")]
    public function showPokemon(EntityManagerInterface $doctrine, $id/* $name */)
    {

        $repository = $doctrine->getRepository(Pokemon::class);
        $pokemon = $repository->find($id);
       // $pokemon = $repository->findOneBy(["name"=>$name]);
        return $this->render("pokemons/showPokemon.html.twig", ["pokemon" => $pokemon]);
    }

    #[Route("/", name:"showpokemons")]
    public function showPokemons(EntityManagerInterface $doctrine)
    {
        $repository = $doctrine->getRepository(Pokemon::class);
        $pokemons = $repository->findAll();
        return $this->render("pokemons/showPokemons.html.twig", ["pokemons" => $pokemons]);
    }

    #[Route("/insert/pokemon", name:"insertpokemon")]
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

        $debilidad = new Debilidad();
        $debilidad->setName("fuego");
        $debilidad2 = new Debilidad();
        $debilidad2->setName("agua");
        $debilidad3 = new Debilidad();
        $debilidad3->setName("tierra");
        $debilidad4 = new Debilidad();
        $debilidad4->setName("aire");

        $pokemon->addDebilidade($debilidad);
        $pokemon->addDebilidade($debilidad2);
        $pokemon->addDebilidade($debilidad3);
        $pokemon->addDebilidade($debilidad4);

        $pokemon2->addDebilidade($debilidad);
        $pokemon3->addDebilidade($debilidad3);
        $pokemon3->addDebilidade($debilidad2);

        $doctrine->persist($debilidad);
        $doctrine->persist($debilidad2);
        $doctrine->persist($debilidad3);
        $doctrine->persist($debilidad4);
        $doctrine->persist($pokemon);
        $doctrine->persist($pokemon2);
        $doctrine->persist($pokemon3);

        $doctrine->flush();

        return new Response("Pokemons insertados correctamente.");
    }

    #[Route("/new/pokemon", name:"newpokemon")]
    public function newPokemon(EntityManagerInterface $doctrine, Request $request, PokemonManager $manager)
    {
        $form = $this->createForm(PokemonType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pokemon = $form->getData();

            $pokemonFile = $form->get('imageFile')->getData();

            if ($pokemonFile){
                $pokemonImage = $manager->uploadImage($pokemonFile, $this->getParameter("kernel.project_dir")."/public/images");

                $pokemon->setImage("/images/$pokemonImage");
            }

            $doctrine->persist($pokemon);
            $doctrine->flush();

            $this->addFlash('éxito', $pokemon->getName().' insertado correctamente');

            return $this->redirectToRoute("showpokemons");

        }

        return $this->render(
            "pokemons/insertPokemon.html.twig",
            ["pokemonform"=>$form]
        );
    }

    #[Route("/new/user", name:"newuser")]
    public function newUser(EntityManagerInterface $doctrine, Request $request, UserPasswordHasherInterface $hasher)
    {
        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $password = $user->getPassword();
            $passwordCifrada = $hasher->hashPassword($user, $password);
            $user->setPassword($passwordCifrada);

            $doctrine->persist($user);
            $doctrine->flush();

            $this->addFlash('éxito', $user->getName().' insertado correctamente');

            return $this->redirectToRoute("showpokemons");

        }

        return $this->render(
            "pokemons/insertPokemon.html.twig",
            ["pokemonform"=>$form]
        );
    }

    #[Route("/new/admin", name:"newadmin")]
    public function newAdmin(EntityManagerInterface $doctrine, Request $request, UserPasswordHasherInterface $hasher)
    {
        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $password = $user->getPassword();
            $passwordCifrada = $hasher->hashPassword($user, $password);
            $user->setPassword($passwordCifrada);
            $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);

            $doctrine->persist($user);
            $doctrine->flush();

            $this->addFlash('éxito', $user->getName().' insertado correctamente');

            return $this->redirectToRoute("showpokemons");

        }

        return $this->render(
            "pokemons/insertPokemon.html.twig",
            ["pokemonform"=>$form]
        );
    }

    #[Route("/edit/pokemon/{id}", name:"editpokemon")]
    public function editPokemon(EntityManagerInterface $doctrine, Request $request, $id)
    {
        $repository = $doctrine->getRepository(Pokemon::class);
        $pokemon = $repository->find($id);
        $form = $this->createForm(PokemonType::class, $pokemon);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pokemon = $form->getData();
            $doctrine->persist($pokemon);
            $doctrine->flush();

            $this->addFlash('éxito', $pokemon->getName().' editado correctamente');

            return $this->redirectToRoute("showpokemons");

        }

        return $this->render(
            "pokemons/insertPokemon.html.twig",
            ["pokemonform"=>$form]
        );
    }

    #[Route("/delete/pokemon/{id}", name:"deletepokemon")]
    public function deletePokemon(EntityManagerInterface $doctrine, $id/* $name */)
    {

        $repository = $doctrine->getRepository(Pokemon::class);
        $pokemon = $repository->find($id);
        $doctrine->remove($pokemon);
        $doctrine->flush();
        $this->addFlash('éxito', $pokemon->getName().' borrado correctamente');
        return $this->redirectToRoute('showpokemons');
    }

}
