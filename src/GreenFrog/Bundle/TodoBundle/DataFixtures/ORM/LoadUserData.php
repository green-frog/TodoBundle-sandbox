<?php

namespace GreenFrog\Bundle\TodoBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use GreenFrog\Bundle\TodoBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager)
    {
        $um = $this->container->get('fos_user.user_manager');
        
        $user = $um->createUser();
        $user->setUsername('user');
        $user->setPlainPassword('test');
        $user->setEmail('user@todo.lxk');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_USER'));
        $um->updateUser($user);
        
        $admin = $um->createUser();
        $admin->setUsername('admin');
        $admin->setPlainPassword('test');
        $admin->setEmail('admin@todo.lxk');
        $admin->setEnabled(true);
        $admin->setRoles(array('ROLE_SUPER_ADMIN'));
        $um->updateUser($admin);
    }
    public function getOrder()
    {
        return 1;
    }
}