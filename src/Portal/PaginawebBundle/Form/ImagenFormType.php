<?php

namespace Portal\PaginawebBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
	Symfony\Component\Translation\Translator; 

use Doctrine\ORM\EntityRepository;

class ImagenFormType extends AbstractType
{
    protected $translator;
    
    public function setTranslator(Translator $translator)
    {
    	$this->translator = $translator;
    } 
				
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        		->add('imagen_codigo', 'hidden',
        				array(
        					'attr' => array(
        						'style' => "",
        						'value' => null,
        						'trim' => true,
        						),
        					'required' => false))
        				
	    		->add('imagen_nombre', 'text', 
	                    array(
	                        'attr' => array(
	                            'style' => "width: 400px;",
	                            'maxlength' => 50,
	                        	'trim' => true, 
	                        	'value' => null                        
	                            ),
	                  		'required' => true))
							
				->add('producto_codigo', 'hidden', 
						array(
							'attr' => array(
								'value' => $options['producto_codigo']
							),
							'required' => false))
	            
	            ->add('imagen_titulo', 'text', 
	                    array(
	                        'attr' => array(
	                            'style' => "width: 400px;",
	                            'maxlength' => 100,
	                        	'trim' => true,
        						'placeholder' => 'Titulo de la Imagen que aparecerá en la parte superior'
	                            ),
	                    'required' => true))
	                    
	            ->add('imagen_texto', 'textarea',
	                    array(
	                    	'attr' => array(
	                    	'style' => "width: 400px; height:200px;",
	                    	'trim' => true,
        					'placeholder' => 'Texto de la Imagen que aparecerá en la parte inferior'
	                    	),
	                    'required' => true))
       	 ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Portal\PaginawebBundle\Entity\Imagen',
            'producto_codigo' => null,
        );
    }
    
    public function getName()
    {
        return 'formAddImagen';
    }
}
