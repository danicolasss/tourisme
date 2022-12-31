<?php

namespace App\DataFixtures;

use App\Entity\Etablissement;
use App\Repository\CategorieRepository;
use App\Repository\VilleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class Etablissements extends Fixture implements FixtureGroupInterface
{

    private SluggerInterface $slugger;
    private VilleRepository $villeRepository;
    private CategorieRepository $categorieRepository;

    public static function getGroups(): array
    {
        return ['group1'];
    }


    /**
     * @param SluggerInterface $slugger
     */
    public function __construct(SluggerInterface $slugger,VilleRepository $villeRepository,CategorieRepository $categorieRepository)
    {
        $this->slugger = $slugger;
        $this->villeRepository=$villeRepository;
        $this->categorieRepository = $categorieRepository;
    }
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create("fr_FR");
        $faker->addProvider(new \Faker\Provider\fr_FR\Company($faker));

        for ($i=0; $i<100; $i++) {
            $etablissement = new Etablissement();

            $villes = $this->villeRepository->findAll();
            $PremierId = $villes[0]->getId();
            $etablissement->setNom($faker->company())
                ->setAdrMail($faker->email())
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setDescription($faker->text(255))
                ->setAccuiel($faker->boolean(10))
                ->setActif($faker->boolean(85))
                ->setLibRue($faker->streetName())
                ->setNumRue($faker->buildingNumber())
                ->setVille($villes[rand(0,1805)])
                ->setNumTel(intval($faker->phoneNumber()))
                ->setSlug($this->slugger->slug($etablissement->getNom())->lower())
            ;
            $p=1;
            $o= rand(1,6);
            while($o>$p){
                $categorie=$this->categorieRepository->findAll();
                $etablissement->addCategorie($categorie[$p-1]);
                $p++;
            }


            $manager->persist($etablissement); // ordre INSERT
        }


        // envoie à la BDD
        $manager->flush();


    }


}
