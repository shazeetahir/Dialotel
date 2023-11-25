<?php

namespace App\Controller;

use App\Entity\Listing;
use App\Entity\Offer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ListingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class ListingController extends AbstractController
{
    #[Route('/listing', name: 'app_listing')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $listings = $entityManager->getRepository(Listing::class)->findAll();
        // dd($listings);

        return $this->render('listing/listings.html.twig', [
            'controller_name' => 'ListingController',
            'listings' => $listings,
        ]);
    }


    #[Route('/create-listing', name: 'create_listing')]
    public function createListing(Request $request, EntityManagerInterface $entityManager): Response
    {
        $listing = new Listing();
        $form = $this->createForm(ListingType::class, $listing);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form->getData());
            $listing->setOwner($this->getUser());
            $entityManager->persist($listing);
            $entityManager->flush();

            // Redirect to a success page or do something else
            return $this->redirectToRoute('app_listing');
        }

        return $this->render('listing/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/handle-response/{listingId}", name="handle_response", methods={"POST"})
     */
    #[Route('/handle-response/{listingId}', name: 'handle_response', methods:"POST")]
    public function handleResponse(Request $request, Listing $listingId, EntityManagerInterface $entityManager): Response
    {
        // Traitement de la réponse du formulaire
        $responseContent = $request->request->get('response_content');
        $offer = new Offer();
        $offer->setUser($this->getUser());
        $offer->setListing($listingId);
        $offer->setComment($responseContent);

        $entityManager->persist($offer);
        $entityManager->flush();

        // Redirigez l'utilisateur vers la page des annonces ou une autre page pertinente
        return $this->redirectToRoute('app_listing');
    }



}
