<?php

namespace Portal\PaginawebBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
	Symfony\Component\Translation\Translator;

use Doctrine\ORM\EntityRepository;

class CategoriaFormType extends AbstractType
{
    protected $translator;
    
    public function setTranslator(Translator $translator)
    {
    	$this->translator = $translator;
    } 
				
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
      
        	->add('categoria_codigo', 'hidden',
                    array(
                        'attr' => array(
                        	'style' => "",
                        	'value' => $options['categoria_codigo'],
                        	'trim' => true,
                       	),
                        'required' => false))
        
			->add('categoria_nombre', 'text', 
                    array(
                        'attr' => array(
                        	'style' => "width: 250px;",
                            'value' => $options['categoria_nombre'],
                            'required'=> false,
                            'trim' => true,
                        ),
                        'max_length' => 50))
                        
            ->add('categoria_descripcion', 'textarea', 
                    array(
                        'attr' => array(
                        	'style' => "width: 400px; height:120px;",
                            'value' => $options['categoria_descripcion'],
                            'required'=> false,
                            'trim' => true,
                        ),
                        'max_length' => 255))
             
             ->add('categoria_peso', 'text', 
                    array(
                        'attr' => array(
                        	'style' => "width: 50px; text-align:center;",
                            'value' => $options['categoria_peso'],
                            'required'=> false,
                            'trim' => true,
                        ),
                        'max_length' => 5))
                        
            ->add('menu_codigo', 'entity',
                   	array(
                   		'class' => 'PortalPaginawebBundle:Menu',
                   		'attr' => array(
        					'value' => $options['menu_codigo'],
                   		),
                   		'empty_value' => '-- SELECCIONE --',
                   		'property' => 'MenuNombre',
                   		'query_builder' => function(EntityRepository $er) {
                   			return $er->createQueryBuilder('m')
                   			->select('m')
                   			->orderBy('m.menu_nombre', 'ASC');
                   		},
                    	'required' => false,
                    ))
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Portal\PaginawebBundle\Entity\Categoria',
        	'categoria_nombre' => null,
        	'categoria_codigo' => null,
        	'categoria_descripcion' => null,
        	'categoria_peso' => null,
        	'menu_codigo' => null
        );
    }
    
    public function getName()
    {
        return 'formAddCategoria';
    }
}
