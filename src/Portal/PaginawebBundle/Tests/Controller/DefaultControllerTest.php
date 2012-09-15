<?php

namespace Portal\PortalBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class DefaultControllerTest extends WebTestCase
{	
    public function testIndex()
    {			
        $client = static::createClient();
		
		$this->em = $client->getKernel()->getContainer()->get('doctrine.orm.entity_manager')->getConnection();
		
		$crawler = $client->request('GET', '/login');
		
		$form = $crawler->selectButton('login')->form(); // case sensitive for the input e.g. value="LOGIN"
		
		$crawler = $client->submit(
		    $form,
		    array(
		        'formLogin[_username]' => 'wicano', // case sensitive for the input e.g. name="_username"
		        'formLogin[_password]' => 'temporal' // case sensitive for the input e.g. name="_password"
		    )
		);
		
		$crawler = $client->followRedirect();
		
		//throw new \RuntimeException($client->getResponse()->getContent());	
			
		$this->assertTrue($crawler->filter('html:contains("Sistema de Administraci")')->count() > 0, 'No se pudo iniciar la sesión con un nombre de usuario y contraseña.');		
	}
}
