<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'commande', methods: ['POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager, CsrfTokenManagerInterface $csrfTokenManager)
    {
        $session = $request->getSession();

        if (!$session->has('cart') || empty($session->get('cart'))) {
            // si le panier est vide, rediriger vers le panier
            return $this->redirectToRoute('panier');
        }

        $prixTotal = $request->request->get('prix_total');
        $token = $request->request->get('_csrf_token');

        // vérifier le jeton CSRF pour eviter doublon de commande dans la db
        if (!$csrfTokenManager->isTokenValid(new CsrfToken('commande_form', $token))) {
            //throw new \Exception("Jeton CSRF invalide.");
            return $this->render('utilisateur/profil.html.twig');
        }

        $userId = $session->get('user_id');

        if ($userId === null) {
            return $this->render('utilisateur/connexion.html.twig');
            //throw new \Exception("Merci de vous connecter."); 
        }
        $user = $entityManager->getRepository(User::class)->find($userId);

        $commande = new Commande();
        $commande->setUser($user);
        $commande->setDateCommande(new \DateTime());
        $commande->setPrix($prixTotal);

        $entityManager->persist($commande);
        $entityManager->flush();

        $session->remove('cart'); $session->set('cart', []); // on reset le panier

        return $this->render('commande/index.html.twig', [
            'commande' => $commande,
        ]);
    }
}
