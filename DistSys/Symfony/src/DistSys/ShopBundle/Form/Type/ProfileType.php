<?php

namespace DistSys\ShopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfileType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('username', 'text', array(
      'attr' => array('class' => 'col-lg-10 form-control'),
      'label' => 'Benutzername',
      'label_attr' => array('class' => 'col-lg-2 control-label '),
      )
    );
    $builder->add('email', 'email', array(
      'attr' => array('class' => 'col-lg-10 form-control'),
      'label' => 'Email',
      'label_attr' => array('class' => 'col-lg-2 control-label'),
      )
    );
    $builder->add('firstname', 'text', array(
      'attr' => array('class' => 'col-lg-10 form-control'),
      'label' => 'Vorname',
      'label_attr' => array('class' => 'col-lg-2 control-label'),
      )
    );
    $builder->add('lastname', 'text', array(
      'attr' => array('class' => 'col-lg-10 form-control'),
      'label' => 'Nachname',
      'label_attr' => array('class' => 'col-lg-2 control-label'),
      )
    );
    $builder->add('male', 'choice', array(
      'attr' => array('class' => ' col-lg-1 form-control'),
      'label' => 'Geschlecht',
      'label_attr' => array('class' => 'col-lg-2 control-label  '),
    	'choices'   => array(
    			true => 'männlich',
    			false => 'weiblich',
    	),
      )
    );
    $builder->add('street', 'text', array(
      'attr' => array('class' => 'col-lg-10 form-control'),
      'label' => 'Straße',
      'label_attr' => array('class' => 'col-lg-2 control-label'),
      )
    );
    $builder->add('postal', 'text', array(
      'attr' => array('class' => 'col-lg-10 form-control'),
      'label' => 'Postleitzahl',
      'label_attr' => array('class' => 'col-lg-2 control-label'),
      )
    );
    $builder->add('city', 'text', array(
      'attr' => array('class' => 'col-lg-10 form-control'),
      'label' => 'Ort',
      'label_attr' => array('class' => 'col-lg-2 control-label'),
      )
    );
    $builder->add('phone', 'text', array(
      'attr' => array('class' => 'col-lg-10 form-control'),
      'label' => 'Telefon',
      'label_attr' => array('class' => 'col-lg-2 control-label'),
      )
    );
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'DistSys\ShopBundle\Entity\User'
      )
    );
  }

  public function getName() {
    return 'user';
  }

}
