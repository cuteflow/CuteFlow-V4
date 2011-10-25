<?php

namespace CuteFlow\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ResettingType extends AbstractType
{
    public function getName()
    {
        return 'resetting';
    }
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('plainPassword', 'repeated', array(
                                    'type'=>'password',
                                    'invalid_message' => 'The password fields must match',
                                    'options' => array('label' => 'Password'),
                                    'error_bubbling'=>true,
                                          ));
    }
}
