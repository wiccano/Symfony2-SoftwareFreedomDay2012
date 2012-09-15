<?php

namespace Admin\SeguridadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginFormType extends AbstractType
{
    private $options;	
    
    public function __construct(array $options)
    {
    	$this->options = $options;
   	}
	
		
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('_username', 'text', 
                    array(
                        'attr' => array(
                            'style' => "width: 180px;",
                            'maxlength' => 25,
                        	'trim' => true,                            
                            ),
                    'required' => false))
						
			->add('_password', 'password', 
                    array(
                        'attr' => array(
                        	'style' => "width: 180px;",
                            'value' => null,
                            'required'=> true,
                            'trim' => true,
                            'promptMessage' => 'Ingrese contraseña'
                            ),
                        'max_length' => 100))
        
        ;
    }
    
    public function getName()
    {
        return 'formLogin';
    }
}
