<?php
namespace App\Controller\Admin;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DashboardController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'app_admin_dashboard')]
    public function index(ProduitRepository $produitRepository): Response
    {
        // Récupérer tous les produits
        $produits = $produitRepository->findAll();

        return $this->render('admin/dashboard/index.html.twig', [
            'produits' => $produits, // Liste des produits
            'controller_name' => 'Admin/DashboardController',
        ]);
    }

    #[Route('/admin/produit/new', name: 'app_admin_produit_new', methods: ['GET', 'POST'])]
    public function newProduit(): Response
    {
        // Redirige vers le formulaire d'ajout de produit
        return $this->redirectToRoute('app_produit_new');
    }
}
