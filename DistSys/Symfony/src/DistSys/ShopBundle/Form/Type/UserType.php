<?php

namespace DistSys\ShopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('email', 'email', array(
      'attr' => array('class' => 'form-control'),
      'label' => 'Email',
      'label_attr' => array('class' => 'col-lg-2 control-label'),
      )
    );
    $builder->add('username', 'text', array(
      'attr' => array('class' => 'form-control'),
      'label' => 'Benutzername',
      'label_attr' => array('class' => 'col-lg-2 control-label'),
      )
    );
    $builder->add('password', 'repeated', array(
      'first_name' => 'password',
      'second_name' => 'confirm',
      'type' => 'password',
      'first_options' => array(
        'attr' => array('class' => 'form-control'),
        'label_attr' => array('class' => 'col-lg-2 control-label')
      ),
      'second_options' => array(
        'attr' => array('class' => 'form-control'),
        'label_attr' => array('class' => 'col-lg-2 control-label')
      ),
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
