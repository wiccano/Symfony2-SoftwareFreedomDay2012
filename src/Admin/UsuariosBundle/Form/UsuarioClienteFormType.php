<?php

namespace Admin\UsuariosBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilder,
    Doctrine\ORM\EntityRepository,
	Symfony\Component\Translation\Translator; 

class UsuarioClienteFormType extends AbstractType
{
    protected $translator;
    
    public function setTranslator(Translator $translator)
    {
    	$this->translator = $translator;
    } 
				
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder						
			->add('usuario_codigo', 'entity', 
					array(
					'attr' => array(
						'onChange' => 'filterGridUsuarioClientes()'
					),
				    'class' => 'AdminUsuariosBundle:Usuario',
				    'query_builder' => function(\Admin\UsuariosBundle\Entity\UsuarioRepository $er) {
							        	return $er->createQueryBuilder('u')
							            ->orderBy('u.usuario_codigo', 'ASC');
	    							},
	    			'empty_value' => 'SELECCIONE'))  
        	->add('cliente_codigo', 'text', 
                    array(
                    'attr' => array(
                        'value' => null,                            
						),
                    'max_length' => 100))
		;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Admin\UsuariosBundle\Entity\UsuarioCliente',
        ); 
    }
    
    public function getName()
    {
        return 'formUsuarioCliente';
    }
}
