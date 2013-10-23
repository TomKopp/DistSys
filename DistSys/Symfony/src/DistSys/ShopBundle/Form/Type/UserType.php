<?php 

namespace DistSys\ShopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email', array( 
            'label'  => 'Email',
            'attr'   =>  array( 'class'   => 'input-block-level'),
			'label_attr' =>  array( 'class'   => ''),
            )
        );
        $builder->add('username', 'text', array( 
            'label'  => 'Benutzername',
            'attr'   =>  array( 'class'   => 'input-block-level'),
			'label_attr' =>  array( 'class'   => ''),
            )
        );
        $builder->add('password', 'repeated', array(
           'first_name' => 'password',
           'second_name' => 'confirm',
           'type' => 'password',
           'first_options' => array(
           'attr'   =>  array( 'class'   => 'input-block-level'),
		   'label_attr' =>  array( 'class'   => '')),
           'second_options' => array(
           'attr'   =>  array( 'class'   => 'input-block-level'),
		   'label_attr' =>  array( 'class'   => '')),
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DistSys\ShopBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'user';
    }
}