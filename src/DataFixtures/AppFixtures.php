<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\ORM\Doctrine\Populator;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $images=[
            'ballon.jpg',
            'hamac.jpg',
            'parasol.jpg',
            'ventilo.jpg',
            'auba.jpg',
            'laca.jpg',
            'salah.jpg',
            'mane.jpg',

        ];
        //Recuperation du Faker
        $generator = Factory::create('fr_FR');
        //Populateur d'entité se base sur src/Entity
        $populator= new Populator($generator, $manager);

        //Creation des Catégories
        $populator->addEntity(Category::class, 10);
        $populator->addEntity(Tag::class, 20);
        $populator->addEntity(User::class, 20);
        $populator->addEntity(
            Product::class,
            194,
            ['price'=>function () use ($generator) {
                return $generator->randomFloat(2, 0, 9999999.99);
            },
                'imageName'=>function () use ($images) {
                    return $images[rand(0, sizeof($images)-1)];
                }
            ]
        );

        //Flush
        $populator->execute();


        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
