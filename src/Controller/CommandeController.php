<?php

namespace App\Controller;

use App\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CommandeController extends AbstractController
{
    #[Route('/mes-commandes', name: 'app_commande_index')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        $user = $this->getUser();
        
        // Solution défensive - devrait normalement être couvert par IsGranted
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('commande/index.html.twig', [
            'commandes' => $user->getCommandes() ?? [] // Retourne un tableau vide si null
        ]);
    }

    #[Route('/mes-commandes/{id}', name: 'app_commande_show')]
    #[IsGranted('ROLE_USER')]
    public function show(Commande $commande): Response
    {
        $user = $this->getUser();
        
        // Vérification que la commande appartient bien à l'utilisateur
        if ($commande->getUser() !== $user) {
            throw $this->createAccessDeniedException('Cette commande ne vous appartient pas');
        }

        return $this->render('commande/show.html.twig', [
            'commande' => $commande
        ]);
    }
}