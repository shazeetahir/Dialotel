<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CallApiService;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CallApiService $callApiService): Response
    {
        
        // pour recuperer le token
        $token = $callApiService->login();

        // Si je veux créer un client API
        $customer = $callApiService->CreateCustomers($token, "test3@test.fr", "Password");

        // pour recuperer le client avec son id 
        $getClient = $callApiService->getCustomersById($token, 3);



        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    
}
