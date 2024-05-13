<?php

namespace App\DataFixtures;

use App\Entity\categories;
use App\Entity\Livres;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{ 
    public function load(ObjectManager $manager): void
    {    
        $faker=Factory::create('fr_FN');
        for($j=1;$j<=3;$j++)
        {
            $cat=new categories();
            $libelle=$faker->name();
            $cat->setLibelle($libelle)
            ->setSlug(strtolower(preg_replace('/[^a-zA-Z0-9-^]/','-',$libelle)))
            ->setDescription($faker->sentence()); 
            $manager->persist($cat);
            for($i=1;$i< random_int(10,15);$i++)
        {$livre= new Livres();
            $titre=$faker->name();
            $datetime=$faker->dateTime();
            $datetimeimutable=\DateTimeImmutable::createFromMutable($datetime);
            $livre->setImage($faker->imageUrl())
            ->setTitre($faker->name())
            ->setAuteur($faker->name())
            ->setEditeur( $faker->company())
            ->setprix($faker->numberBetween(100,200))
            ->setISBN($faker->isbn13())
            ->setEditedAt( $datetimeimutable)
            ->setSlug(strtolower(preg_replace('/[^a-zA-Z0-9-^]/','-',$titre)))
            ->setResume($faker->sentence(20))
            ->setcategorie($cat);
            //->setAuteur($faker->userName())
            //->setQte($faker->numberBetween(0,200));
            $manager->persist($livre);
    }}
      
        $manager->flush();}
}
