<?php
/**
 * Created by PhpStorm.
 * User: gsull
 * Date: 13-12-2015
 * Time: 1:50
 */
namespace Gulloa\SecurityBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Gulloa\SecurityBundle\Entity\Role;
use Gulloa\SecurityBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('root')
            ->setPassword('');
        $manager->persist($user);
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}