<?php

namespace App\Controller;

use App\Service\CartManager;
use App\Entity\Produit;
use App\Entity\CartItem;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart_index')]

    public function index(CartManager $cartManager): Response
    {
        $cart = $cartManager->getCurrentCart();
        
        return $this->render('cart/index.html.twig', [
            'cart' => $cart
        ]);
    }

    #[Route('/add/{id}', name: 'add_to_cart')]
    public function add(Produit $produit, CartManager $cartManager, Request $request): Response
    {
        $quantity = $request->query->getInt('quantity', 1);
        $cartManager->addToCart($produit, $quantity);
        
        $this->addFlash('success', 'Produit ajouté au panier');
        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/remove/{id}', name: 'app_cart_remove')]
    public function remove(CartItem $item, CartManager $cartManager): Response
    {
        $cartManager->removeFromCart($item);
        
        $this->addFlash('success', 'Produit retiré du panier');
        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/checkout', name: 'checkout')]
    public function checkout(CartManager $cartManager): Response
    {
        $commande = $cartManager->createOrderFromCart();
        
        return $this->redirectToRoute('app_commande_show', ['id' => $commande->getId()]);
    }
}

