<?php

namespace CuteFlow\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
    public function getName()
    {
        return 'user';
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

        $builder->add('username', 'text', array(
                                    'label'=>'Username'
                                          ));

        $builder->add('plainPassword', 'repeated', array(
                                    'type'=>'password',
                                    'invalid_message' => 'user.validation.password.match',
                                    'options' => array('label' => 'Password'),
                                    'error_bubbling'=>true,
                                          ));

        $builder->add('admin', 'checkbox', array(
                                    'label'=>'Has Admin-Rights',
                                    'required'=>false,
                                           ));

        $builder->add('groups');
    }
}
