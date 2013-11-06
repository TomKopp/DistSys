<?php

namespace DistSys\ShopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategorieType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('name', 'text', array(
      'attr' => array('class' => 'col-lg-10 form-control'),
      'label' => 'Kategorie',
      'label_attr' => array('class' => 'col-lg-2 control-label '),
      )
    );

  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'DistSys\ShopBundle\Entity\Attribute'
      )
    );
  }

  public function getName() {
    return 'attribute';
  }

}
