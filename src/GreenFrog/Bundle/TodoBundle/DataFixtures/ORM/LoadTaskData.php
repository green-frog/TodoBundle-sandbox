<?php

namespace GreenFrog\Bundle\TodoBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use GreenFrog\Bundle\TodoBundle\Entity\Task;

class LoadTaskData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager)
    {
        $orm = $this->container->get('doctrine');
        
        $user = $orm->getRepository("GreenFrogTodoBundle:User")->findOneByUsername('user');
        for($i=1; $i<=16; $i++) {
            $t = new Task();
            $t->setTitle("Task #".$i);
            $t->setProgress(rand(0,100));
            $t->setActive(rand(0,1));
            $t->setUser($user);
            $manager->persist($t);            
        }
        
        $admin = $orm->getRepository("GreenFrogTodoBundle:User")->findOneByUsername('admin');
        for($i=1; $i<=6; $i++) {
            $t = new Task();
            $t->setTitle("Admin Task #".$i);
            $t->setProgress(rand(0,100));
            $t->setActive(rand(0,1));
            $t->setUser($admin);
            $manager->persist($t);            
        }

        $manager->flush();
    }
    public function getOrder()
    {
        return 2;
    }
}