<?php
namespace PageBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PageBundle\Entity\Page;
use TermBundle\DataFixtures\ORM\TermLoad;

class PageLoad extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $termRepository = $manager->getRepository('TermBundle:Term');
        for ($i = 1; $i <= 3; $i++) {
            $page = new Page();
            $page->setTitle("Page".$i);
            $page->setBody("Body".$i);

            $term = $termRepository->findOneByName('Term'.$i);
            if ($term) {
                $page->setCategory($term);
            }

            $manager->persist($page);
        }

        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            TermLoad::class
        ];
    }

}