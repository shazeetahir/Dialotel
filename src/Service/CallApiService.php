<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;



class CallApiService {

    private $client;
    private $client_id;
    private $client_secret;
    private $httpClient;

    public function __construct(HttpClientInterface $client, HttpClientInterface $httpClient)
    {
        $this->client = $client;

        //client details test
        $this->client_id = "shahzaib7862@gmail.com";
        $this->client_secret = "Ligoref67";
        $this->httpClient = $httpClient;

    }   


    
    public function login(){
        try {
            // Faire une requête POST à l'API pour recuperer le JSON
            $response = $this->client->request(
                'POST',
                'https://techapi.dialotel.dev/api/login',
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'body' => json_encode([
                        'username' => $this->client_id,
                        'password' => $this->client_secret,
                    ]),
                ]
            );
    
            // Récupérer le contenu de la réponse en tant que tableau associatif
            $data = $response->toArray();
            
            
            // Vérifier si la clé "token" est présente dans le tableau
            if (isset($data['token'])) {
                $token = $data['token'];
                // Faites quelque chose avec le token, par exemple le retourner
                return $token;

            } else {
                // Si la clé "token" n'est pas présente dans la réponse, gérer l'erreur
                return new JsonResponse(['error' => 'Token non trouvé dans la réponse.'], 500);
            }

        } catch (\Exception $e) {
            // Gérer les erreurs, par exemple en renvoyant un message d'erreur JSON à l'utilisateur
            return new JsonResponse(['error' => 'Erreur lors de la connexion.'], 500);
        }
        
    }



    // create customers
    public function CreateCustomers($token, $email, $password) :array{
        {
            // dd($token);
            try {
                // Faire une requête POST à l'API pour obtenir des informations sur les clients
                $response = $this->client->request(
                    'POST',
                    'https://techapi.dialotel.dev/api/customers',
                    [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Authorization' => 'Bearer ' . $token,
                        ],
                        'body' => json_encode([
                            // 'email' => $this->client_id,
                            // 'password' => $this->client_secret,
                            'email' => $email,
                            'password' => $password,
                            'name' => 'Toto',
                        ]),
                    ]
                );
                // dd($response);
                // Récupérer le contenu de la réponse en tant que tableau associatif
                $data = $response->toArray();
                return $data;

            } catch (\Exception $e) {
                // Gérer les erreurs, par exemple en renvoyant un message d'erreur à l'utilisateur
                return ['error' => 'Erreur lors de la récupération des informations sur les clients.'];
            }
        }
    }


    
    
    // get customers by id
    public function getCustomersById($token, $id) :array{
        {
            // dd($token);
            try {
                // Faire une requête GET à l'API pour obtenir des informations sur le client avec l'ID spécifié
                $response = $this->httpClient->request(
                    'GET',
                    'https://techapi.dialotel.dev/api/customers/'.$id,
                    [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Authorization' => 'Bearer ' . $token,
                        ]
                    ]
                );

                // Récupérer le contenu de la réponse en tant que tableau associatif
                $data = $response->toArray();
                return $data;

            } catch (\Exception $e) {
                // Gérer les erreurs, par exemple en renvoyant un message d'erreur à l'utilisateur
                return ['error' => 'Erreur lors de la récupération des informations sur le client.'];
            }
        }
    }


    


    
    

    
}
