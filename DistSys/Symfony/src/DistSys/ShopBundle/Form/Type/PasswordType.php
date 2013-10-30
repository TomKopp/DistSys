<?php 
namespace DistSys\ShopBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
 
class PasswordType extends AbstractType
{
  public function buildForm( FormBuilderInterface $builder, array $options )
  {
    $builder->add('password', 'repeated', array(
      'first_name' => 'password',
      'second_name' => 'confirm',
      'type' => 'password',
      'first_options' => array(
        'attr' => array('class' => 'col-lg-9  form-control'),
        'label_attr' => array('class' => 'col-lg-3 control-label'),
        'label' => 'Passwort',
      ),
      'second_options' => array(
        'attr' => array('class' => 'col-lg-9  form-control'),
        'label_attr' => array('class' => 'col-lg-3 control-label'),
        'label' => 'Passwort wiederholen',
      ),
      )
    );
  }
 
  function getName() {
    return 'PasswordType';
  }
}