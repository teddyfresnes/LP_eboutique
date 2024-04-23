<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Commande;

class UtilisateurController extends AbstractController
{

    #[Route('/utilisateur', name: 'app_utilisateur')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = $request->getSession();
        $userId = $session->get('user_id');

        if ($userId === null) {
            return $this->redirectToRoute('connexion');
        }

        $user = $entityManager->getRepository(User::class)->find($userId);
        $commandes = $entityManager->getRepository(Commande::class)->findBy(['user' => $user], ['dateCommande' => 'DESC']); // tt les commandes

        if ($request->isMethod('POST')) {
            $nom = $request->request->get('nom');
            $adresseLivraison = $request->request->get('adresse_livraison');

            $user->setNom($nom);
            $user->setAdresseLivraison($adresseLivraison);

            $entityManager->persist($user);
            $entityManager->flush();

            $session->set('user_name', $user->getNom());
            $session->set('user_delivery', $user->getAdresseLivraison());
        }

        return $this->render('utilisateur/index.html.twig', [
            'user' => $user,
            'commandes' => $commandes,
        ]);
    }

    #[Route('/inscription', name: 'inscription')]
    public function inscription(Request $request, EntityManagerInterface $entityManager): Response
    {
        // check si l'user est connecte pour le renvoyer vers la page d'acceuil
        if ($request->getSession()->has('user_id')) {
            return $this->redirectToRoute('accueil');
        }

        // Check l'user est entrain de s'inscrire
        if ($request->isMethod('POST'))
        {
            // creation user avec les infos recu
            $user = new User();
            $user->setNom($request->request->get('nom'));
            $user->setEmail($request->request->get('email'));
            $user->setAdresseLivraison($request->request->get('adresse_livraison'));
            $user->setDateCreation(new \DateTime());
        
            // hashage du mot de passe en bcrypt par defaut
            $password = $request->request->get('password');
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $user->setPassword($hashedPassword);
        
            // save user dans la db
            $entityManager->persist($user); //load user
            $entityManager->flush(); //empty&send to db

            // session start
            $request->getSession()->set('user_id', $user->getId());
            $request->getSession()->set('user_email', $user->getEmail());
            $request->getSession()->set('user_name', $user->getNom());
            $request->getSession()->set('user_delivery', $user->getAdresseLivraison());
            $request->getSession()->set('user_creation', $user->getDateCreation());

            return $this->redirectToRoute('accueil');
        }

        return $this->render('utilisateur/inscription.html.twig');
    }

    #[Route('/connexion', name: 'connexion')]
    public function connexion(Request $request, EntityManagerInterface $entityManager): Response
    {
        // check si l'user est connecte pour le renvoyer vers la page d'acceuil
        if ($request->getSession()->has('user_id')) {
            return $this->redirectToRoute('accueil');
        }

        // recuperation info si l'user se connecte
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            // get user with mail
            $userRepository = $entityManager->getRepository(User::class);
            $user = $userRepository->findOneBy(['email' => $email]);

            // verifie si user exist, et check le mdp
            if ($user && password_verify($password, $user->getPassword()))
            {
                $request->getSession()->set('user_id', $user->getId());
                $request->getSession()->set('user_email', $user->getEmail());
                $request->getSession()->set('user_name', $user->getNom());
                $request->getSession()->set('user_delivery', $user->getAdresseLivraison());
                $request->getSession()->set('user_creation', $user->getDateCreation());
                return $this->redirectToRoute('accueil');
            }
            else {
                echo '<script>alert("Identifiant ou mot de passe incorrect.");</script>'; 
            }
        }

        return $this->render('utilisateur/connexion.html.twig');
    }


    #[Route('/deconnexion', name: 'deconnexion')]
    public function deconnexion(Request $request): Response
    {
        $request->getSession()->remove('user_id');
        return $this->redirectToRoute('accueil');
    }
}
