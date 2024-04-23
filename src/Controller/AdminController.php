<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use App\Repository\VoyageRepository;
use App\Repository\CategorieRepository;
use App\Entity\Voyage;
use App\Entity\Categorie;
use Psr\Log\LoggerInterface;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(Request $request, UserRepository $userRepository, VoyageRepository $voyageRepository, CategorieRepository $categorieRepository, EntityManagerInterface $entityManager, LoggerInterface $logger): Response
    {
        // check si l'admin effectue une action
        $logger->info("Contenu du POST dans la gestion admin: " . json_encode($_POST));
        if ($request->isMethod('POST')) {
            // userId pour suppression user
            $userId = $request->request->get('userId');
            if ($userId) {
                $user = $userRepository->find($userId);

                if ($user) {
                    $logger->info("Suppression de l'utilisateur avec ID : {$userId}");
                    // suppression user
                    $entityManager->remove($user);
                    $entityManager->flush();
                }
            }


            // voyageId pour suppression voyages
            $voyageId = $request->request->get('voyageId');
            if ($voyageId) {
                $voyage = $voyageRepository->find($voyageId);

                if ($voyage) {
                    $logger->info("Suppression du voyage avec ID : {$voyageId}");
                    $entityManager->remove($voyage);
                    $entityManager->flush();
                }
            }

            // ajout d'un nouveau voyage
            $nom = $request->request->get('voyage_nom');
            $prix = $request->request->get('prix');
            $description = $request->request->get('description');
            $imageUrl = $request->request->get('imageUrl');
            $categoryId = $request->request->get('category_id');

            if ($nom && $prix && $description && $imageUrl) {
                $category = $entityManager->getRepository(Categorie::class)->find($categoryId);
                $voyage = new Voyage();
                $voyage->setNom($nom);
                $voyage->setPrix($prix);
                $voyage->setDescription($description);
                $voyage->setImage($imageUrl);
                $voyage->setCategorie($category);

                $entityManager->persist($voyage);
                $entityManager->flush();
            }

            // ajout category
            if ($request->request->has('category_name')) {
                $categoryName = $request->request->get('category_name');

                $category = new Categorie();
                $category->setNom($categoryName);

                $entityManager->persist($category);
                $entityManager->flush();
            }

            // supprimer categorie
            if ($request->request->has('categoryId')) {
                $categoryId = $request->request->get('categoryId');
                $category = $entityManager->getRepository(Categorie::class)->find($categoryId);

                if ($category) {
                    $entityManager->remove($category);
                    $entityManager->flush();
                }
            }
        }

        //reset POST
        $_POST = null;

        // si pas d'action, affichage normal
        $users = $userRepository->findAll();
        $voyages = $voyageRepository->findAll();
        $categories = $categorieRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
            'voyages' => $voyages,
            'categories' => $categories,
        ]);
    }
}
