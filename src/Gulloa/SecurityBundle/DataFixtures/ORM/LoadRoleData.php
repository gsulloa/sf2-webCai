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

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $array = [
            'ROLE_SUPER_ADMIN',
            'ROLE_ADMIN',
            'ROLE_USER',
            'ROLE_EDITOR',
            'ROLE_JEFE_DE_COMISION'
        ];
        foreach($array as $element){
            $role = new Role();
            $role->setEtiqueta($element);
            $manager->persist($role);
        }
        
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}