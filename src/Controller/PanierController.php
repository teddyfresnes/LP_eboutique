<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\VoyageRepository;
use App\Repository\CategorieRepository;
use App\Entity\Voyage;
use App\Entity\Categorie;


class PanierController extends AbstractController
{
    #[Route('/panier', name: 'panier')]
    public function index(Request $request, VoyageRepository $voyageRepository, CategorieRepository $categorieRepository, EntityManagerInterface $entityManager, LoggerInterface $logger): Response
    {
        $session = $request->getSession();
        $cart = $session->get('cart', []);

        $logger->info('POST Data:', ['post' => $request->request->all()]);
        $logger->info('Session:', ['session' => print_r($session->all(), true)]);
        //$session->remove('cart'); $session->set('cart', []); // reset le panier (dev)

        if ($request->isMethod('POST')) {
            $voyageId = $request->request->get('voyage_id');
            $action = $request->request->get('action');

            if ($action === 'decrement') {
                if (array_key_exists($voyageId, $cart)) {
                    $cart[$voyageId]--;
                    if ($cart[$voyageId] <= 0) {
                        unset($cart[$voyageId]);
                    }
                }
            }
            else {
                if (array_key_exists($voyageId, $cart)) {
                    $cart[$voyageId]++; 
                } else {
                    $cart[$voyageId] = 1;
                }
            }


            $session->set('cart', $cart);
            return $this->redirectToRoute('panier'); //evite doublon
        }

        $voyages = [];
        foreach ($cart as $voyageId => $quantity) {
            $voyage = $entityManager->getRepository(Voyage::class)->find($voyageId);

            if ($voyage) {
                $voyages[] = [
                    'voyage' => $voyage,
                    'quantity' => $quantity,
                ];
            }
        }

        return $this->render('panier/index.html.twig', [
            'voyages' => $voyages,
        ]);
    }
}
