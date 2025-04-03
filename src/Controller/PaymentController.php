<?php
namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Produit;

use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaymentController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/checkout/{id}', name: 'checkout')]
    #[IsGranted('ROLE_USER')]
    public function checkout(Request $request, int $id): Response
    {
        $produit = $this->entityManager->getRepository(Produit::class)->find($id);
        if (!$produit) {
            throw $this->createNotFoundException('Produit non trouvé.');
        }
    
        $prix = $produit->getPrix();
        $prixEnCents = intval($prix * 100);
        
        Stripe::setApiKey('sk_test_HOHvYxqJe8bdC5PsRnpO9zVR003e2fLGbp');
    
        // Gestion des images
        $imageUrl = null;
        if (!$produit->getImages()->isEmpty()) {
            $imageUrl = $request->getSchemeAndHttpHost() 
                       . '/uploads/images/'
                       . $produit->getImages()->first()->getUrl();
        }
    
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $produit->getNom(),
                        'images' => $imageUrl ? [$imageUrl] : [],
                    ],
                    'unit_amount' => $prixEnCents,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('payment_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('payment_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
    
        return $this->redirect($session->url, 303);
    }
}
