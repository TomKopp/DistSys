<?php

namespace DistSys\ShopBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType {

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
