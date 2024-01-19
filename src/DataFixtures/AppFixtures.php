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
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setNom($faker->lastName);
        $admin->setPrenom($faker->firstName);
        $admin->setPassword($this->passwordHasher->hashPassword($admin,'admin'));
        $uvendeur = new User();
        $uvendeur->setEmail("vendeur@vendeur.fr");
        $uvendeur->setRoles(["ROLE_VENDEUR"]);
        $uvendeur->setNom($faker->lastName);
        $uvendeur->setPrenom($faker->firstName);
        $uvendeur->setPassword($this->passwordHasher->hashPassword($uvendeur,'vendeur'));
        $uclient = new User();
        $uclient->setEmail("client@client.fr");
        $uclient->setRoles(["ROLE_CLIENT"]);
        $uclient->setNom($faker->lastName);
        $uclient->setPrenom($faker->firstName);
        $uclient->setPassword($this->passwordHasher->hashPassword($uclient,'client'));
        $user = new User();
        $user->setEmail("user@user.fr");
        $user->setPassword($this->passwordHasher->hashPassword($user,'user'));
        $user->setNom($faker->lastName);
        $user->setPrenom($faker->firstName);
        $manager->persist($uvendeur);
        $manager->persist($uclient);
        $manager->persist($user);
        $manager->persist($admin);

        for ($p = 0; $p < 10; $p++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword($this->passwordHasher->hashPassword($user,$user->getEmail()));
            $user->setNom($faker->lastName);
            $user->setPrenom($faker->firstName);
            $user->setRoles(["ROLE_CLIENT"]);
            $manager->persist($user);
        }
        $manager->flush();

        $vendeur = new Vendeur;
        $vendeur->setUser($uvendeur);
        $client = new Client;
        $client->setUser($uclient);
        $manager->persist($vendeur);
        $manager->persist($client);
        $manager->flush();

        

    }
}
