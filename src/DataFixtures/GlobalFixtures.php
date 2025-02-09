<?php

namespace App\DataFixtures;

use App\Repository\ReferenceRepository;
use App\Repository\CategorieRepository;
use App\Entity\Categorie;
use App\Entity\Reference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GlobalFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Catégories
        $categorie1 = new Categorie();
        $categorie1->setNom('OBJET');
        $manager->persist($categorie1);

        $categorie2 = new Categorie();
        $categorie2->setNom('MODE');
        $manager->persist($categorie2);

        $categorie3 = new Categorie();
        $categorie3->setNom('ARCHI');
        $manager->persist($categorie3);

        $categorie4 = new Categorie();
        $categorie4->setNom('GRAPHISME');
        $manager->persist($categorie4);

        $categorie5 = new Categorie();
        $categorie5->setNom('ART');
        $manager->persist($categorie5);

        $categorie6 = new Categorie();
        $categorie6->setNom('Vetements');
        $categorie6->setDepend($categorie2);
        $manager->persist($categorie6);

        $categorie7 = new Categorie();
        $categorie7->setNom('Textile');
        $categorie7->setDepend($categorie2);
        $manager->persist($categorie7);

        $categorie8 = new Categorie();
        $categorie8->setNom('Broderie');
        $categorie8->setDepend($categorie2);
        $manager->persist($categorie8);

        $categorie9 = new Categorie();
        $categorie9->setNom('Contemporain');
        $categorie9->setDepend($categorie5);
        $manager->persist($categorie9);

        $categorie10 = new Categorie();
        $categorie10->setNom('Classique');
        $categorie10->setDepend($categorie5);
        $manager->persist($categorie10);

        $categorie11 = new Categorie();
        $categorie11->setNom('Periodes');
        $categorie11->setDepend($categorie5);
        $manager->persist($categorie11);
        
        $manager->flush();
    }
}
