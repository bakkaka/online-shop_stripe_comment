<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use App\Service\PayPalService;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class PayPalController extends AbstractController
{
    private PayPalService $paypalService;

    public function __construct(PayPalService $paypalService)
    {
        $this->paypalService = $paypalService;
    }

    #[Route('/paypal/pay', name: 'paypal_pay')] /*, methods: ['POST'])]*/
    public function pay(): JsonResponse
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => '10.00'
                ]
            ]],
            'application_context' => [
                'return_url' => $this->generateUrl('paypal_success', [], 0),
                'cancel_url' => $this->generateUrl('paypal_cancel', [], 0),
            ]
        ];

        try {
            $response = $this->paypalService->getClient()->execute($request);
            return $this->json($response->result);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage()], 500);
        }
    }

    #[Route('/paypal/success', name: 'paypal_success')]
    public function success(): JsonResponse
    {
        return $this->json(['message' => 'Paiement réussi !']);
    }

    #[Route('/paypal/cancel', name: 'paypal_cancel')]
    public function cancel(): JsonResponse
    {
        return $this->json(['message' => 'Paiement annulé !']);
    }
    #[Route('/paypal/pay/{id}', name: 'paypal_payment')]
public function payWithPayPal(int $id, ProduitRepository $produitRepository, PayPalService $payPalService): RedirectResponse
{
    $produit = $produitRepository->find($id);

    if (!$produit) {
        throw $this->createNotFoundException("Produit non trouvé !");
    }

    // Créer la commande PayPal
    $order = $payPalService->createOrder($produit->getPrix());

    // Récupérer le lien d'approbation
    foreach ($order->result->links as $link) {
        if ($link->rel === 'approve') {
            return $this->redirect($link->href);
        }
    }

    return $this->redirectToRoute('app_home');
}

}
