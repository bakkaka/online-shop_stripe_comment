<?php
// src/DataFixtures/AppFixtures.php

namespace App\DataFixtures;

use App\Entity\Commentaire;
use App\Entity\Produit;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création d'un admin
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->setUsername('admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin, 'admin123')
        );
        $manager->persist($admin);

        // Création d'un utilisateur normal
        $user = new User();
        $user->setEmail('user@example.com');
        $user->setUsername('user1');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, 'user123')
        );
        $manager->persist($user);

        // Création de produits
        $produits = [
            [
                'nom' => 'iPhone 13',
                'description' => 'Smartphone Apple avec écran Super Retina XDR',
                'prix' => 999.99,
                'image' => 'iphone13.jpg'
            ],
            [
                'nom' => 'MacBook Pro',
                'description' => 'Ordinateur portable Apple avec puce M1',
                'prix' => 1299.99,
                'image' => 'macbookpro.jpg'
            ],
            [
                'nom' => 'AirPods Pro',
                'description' => 'Écouteurs sans fil avec réduction active du bruit',
                'prix' => 249.99,
                'image' => 'airpodspro.jpg'
            ]
        ];

        foreach ($produits as $produitData) {
            $produit = new Produit();
            $produit->setNom($produitData['nom']);
            $produit->setDescription($produitData['description']);
            $produit->setPrix($produitData['prix']);
           // $produit->setPays($produitData['pays']);
            $produit->setDisponible($produitData['disponible']);
            $produit->setStock($produitData['stock']);
            $produit->setEtat($produitData['etat']);
            // Note: Pour les images, vous devrez les ajouter manuellement dans public/uploads/images/
            $manager->persist($produit);

            // Création de commentaires pour chaque produit
            $commentaire = new Commentaire();
            $commentaire->setTexte('Super produit! Je recommande.');
            $commentaire->setCreatedAt(new \DateTimeImmutable());
            $commentaire->setProduit($produit);
            $commentaire->setUser($user);
            $manager->persist($commentaire);
        }

        $manager->flush();
    }
}