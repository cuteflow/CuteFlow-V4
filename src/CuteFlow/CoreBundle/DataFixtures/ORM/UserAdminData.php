<?php
namespace CuteFlow\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use CuteFlow\CoreBundle\Entity\User;

class UserAdminData implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load($manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setLocale('en');
        $userAdmin->setEmail('demo@demo.de');
        $userAdmin->setLastName('Admin');
        $userAdmin->setFirstName('Admin');
        $userAdmin->addRole(User::ROLE_CUTEFLOW_ADMIN);
        $userAdmin->addRole(User::ROLE_CUTEFLOW_USER);

        $encoder = $this->container->get('security.encoder_factory')->getEncoder($userAdmin);
        $userAdmin->setPassword($encoder->encodePassword('admin', $userAdmin->getSalt()));

        $group = new \CuteFlow\CoreBundle\Entity\UserGroup();
        $group->setName('Testgroup');

        $userAdmin->addGroups($group);

        $manager->persist($userAdmin);
        $manager->flush();
    }
}