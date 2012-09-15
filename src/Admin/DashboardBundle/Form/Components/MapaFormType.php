<?php

namespace Admin\DashboardBundle\Form\Components;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilder;

class MapaFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder						
			->add("type", 'hidden', 
                    array(
                        'attr' => array(
                            'value' => $options['data']['type'],
                            'trim' => true,
							),
				   		 'required' => false))
			->add("reloaded", 'hidden', 
                    array(
                        'attr' => array(
                            'value' => $options['data']['reloaded'],
                            'trim' => true,
							),
				   		 'required' => false))
			->add("pause", 'hidden', 
                    array(
                        'attr' => array(
                            'value' => $options['data']['pause'],
                            'trim' => true,
							),
						'required' => false))
			->add("parameters", 'hidden', 
                    array(
                        'attr' => array(
                        	'value' => $options['data']['parameters'],
                            'trim' => true,
							),
						'required' => false))			
        ;
    }

    public function getName()
    {
        return 'Form_Filters_Mapa';
		
    }
}
