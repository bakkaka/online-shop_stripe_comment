<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\CommandeProduit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class CartManager
{
    public function __construct(
        private EntityManagerInterface $em,
        private Security $security // ✅ Vérifier que ce type correspond bien à l'import
    ) {}

    public function getCurrentCart(): Cart
    {
        $user = $this->security->getUser();
        $cart = $user->getCart();

        if (!$cart) {
            $cart = new Cart();
            $cart->setUser($user);
            $this->em->persist($cart);
            $this->em->flush();
        }

        return $cart;
    }

    public function addToCart(Produit $produit, int $quantity = 1): void
    {
        $cart = $this->getCurrentCart();
        
        // Vérifie si le produit est déjà dans le panier
        foreach ($cart->getItems() as $item) {
            if ($item->getProduit()->getId() === $produit->getId()) {
                $item->setQuantity($item->getQuantity() + $quantity);
                $this->em->flush();
                return;
            }
        }

        // Crée un nouvel item
        $item = new CartItem();
        $item->setCart($cart);
        $item->setProduit($produit);
        $item->setQuantity($quantity);
        
        $cart->addItem($item);
        $this->em->persist($item);
        $this->em->flush();
    }

    public function removeFromCart(CartItem $item): void
    {
        $cart = $this->getCurrentCart();
        $cart->removeItem($item);
        $this->em->remove($item);
        $this->em->flush();
    }

    public function createOrderFromCart(): Commande
    {
        $cart = $this->getCurrentCart();
        $commande = new Commande();
        $commande->setUser($cart->getUser());
        $commande->setTotal($cart->getTotal());

        foreach ($cart->getItems() as $item) {
            $commandeProduit = new CommandeProduit();
            $commandeProduit->setCommande($commande);
            $commandeProduit->setProduit($item->getProduit());
            $commandeProduit->setQuantity($item->getQuantity());
            $commandeProduit->setPrixUnitaire($item->getProduit()->getPrix());
            
            $commande->addCommandeProduit($commandeProduit);
            $this->em->persist($commandeProduit);
        }

        $this->em->persist($commande);
        $this->em->flush();

        // Vider le panier
        foreach ($cart->getItems() as $item) {
            $this->em->remove($item);
        }
        $this->em->flush();

        return $commande;
    }
}
