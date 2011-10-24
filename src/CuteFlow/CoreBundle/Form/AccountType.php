<?php

namespace CuteFlow\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AccountType extends AbstractType
{
    public function getName()
    {
        return 'account';
    }

    public function buildForm(FormBuilder $builder, array $options)
    {

        $builder->add('lastName', 'text', array(
                                    'label'=>'Lastname'
                                          ));

        $builder->add('firstName', 'text', array(
                                    'label'=>'Firstname'
                                          ));

        $builder->add('email', 'email', array(
                                    'label'=>'Email'
                                          ));

        $builder->add('plainPassword', 'repeated', array(
                                    'type'=>'password',
                                    'invalid_message' => 'user.validation.password.match',
                                    'options' => array('label' => 'Password'),
                                    'error_bubbling'=>true,
                                          ));

        $builder->add('locale', 'choice', array(
            'label'=>'Language',
            'choices'=>array('de'=>'Deutsch', 'en'=>"English")
        ));

        $builder->add('theme', 'choice', array(
            'choices'=>array( 'basecamp'=>'Basecamp',
                              'modulaMartini'=>'Modula Martini',
                              'modulaMojito'=>'Modula Mojito'),
            'label'=>'Theme'));
    }
}
