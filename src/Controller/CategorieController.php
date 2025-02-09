<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ReferenceRepository;
use App\Repository\CategorieRepository;
use App\Entity\Categorie;

class CategorieController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function default(CategorieRepository $categorieRepository): Response
    {
        $firstCategory = $categorieRepository->findFirstCategory();

        return $this->redirectToRoute('app_categorie', ['id' => $firstCategory->getId()]);
    }

    #[Route('/categorie/{id}', name: 'app_categorie')]
    public function categorie(Categorie $categorie, ReferenceRepository $referenceRepository, CategorieRepository $categorieRepository): Response
    {
        /* liste des refs de la catégorie */
        $references = $referenceRepository->findByCategorie($categorie->getId());
        // nom de la sous catégorie
        $sousCategorieNom = $categorie->getNom();
        if($references == null)
        {
            $references = $referenceRepository->findByPrimaryCategorie($categorie->getId());
        }

        /* si c'est une catégorie primaire */
        if($categorie->getDepend() != null)
        {
            $categorie = $categorie->getDepend();
        }
        
        /* liste des catégories existantes */
        $primaryCategories = $categorieRepository->findPrimaryCategories();

        /* affichage des sous-catégories : liste des sous-catégories associées */
        $secondaryCategories = $categorieRepository->findByPrimaryCategorie($categorie->getId());
        
        return $this->render('categorie.html.twig', [
            'primaryCategories' => $primaryCategories,
            'categorieNom' => $categorie->getNom(),
            'sousCategorieNom' => $sousCategorieNom,
            'categorieId' => $categorie->getId(),
            'secondaryCategories' => $secondaryCategories,
            'references' => $references,
        ]);
    }
}
