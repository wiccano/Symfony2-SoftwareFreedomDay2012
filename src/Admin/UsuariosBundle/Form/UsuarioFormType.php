<?php

namespace Admin\UsuariosBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilder,
	Symfony\Component\Translation\Translator; 

class UsuarioFormType extends AbstractType
{
    protected $translator;
    
    public function setTranslator(Translator $translator)
    {
    	$this->translator = $translator;
    } 
				
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder						
			->add('usuario_nombre', 'text', 
                    array(
                        'attr' => array(
                            'dojoType' => 'dijit.form.ValidationTextBox',
                            'value' => null,
                            'required'=> true,
                            'trim' => true,
                            'uppercase' => true,
                            'promptMessage' => $this->translator->trans('Ingrese nombre de usuario'),
							'missingMessage' => $this->translator->trans('Nombre de usuario es requerido')
							),
                        'max_length' => 255))
			->add('usuario_login', 'text', 
                    array(
                        'attr' => array(
                            'dojoType' => 'dijit.form.ValidationTextBox',
                            'value' => null,
                            'required'=> true,  
                            'trim' => true,
                            'promptMessage' => $this->translator->trans('Ingrese cuenta de usuario'),
							'missingMessage' => $this->translator->trans('Cuenta de usuario es requerida')
							),
                        'max_length' => 100))
			->add('usuario_email', 'text', 
                    array(
                        'attr' => array(
                            'dojoType' => 'dijit.form.ValidationTextBox',
                            'value' => null,
                            'required'=> true,
                            'trim' => true,
                            'regExp' => '[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}',
							'promptMessage' => $this->translator->trans('Ingrese email'),
							'missingMessage' => $this->translator->trans('Email de usuario es requerido'),
							'invalidMessage' => $this->translator->trans('Email de usuario es invalido')
							),
                        'max_length' => 255))
        
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Admin\UsuariosBundle\Entity\Usuario',
        );
    }
    
    public function getName()
    {
        return 'formAddUsuario';
    }
}
