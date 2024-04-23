<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Categorie;
use App\Entity\Voyage;
use App\Repository\VoyageRepository;
use App\Repository\CategorieRepository;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    #[Route('/accueil', name: 'app_accueil_specific')]

    public function index(Request $request, EntityManagerInterface $entityManager, VoyageRepository $voyageRepository, CategorieRepository $categorieRepository): Response
    {
        $selectedCategory = null;
        if ($request->isMethod('POST')) {
            $categoryId = $request->request->get('category_id');
            $selectedCategory = $categorieRepository->find($categoryId);
        }

        $categories = $categorieRepository->findAll();
        $voyages = $voyageRepository->findAll();

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'categories' => $categories,
            'voyages' => $voyages,
            'selectedCategory' => $selectedCategory,
        ]);
    }
}
