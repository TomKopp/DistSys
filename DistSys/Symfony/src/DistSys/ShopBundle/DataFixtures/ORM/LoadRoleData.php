<?php

namespace WDistSys\ShopBundle\DataFixtures\ORM;

use DistSys\ShopBundle\Entity\Role;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Common\DataFixtures\AbstractFixture;



use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{
        public function getOrder(){
                return 2;
        }
        
  /**
   * {@inheritDoc}
   */
  public function load(ObjectManager $manager)
  {
          
        
          $role1 = new Role();
          $role1->setName('ROLE_USER');

          $role2 = new Role();
          $role2->setName('ROLE_ADMIN');


          $manager->persist($role1);
    $manager->persist($role2);


    
    $this->addReference('role1', $role1);
    $this->addReference('role2', $role2);

          
          
    $manager->flush();
          
    
  }
}

?>