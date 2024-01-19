<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;
use App\Entity\Client;
use App\Entity\Vendeur;
use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Entity\Produit;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {

    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $admin = new User();
        $admin->setEmail("admin@admin.fr");
        $admin->setRoles(["ROLE_VENDEUR"]);
        $admin->setNom($faker->lastName);
        $admin->setPrenom($faker->firstName);
        $admin->setPassword($this->passwordHasher->hashPassword($admin,'admin'));
        $uvendeur = new User();
        $uvendeur->setEmail("vendeur@vendeur.fr");
        $uvendeur->setRoles(["ROLE_VENDEUR"]);
        $uvendeur->setNom($faker->lastName);
        $uvendeur->setPrenom($faker->firstName);
        $uvendeur->setPassword($this->passwordHasher->hashPassword($uvendeur,'vendeur'));
        // $vendeur = new Vendeur;
        // $vendeur->setUser($uvendeur);
        $uclient = new User();
        $uclient->setEmail("client@client.fr");
        $uclient->setRoles(["ROLE_CLIENT"]);
        $uclient->setNom($faker->lastName);
        $uclient->setPrenom($faker->firstName);
        $uclient->setPassword($this->passwordHasher->hashPassword($uclient,'client'));
        // $client = new Client;
        // $client->setUser($uclient);
        $user = new User();
        $user->setEmail("user@user.fr");
        $user->setRoles(["ROLE_CLIENT"]);
        $user->setPassword($this->passwordHasher->hashPassword($user,'user'));
        $user->setNom($faker->lastName);
        $user->setPrenom($faker->firstName);
        $manager->persist($uvendeur);
        $manager->persist($uclient);
        $manager->persist($user);
        $manager->persist($admin);
        // $manager->persist($vendeur);
        // $manager->persist($client);
        $manager->flush();
        
        for ($u = 0; $u < 10; $u++) {
            $user = new User();
            $user->setEmail("test$u@test.fr");
            $user->setPassword($this->passwordHasher->hashPassword($user,$user->getEmail()));
            $user->setNom($faker->lastName);
            $user->setPrenom($faker->firstName);
            $user->setRoles(["ROLE_CLIENT"]);
            $manager->persist($user);
        }
        $manager->flush();

        $manager->flush();

        for ($p = 0; $p < 10; $p++) {
            $product = new Produit();
            $product->setDesignation($faker->company);
            $product->setPrixUnite($faker->randomFloat(2,0,null));
            $product->setQteStock($faker->randomDigit);
            $manager->persist($user);
        };
        $manager->flush();

        for ($c = 0; $c < 10; $c++) {
            $commande = new Commande();
            $commande->setDateCommande($faker->dateTime);
            $manager->persist($commande);
        };
        $manager->flush();

        for ($lc = 0; $lc < 10; $lc++) {
            $ligneCommande = new LigneCommande();
            $ligneCommande->setQteCommandee($faker->randomDigit);

            $product = new Produit();
            $product->setDesignation($faker->company);
            $product->setPrixUnite($faker->randomFloat(2,0,null));
            $product->setQteStock($faker->randomDigit);
            $ligneCommande->setProduit($product);

            $command = new Commande();
            $command->setDateCommande($faker->dateTime);
            $ligneCommande->setCommande($command);
            $manager->persist($ligneCommande);
        };
        $manager->flush();

    }
}
