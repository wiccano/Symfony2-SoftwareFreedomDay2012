<?php
namespace Portal\PaginawebBundle\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CalculadoraCommand extends Command implements ContainerAwareInterface
{
	private $container;
	
	public function setContainer(ContainerInterface $container=null)
	{
		$this->container = $container;
	}
	
	protected function configure()
	{
		$this
			->setName('component:calculadora')
			->setDescription('Calculadora basica')
			->setHelp( 	"El Comando <info>component:calculadora</info> proporciona una calculadora basica, Recibiendo como argumentos Op1 Op2 y Simbolo de Operacion '+,-,/,*':
							<info>EJ: component:calculadora 1 5 /</info>
							")
							/*
							 Try to guess the hidden <comment>word</comment> whose length is<comment>8</comment> 
							before you reach the maximum number of<comment>attempts</comment>.
							You can also configure the maximum number of attempts with the <info>--max-attempts</info> option:
							<info>game:hangman 8 --max-attempts=5</info>*/
			->setDefinition(
				array(
					new InputArgument('op1',InputArgument::REQUIRED,'Operando 1'),
					new InputArgument('op2',InputArgument::REQUIRED,'Operando 2'),
					new InputArgument('operacion',InputArgument::REQUIRED,'Operacion a realizara con los operandos'),
					//new InputOption('max-attempts',null,InputOption::VALUE_OPTIONAL,'Max number of attempts',10),
					)
				); 
	}
	
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->setContainer($this->getApplication()->getKernel()->getContainer());
		$op1 = trim($input->getArgument('op1'));
		$op2 = trim($input->getArgument('op2'));
		$operacion = trim($input->getArgument('operacion'));
		
		$arOperaciones = array('+'=>'Sumar', '-'=>'Restar', '*'=>'Multiplicar', '/'=>'Dividir');
		if(!array_key_exists($operacion, $arOperaciones))
		{
			throw new \InvalidArgumentException('La Operacion ($operacion) NO esta soportada.'); 
		}
        $text = "Vamos a {$arOperaciones[$operacion]} $op1 y $op2 ...";//$serviceName
        $output->writeln($text);	
		
		$resultado ="";
		switch ($operacion) {
			case '+': $resultado = $op1 + $op2;
				break;
			case '-': $resultado = $op1 - $op2;
				break;
			case '*': $resultado = $op1 * $op2;
				break;
			case '/': 
					if($op2 == 0){
						throw new \InvalidArgumentException('No puede dividir entre cero');	
					}
					 
					$resultado = $op1 / $op2;
				break;
		}
		$text ="Resultado: $resultado";
		$output->writeln($text);	
	} 
}
?>
