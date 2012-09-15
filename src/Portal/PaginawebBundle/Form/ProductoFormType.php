<?php

namespace Portal\PaginawebBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
	Symfony\Component\Translation\Translator; 

use Doctrine\ORM\EntityRepository;

class ProductoFormType extends AbstractType
{
    protected $translator;
    
    public function setTranslator(Translator $translator)
    {
    	$this->translator = $translator;
    } 
				
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('producto_codigo', 'hidden',
        				array(
        					'attr' => array(
        						'style' => "",
        						'value' => $options['producto_codigo'] ? $options['producto_codigo'] : 0,
        						'trim' => true,
        						),
        					'required' => false))
        				
	    	->add('producto_nombre', 'text', 
	                    array(
	                        'attr' => array(
	                            'style' => "width: 400px;",
        						'value' => $options['producto_nombre'],
	                            'maxlength' => 50,
	                        	'trim' => true,                          
	                            ),
	                  		'required' => true))
	                  		
	         ->add('producto_peso', 'text', 
                    array(
                        'attr' => array(
                        	'style' => "width: 50px; text-align:center;",
                            'value' => $options['producto_peso'],
                            'required'=> false,
                            'trim' => true,
                        ),
                        'max_length' => 5))
	                  		                  		
							
			->add('categoria_codigo', 'entity', 
	                   	array(
	                   		'class' => 'PortalPaginawebBundle:Categoria',
					        'attr' => array(
					          	'value' => $options['categoria_codigo'],
					        ),
	                   		'empty_value' => '-- SELECCIONE --',
	                   		'property' => 'CategoriaNombre',
                   			'query_builder' => function(EntityRepository $er) {
                   				return $er->createQueryBuilder('c')
                   				->select('c')
                   				->orderBy('c.categoria_nombre', 'ASC');
                   			},
                   			'required' => false,
	                    ))	

       	 ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Portal\PaginawebBundle\Entity\Producto',
        	'producto_nombre' => null,
            'producto_codigo' => null,
            'producto_descripcion' => null,
            'producto_peso' => null,
            'categoria_codigo' => null
        );
    }
    
    public function getName()
    {
        return 'formAddProducto';
    }
}
