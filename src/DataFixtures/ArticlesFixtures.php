<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use App\Entity\Categorie;
use App\Entity\Commentaires;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Faker;


class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

//        $faker = \Faker\Factory::create('fr_FR');
        $faker = Faker\Factory::create('fr_FR');

        for ($i=0; $i<100 ; $i++ ) 
        { 
           $articles = new Articles();
           $articles
                    ->setTitre($faker->sentence($nb = 5, $asText = false)
                    ->setCategorie($categorie)
                    ->setAuteur($faker->auteur)
                    ->setResume($faker->text($maxNbChars = 10))
                    ->setContenu($content)
                    ->setImage($faker->imageUrl())
                    ->setCreatedAt(new \DateTime()));
                            
            $manager->persist($articles);
        }
        
        $manager->flush();
    }
}
