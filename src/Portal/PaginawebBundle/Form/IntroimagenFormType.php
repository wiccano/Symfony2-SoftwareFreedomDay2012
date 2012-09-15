<?php

namespace Portal\PaginawebBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
	Symfony\Component\Translation\Translator; 

use Doctrine\ORM\EntityRepository;

class IntroimagenFormType extends AbstractType
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
        						'value' => 0,
        						'trim' => true,
        						),
        					'required' => false))
	            
	            ->add('imagen1_titulo', 'text', 
	                    array(
	                        'attr' => array(
	                            'style' => "width: 400px;",
	                            'maxlength' => 100,
	                        	'trim' => true,
        						'placeholder' => 'Titulo de la Imagen que aparecerá en la parte superior'
	                            ),
	                    'required' => true))
	                    
	                    
	            ->add('imagen2_titulo', 'text',
                    		array(
                    			'attr' => array(
                    				'style' => "width: 400px;",
                    				'maxlength' => 100,
                    				'trim' => true,
                    				'placeholder' => 'Titulo de la Imagen que aparecerá en la parte superior'
                    			),
                    			'required' => true))
	                    				
	                    				
                ->add('imagen3_titulo', 'text',
                    		array(
                    			'attr' => array(
                    				'style' => "width: 400px;",
                    				'maxlength' => 100,
                    				'trim' => true,
                    				'placeholder' => 'Titulo de la Imagen que aparecerá en la parte superior'
                    			),
                    			'required' => true))
	                    
	           ->add('menu_codigo', 'entity',
	                    		array(
	                    			'class' => 'PortalPaginawebBundle:Menu',
	                    			'empty_value' => '-- SELECCIONE --',
	                    			'property' => 'MenuNombre',
	                    			'query_builder' => function(EntityRepository $er) {
	                    			return $er->createQueryBuilder('m')
	                    				->select('m')
	                    				->orderBy('m.menu_nombre', 'ASC');
	                    			},
	                    		'required' => false,
		));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Portal\PaginawebBundle\Entity\Introimagen',
        );
    }
    
    public function getName()
    {
        return 'formAddIntroimagen';
    }
}
