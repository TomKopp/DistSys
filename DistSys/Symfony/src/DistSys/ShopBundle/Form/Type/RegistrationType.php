<?php

namespace DistSys\ShopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('user', new UserType());
    $builder->add(
      'terms', 'checkbox', array(
      'attr' => array('class' => 'col-lg-offset-2 col-lg-1 checkbox'),
      'label' => 'Bestätigung der AGB\'s',
      'label_attr' => array('class' => ''),
      'property_path' => 'termsAccepted',
      )
    );
  }

  public function getName() {
    return 'registration';
  }

}
