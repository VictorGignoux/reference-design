<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReferenceRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AjoutReferenceType;
use App\Entity\Reference;
use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gedmo\Sluggable\Util\Urlizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ReferencesController extends AbstractController
{
    #[Route('/nouveau', name: 'app_nouveau')]
    public function nouveau(ReferenceRepository $referenceRepository, Request $request, EntityManagerInterface $manager): Response
    {
        $reference = new Reference();

        $form = $this->createForm(AjoutReferenceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $reference = $form->getData();
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['imageFile']->getData();

            if($uploadedFile)
            {
                $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                $reference->setImage($newFilename);
            }

            $manager->persist($reference);
            $manager->flush();
            return $this->redirectToRoute('app_default'); // a changer
        }

        return $this->render('form.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/modifier/{id}', name: 'app_modifier')]
    public function modifier(Reference $reference, ReferenceRepository $referenceRepository, Request $request, EntityManagerInterface $manager): Response
    {
        $reference = $referenceRepository->find($reference->getId());

        $form = $this->createForm(AjoutReferenceType::class, $reference);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $reference = $form->getData();
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['imageFile']->getData();

            if($uploadedFile)
            {
                $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                $reference->setImage($newFilename);
            }

            $manager->persist($reference);
            $manager->flush();
            return $this->redirectToRoute('app_reference', ['id' => $reference->getId()]); // a changer
        }

        return $this->render('form.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'app_supprimer')]
    public function supprimer(Reference $reference, ReferenceRepository $referenceRepository, EntityManagerInterface $manager) : Response
    {
        $ref = $referenceRepository->find($reference->getId());
        $categorie = $ref->getCategorie();

        $manager->remove($ref);
        $manager->flush();

        return $this->redirectToRoute('app_categorie', ['id' => $categorie->getId()]);
    }

    #[Route('/delete', name: 'app_delete')]
    public function delete(CategorieRepository $categorieRepository, ReferenceRepository $referenceRepository, Request $request, EntityManagerInterface $manager): Response
    {
        $refs = $referenceRepository->findAll();
        $sousCats = $categorieRepository->findSecondaryCategories();

        foreach ($refs as $ref) 
        {
            $manager->remove($ref);
        }

        foreach ($sousCats as $sousCat) 
        {
            $manager->remove($sousCat);
        }

        $manager->flush();

        return $this->redirectToRoute('app_default');
    }

    #[Route('/reference/{id}', name: 'app_reference')]
    public function reference(Reference $reference, ReferenceRepository $referenceRepository, CategorieRepository $categorieRepository, Request $request): Response
    {
        $categorie = $reference->getCategorie();

        $previousReference = $referenceRepository->findNextReference($reference->getId(), $reference->getCategorie()->getId());
        if($previousReference != null)
        {
            $previousReference = $previousReference->getId();
        }
        else
        {
            $previousReference = -1;
        }

        $nextReference = $referenceRepository->findPreviousReference($reference->getId(), $reference->getCategorie()->getId());
        if($nextReference != null)
        {
            $nextReference = $nextReference->getId();
        }
        else
        {
            $nextReference = -1;
        }

        /* $references = $referenceRepository->findByCategorie($categorie->getId()); */

        /* si c'est une catégorie primaire */
        if($categorie->getDepend() != null)
        {
            $categorie = $categorie->getDepend();
        }

        /* liste des catégories existantes pour le base */
        $primaryCategories = $categorieRepository->findPrimaryCategories();

        /* affichage des sous-catégories : liste des sous-catégories associées pour le header */
        $secondaryCategories = $categorieRepository->findByPrimaryCategorie($categorie->getId());

        return $this->render('reference.html.twig', [
            'reference' => $reference,
            'primaryCategories' => $primaryCategories,
            'categorieNom' => $categorie->getNom(),
            'categorieId' => $categorie->getId(),
            'secondaryCategories' => $secondaryCategories,
            'nextId' => $nextReference,
            'prevId' => $previousReference,
        ]);
    } 
}
