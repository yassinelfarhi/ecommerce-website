<?php

namespace App\Controller\BackEnd;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class BackEndController extends AbstractController
{
    #[Route('/dashboard', name: 'back_dashboard')]
    public function index(): Response
    {
        return $this->render('back_end/dashboard/dashboard.html.twig');
    }
}
