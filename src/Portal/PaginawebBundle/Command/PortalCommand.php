<?php
namespace Portal\PaginawebBundle\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PortalCommand extends Command implements ContainerAwareInterface
{
	private $container;
	
	public function setContainer(ContainerInterface $container=null)
	{
		$this->container = $container;
	}
	
	protected function configure()
	{
		$this
			->setName('component:infoPortal')
			->setDescription('Muestra Informacion de los elementos del Portal')
			->setHelp( 	"El Comando <info>component:infoPortal</info> proporciona informacion acerca de los elementos del Portal. " .
						" Necesita como argumento el tipo de elemento que se quiera consultar 'Categorias', 'Menus', 'Porductos' " .
						" Y de manera opcional se le puede enviar el codigo de un elemento padre a consultar
							<info>EJ: component:infoPortal categorias 2 </info> " .
							" Consultaria las categorias asociados a el Menu codigo 2 " .
							" <info>EJ: component:infoPortal Menus </info> " .
							" Consultaria los menus existentes
							")
			->setDefinition(
				array(
					new InputArgument('tipo_elemento',InputArgument::REQUIRED,'Tipo de elemento a Consultar'),
					new InputArgument('cod_elemento_padre',InputArgument::OPTIONAL,'Codigo del elemento padre que agrupa los tipos de elementos que va a consultar'),
					)
				); 
	}
	
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->setContainer($this->getApplication()->getKernel()->getContainer());
        $elemento = trim($input->getArgument('tipo_elemento'));
		$padre = trim($input->getArgument('cod_elemento_padre'));
		switch (strtolower($elemento)) {
			case 'menus':
				$em = $this->container->get('doctrine.orm.entity_manager');
				$output->writeln("Vamos a listar los Menus");
				$msg2 ="";
				$menus = $em->getRepository('\Portal\PaginawebBundle\Entity\Menu')->findAll();

				$output->writeln("-------");
				foreach($menus as $k=>$v){
					$output->writeln($v->getMenuNombre()." ({$v->getMenuCodigo()})");	
				} 
				$output->writeln("-------");
				if(count($menus)<= 0){
					$output->writeln("No se han encontrado Menus ... ");	
				}else{
					$output->writeln(count($menus)." Menus Encontrados y Listados ... ");
				}	
				break;
			case 'categorias':
				$em = $this->container->get('doctrine.orm.entity_manager');	
				$msg = "Vamos a listar las categorias";
				$msg2 ="";
				if(strlen($padre) <= 0){
					$categorias = $em->getRepository('\Portal\PaginawebBundle\Entity\Categoria')->findAll();
				}else{
					$msg2 = " del Menu: $padre";
					$categorias = $em->getRepository('\Portal\PaginawebBundle\Entity\Categoria')->findBy(array('menu_codigo' => $padre));	
				}
				$output->writeln($msg.$msg2);
				$output->writeln("-------");
				foreach($categorias as $k=>$v){
					$output->writeln($v->getCategoriaNombre()." ({$v->getCategoriaCodigo()})");	
				} 
				$output->writeln("-------");
				if(count($categorias)<= 0){
					$output->writeln("No se han encontrado Categorias $msg2... ");	
				}else{
					$output->writeln(count($categorias)." Categorias Encontradas y Listadas $msg2 ... ");	
				}
				break;				
			case 'productos':
				$em = $this->container->get('doctrine.orm.entity_manager');
				$msg = "Vamos a listar los Productos";$msg2 ="";
				if(strlen($padre) <= 0){
					$productos = $em->getRepository('\Portal\PaginawebBundle\Entity\Producto')->findAll();
				}else{
					$msg2 = " de la Categoria: $padre";
					$productos = $em->getRepository('\Portal\PaginawebBundle\Entity\Producto')->findBy(array('categoria_codigo' => $padre));	
				}
				$output->writeln($msg.$msg2);
				$output->writeln("-------");	
				foreach($productos as $k=>$v){
					$output->writeln($v->getProductoNombre()." ({$v->getProductoCodigo()})");	
				} 
				$output->writeln("-------");
				if(count($productos)<= 0){
					$output->writeln("No se han encontrado Productos $msg2... ");	
				}else{
					$output->writeln(count($productos)." Productos Encontrados y Listados $msg2... ");
				}		
				break;
			
			default:
				$text ="El tipo de elemento a consultar no es correcto. Debe ser Menus, Categorias o Productos";
				$output->writeln($text);				
				break;
		}
	} 
}
