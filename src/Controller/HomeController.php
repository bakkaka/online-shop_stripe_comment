<?php
namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Commentaire;
use App\Form\CommentaireType;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProduitRepository $produitRepository, Request $request, CategorieRepository $categorieRepository ): Response
    {
        $queryBuilder = $produitRepository->getPaginatorQueryBuilder();
        
        $pagerfanta = new Pagerfanta(new QueryAdapter($queryBuilder));
        $pagerfanta->setMaxPerPage(8);
        $pagerfanta->setCurrentPage($request->query->getInt('page', 1));

        $categories = $categorieRepository->findAllWithProductCount();
        
        return $this->render('home/index.html.twig', [
            'produits' => $pagerfanta->getCurrentPageResults(),
            'pager' => $pagerfanta,
            'categories' => $categories
        ]);
    }

    #[Route('/produit/{id}', name: 'app_home_produit_show', requirements: ['id' => '\d+'])]
    public function showProduit(
        int $id, 
        ProduitRepository $produitRepository, 
        Request $request, 
        EntityManagerInterface $entityManager
    ): Response {
        $produit = $produitRepository->findWithImages($id);
    
        if (!$produit) {
            throw $this->createNotFoundException('Produit non trouvé');
        }
    
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setProduit($produit);
            $commentaire->setCreatedAt(new \DateTimeImmutable());
    
            if ($this->getUser()) {
                $commentaire->setUser($this->getUser());
            }
    
            $entityManager->persist($commentaire);
            $entityManager->flush();
    
            $this->addFlash('success', 'Commentaire ajouté avec succès !');
            return $this->redirectToRoute('app_home_produit_show', ['id' => $id]);
        }
    
        return $this->render('home/show_produit.html.twig', [
            'produit' => $produit,
            'commentForm' => $form->createView(),
        ]);
    }
}