<?php
// src/Controller/SuccessController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuccessController extends AbstractController
{
    #[Route('/success', name: 'payment_success')]
    public function index(): Response
    {
        return $this->render('payment/success.html.twig');
    }
}
