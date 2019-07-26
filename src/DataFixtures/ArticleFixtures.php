<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        for($i = 1; $i <= 10; $i++){
        	$article = new Article();
        	$article->setTitle("Title Article n: $i ")
        			->setContent("<p>Content of the Article n: $i</p>")
        			->setImage("http://placehold.it/350X150")
        			->setCreateAt(new \DateTime());

        	$manager->persist($article);
        }

        $manager->flush();
    }
}
