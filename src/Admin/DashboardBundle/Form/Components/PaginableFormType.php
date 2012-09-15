<?php

namespace Admin\DashboardBundle\Form\Components;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilder;

class PaginableFormType extends AbstractType
{
    private $id;	
    
    public function __construct($id)
    {
    	$this->id = $id;
   	}
		
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder						
			->add("page", 'hidden', 
                    array(
                        'attr' => array(
                            'value' => $options['data']['page'],
                            'dojoType' => 'dijit.form.TextBox',
                            'trim' => true,
							),
				   		 'required' => false))
			->add("tamano", 'hidden', 
                    array(
                        'attr' => array(
                            'value' => $options['data']['tamano'],
                            'dojoType' => 'dijit.form.TextBox',
                            'trim' => true,
							),
						'required' => false))
			->add("orderby", 'hidden', 
                    array(
                        'attr' => array(
                            'value' => $options['data']['orderby'],
                            'dojoType' => 'dijit.form.TextBox',
                            'trim' => true,
							),
						'required' => false))
			->add("orderdirection", 'hidden', 
                    array(
                        'attr' => array(
                            'value' => $options['data']['orderdirection'],
                            'dojoType' => 'dijit.form.TextBox',
                            'trim' => true,
							),
						'required' => false))
			->add("deletekey", 'hidden', 
                    array(
                        'attr' => array(
                            'dojoType' => 'dijit.form.TextBox',
                            'trim' => true,
							),
						'required' => false))        
        ;
    }

    public function getName()
    {
        return 'Form_'.$this->id;
		
    }
}
