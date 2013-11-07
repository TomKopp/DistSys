<?php

namespace DistSys\ShopBundle\Form\Type;
use DistSys\ShopBundle\Entity\Repository\GalleryItemRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductEditType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
				->add('name', 'text',
						array(
								'attr' => array(
										'class' => 'col-lg-10 form-control'),
								'label' => 'Titel',
								'label_attr' => array(
										'class' => 'col-lg-2 control-label '),));

		$builder
				->add('description', 'textarea',
						array(
								'attr' => array(
										'class' => 'col-lg-10 form-control'),
								'label' => 'Beschreibung',
								'label_attr' => array(
										'class' => 'col-lg-2 control-label '),));

		$builder
				->add('price', 'text',
						array(
								'attr' => array(
										'class' => 'col-lg-10 form-control'),
								'label' => 'Preis',
								'label_attr' => array(
										'class' => 'col-lg-2 control-label '),));

		$builder
				->add('stock', 'text',
						array(
								'attr' => array(
										'class' => 'col-lg-10 form-control'),
								'label' => 'Verfügbare Anzahl',
								'label_attr' => array(
										'class' => 'col-lg-2 control-label '),));

		$builder
				->add('status', 'choice',
						array(
								'attr' => array(
										'class' => 'col-lg-10 form-control'),
								'label' => 'Status',
								'label_attr' => array(
										'class' => 'col-lg-2 control-label '),
								'choices' => array(
										true => 'verfügbar',
										false => 'nicht verfügbar',),));
		

		$builder
		->add('attributes', 'entity',
				array(
						'multiple' => true,
						'attr' => array(
								'class' => 'col-lg-10 form-control'),
						'label' => 'Kategorie',
						'label_attr' => array(
								'class' => 'col-lg-2 control-label '),
						'class' => 'DistSysShopBundle:Attribute',
            'property' => 'name',));
		


	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver
				->setDefaults(
						array(
								'data_class' => 'DistSys\ShopBundle\Entity\Product'));
	}

	public function getName() {
		return 'product';
	}

}
