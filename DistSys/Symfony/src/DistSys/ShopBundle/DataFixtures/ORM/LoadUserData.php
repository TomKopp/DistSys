<?php

namespace DistSys\ShopBundle\DataFixtures\ORM;

use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

use DistSys\ShopBundle\Entity\User;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface,
		ContainerAwareInterface {
	private $container;

	public function setContainer(ContainerInterface $container = null) {
		$this->container = $container;
	}

	public function getOrder() {
		return 3;
	}

	/**
	 * {@inheritDoc}
	 */
	public function load(ObjectManager $manager) {

		$factory = $this->container->get('security.encoder_factory');

		$user1 = new User();
		$user1->setUsername('user');
		$user1->setEmail('user@localhost');

		$encoder = $factory->getEncoder($user1);
		$password = $encoder->encodePassword('userpass', $user1->getSalt());

		$user1->setPassword($password);
		$user1->addRole($this->getReference('role1'));
		$user1->setCity("Dreden");
		$user1->setFirstname("User");
		

		$user2 = new User();
		$user2->setUsername('admin');
		$user2->setEmail('admin@localhost');

		$encoder = $factory->getEncoder($user2);
		$password = $encoder->encodePassword('adminpass', $user2->getSalt());

		$user2->setPassword($password);
		$user2->addRole($this->getReference('role2'));

		$this->addReference('user1', $user1);
		$this->addReference('user2', $user2);

		$manager->persist($user1);
		$manager->persist($user2);

		$manager->flush();

	}
}

?>