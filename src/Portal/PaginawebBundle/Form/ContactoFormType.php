<?php

namespace Portal\PaginawebBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
	Symfony\Component\Translation\Translator; 

class ContactoFormType extends AbstractType
{
    protected $translator;
    
    public function setTranslator(Translator $translator)
    {
    	$this->translator = $translator;
    } 
				
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('contacto_email', 'text', 
                    array(
                        'attr' => array(
                            'style' => "width: 250px;",
                            'maxlength' => 50,
                        	'trim' => true,                          
                            ),
                    'required' => false))
						
			->add('contacto_info', 'textarea', 
                    array(
                        'attr' => array(
                        	'style' => "width: 400px; height:120px;",
                            'value' => null,
                            'required'=> true,
                            'trim' => true,
                            ),
                        'max_length' => 255))      
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Portal\PaginawebBundle\Entity\Contacto',
        );
    }
    
    public function getName()
    {
        return 'formAddContacto';
    }
}
