<?php

namespace Admin\DashboardBundle\Form\Components;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface;

class DatagridFormType extends AbstractType
{
    private $id;	
    
    public function __construct($id)
    {
    	$this->id = $id;
   	}
		
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add("id", 'hidden', 
                    array(
                        'attr' => array(
                            'value' => $options['data']['id'],
                            'trim' => true,
							),
				   		 'required' => false))
			->add("paginable", 'hidden', 
                    array(
                        'attr' => array(
                            'value' => $options['data']['paginable'],
                            'trim' => true,
							),
				   		 'required' => false))
			->add("page", 'hidden', 
                    array(
                        'attr' => array(
                            'value' => $options['data']['page'],
                            'trim' => true,
							),
				   		 'required' => false))
			->add("tamano", 'hidden', 
                    array(
                        'attr' => array(
                            'value' => $options['data']['tamano'],
                            'trim' => true,
							),
						'required' => false))
			->add("tamanoperpage", 'hidden', 
                    array(
                        'attr' => array(
                            'value' => $options['data']['tamanoperpage'],
                            'trim' => true,
							),
						'required' => false))
			->add("orderby", 'hidden', 
                    array(
                        'attr' => array(
                            'value' => $options['data']['orderby'],
                            'trim' => true,
							),
						'required' => false))
			->add("orderdirection", 'hidden', 
                    array(
                        'attr' => array(
                            'value' => $options['data']['orderdirection'],
                            'trim' => true,
							),
						'required' => false))
			->add("contentheader", 'hidden', 
                    array(
                        'attr' => array(
                            'value' => $options['data']['contentheader'],
                            'trim' => true,
							),
						'required' => false))			
			->add("labelregistros", 'hidden', 
                    array(
                        'attr' => array(
                            'value' => $options['data']['labelregistros'],
                            'trim' => true,
							),
						'required' => false))
			->add("class", 'hidden', 
                    array(
                        'attr' => array(
                            'value' => $options['data']['class'],
                            'trim' => true,
							),
				   		 'required' => false))
			->add("withform", 'hidden', 
                    array(
                        'attr' => array(
                            'value' => $options['data']['withform'],
                            'trim' => true,
							),
				   		 'required' => false))
			->add("formname", 'hidden', 
                    array(
                        'attr' => array(
                            'value' => $options['data']['formname'],
                            'trim' => true,
							),
				   		 'required' => false))
			->add("numerable", 'hidden', 
                    array(
                        'attr' => array(
                            'value' => $options['data']['numerable'],
                            'trim' => true,
							),
				   		 'required' => false))
			->add("deletekey", 'hidden', 
                    array(
                        'attr' => array(
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
