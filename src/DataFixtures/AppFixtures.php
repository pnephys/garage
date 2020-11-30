<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use Cocur\Slugify\Slugify;
use App\Entity\User;
use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('FR-fr');
        //$slugify = new Slugify();
 // gestion des annonces
        for($a = 1; $a <= 15; $a++){
            $ad = new Ad();
            $title = $faker->word();
            $modele =$faker->word(2);
            
            //$slug = $slugify->slugify($title);
            //$coverImage = $faker->imageUrl(1000,350);
            $description = $faker->paragraph(2);
            $carburant =$faker->word();
            $transmission =$faker->word();
            $options = '<p>'.join('</p><p>',$faker->paragraphs(5)).'</p>';
            

            $ad->setMarque($title)
                //->setSlug($slug)
                ->setModele($modele)
                ->setCoverImage('https://picsum.photos/1000/350')
                ->setKm(rand(0,100000))
                
                ->setPrice(rand(16000,40000))
                ->setNbProprio(rand(0,10))
                ->setCylindre(rand(1,5))
                ->setPuissance(rand(1,7))
                ->setCarburant($carburant)
                ->setPcirculation(rand(1990,2020))
                ->setTransmission($transmission)
                ->setDescription($description)
                ->setOptions($options);

            $manager->persist($ad); 

            for($i=1; $i <= rand(2,5); $i++){
                $image = new Image();
                $image->setUrl('https://picsum.photos/200/200')
                    ->setCaption($faker->sentence())
                    ->setAd($ad);
                $manager->persist($image);    
            }
        }
        $manager->flush();
    }
}
