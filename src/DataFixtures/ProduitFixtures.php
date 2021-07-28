<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Produit;

class ProduitFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //creation des produit
        for($i=0; $i<10; $i++){

        $produit = new Produit();
        $produit->setNom("produit".$i);
        $produit->setPrix($i*3);
        $manager->persist($produit);
       
        }
       

        $manager->flush();
    }
}
