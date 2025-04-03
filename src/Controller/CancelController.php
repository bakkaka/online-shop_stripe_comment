<?php
// src/Controller/CancelController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CancelController extends AbstractController
{
    #[Route('/cancel', name: 'payment_cancel')]
    public function index(): Response
    {
        return $this->render('payment/cancel.html.twig');
    }
}
