<?php

namespace Admin\UsuariosBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Doctrine\ORM\EntityRepository,
	Symfony\Component\Translation\Translator; 

class CambiarContrasenaFormType extends AbstractType
{
    protected $translator;
    
    public function setTranslator(Translator $translator)
    {
    	$this->translator = $translator;
    } 
				
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder->add('contrasena_actual', 'password', 
					array(
						'label' => 'Contraseña actual',
						'attr' => array(
							'style' => "width: 250px;",
							'title' => "Por favor, ingrese contraseña actual",
							'class' => "required ui-widget-content",
						),
						'required'=> true,
					))									
				->add('contrasena_nueva', 'password', 
					array(
						'label' => 'Nueva contraseña',
						'attr' => array(
							'style' => "width: 250px;",
							'title' => "Por favor, ingrese contraseña actual",
							'class' => "required ui-widget-content",
						),
						'required'=> true,
					))
				->add('contrasena_repeated', 'password', 
					array(
						'label' => 'Confirmar contraseña',
						'attr' => array(
							'style' => "width: 250px;",
							'title' => "Por favor, ingrese contraseña actual",
							'class' => "required ui-widget-content",
						),
						'required'=> true,
					))
		;
    }
   
    public function getName()
    {
        return 'formCambiarContrasena';
    }
}