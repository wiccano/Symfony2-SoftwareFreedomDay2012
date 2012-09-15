<?php
namespace Admin\DashboardBudle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Admin\UsuariosBundle\Entity\Usuario;
use Admin\UsuariosBundle\Entity\Rol;

use Portal\PaginawebBundle\Entity\Categoria;
use Portal\PaginawebBundle\Entity\Contacto;
use Portal\PaginawebBundle\Entity\Producto;
use Portal\PaginawebBundle\Entity\Menu;
use Portal\PaginawebBundle\Entity\Introimagen;
use Portal\PaginawebBundle\Entity\Hojavida;

class DatosIniciales extends AbstractFixture implements OrderedFixtureInterface
{
	protected $manager; 
	private $container;  
	
	public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    } 
	
	public function load(ObjectManager $manager)
    {
	    $this->manager = $manager;
		

		$rol = new Rol();
        $rol->setRolNombre('ROLE_ADMINISTRADOR');
		$manager->persist($rol);
		
		$usuario = new Usuario();
		$usuario->setUsuarioLogin('administrador');
		$usuario->setUsuarioNombre('Administrador');
		$usuario->setUsuarioEmail('jhair.escobar@toxty.co');
		$usuario->setUsuarioActivo(true);
		$usuario->setUsuarioFechamodificacion(new \DateTime());
		$encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
		$password = $encoder->encodePassword('temporal', $usuario->getSalt());
		$usuario->setPassword($password);
		$usuario->getUsuarioRoles()->add($rol);
		$manager->persist($usuario);
		$manager->flush();
		
		$usuario = new Usuario();
		$usuario->setUsuarioLogin('wiccano');
		$usuario->setUsuarioNombre('WiccanoGNU');
		$usuario->setUsuarioEmail('jhair.escobar@mct.com.co');
		$usuario->setUsuarioActivo(true);
		$usuario->setUsuarioFechamodificacion(new \DateTime());
		$encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
		$password = $encoder->encodePassword('temporal', $usuario->getSalt());
		$usuario->setPassword($password);
		$usuario->getUsuarioRoles()->add($rol);
		$manager->persist($usuario);
		$manager->flush();
		
		$usuario = new Usuario();
		$usuario->setUsuarioLogin('jhair.escobar');
		$usuario->setUsuarioNombre('Jhair Escobar');
		$usuario->setUsuarioEmail('peluk.development@gmail.com');
		$usuario->setUsuarioActivo(true);
		$usuario->setUsuarioFechamodificacion(new \DateTime());
		$encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
		$password = $encoder->encodePassword('temporal', $usuario->getSalt());
		$usuario->setPassword($password);
		$usuario->getUsuarioRoles()->add($rol);
		$manager->persist($usuario);
		$manager->flush();
		
		$contacto = new Contacto();
		$contacto->setContactoCodigo(1);
		$contacto->setContactoEmail('jhair.escobar@toxty.co');
		$contacto->setContactoInfo('Colombia\n+57 (310) 8749025\nBogotá - Colombia\nSur América');
		
		$manager->persist($contacto);
		$manager->flush();
		
		
		$menu = new Menu();
		$menu->setMenuCodigo(1);
		$menu->setMenuNombre('INICIO');
		
		$manager->persist($menu);
		$this->addReference('menu1', $menu);
		
		$menu = new Menu();
		$menu->setMenuCodigo(2);
		$menu->setMenuNombre('THE BOOK');
		
		$manager->persist($menu);
		$this->addReference('menu2', $menu);
		
		$menu = new Menu();
		$menu->setMenuCodigo(3);
		$menu->setMenuNombre('THE COOKBOOK');
		
		$manager->persist($menu);
		$this->addReference('menu3', $menu);
		
		$menu = new Menu();
		$menu->setMenuCodigo(4);
		$menu->setMenuNombre('THE COMPONENTS');
		
		$manager->persist($menu);
		$this->addReference('menu4', $menu);
		
		$categoria = new Categoria();
		$categoria->setCategoriaCodigo(1);
		$categoria->setCategoriaNombre('Presentación');
		$categoria->setCategoriaDescripcion('Presentación');
		$categoria->setMenuCodigo($manager->merge($this->getReference('menu1')));
		
		$manager->persist($categoria);
		$this->addReference('categoria_codigo1', $categoria);
		
		$categoria = new Categoria();
		$categoria->setCategoriaCodigo(2);
		$categoria->setCategoriaNombre('Objetivos');
		$categoria->setCategoriaDescripcion('Objetivos');
		$categoria->setMenuCodigo($manager->merge($this->getReference('menu1')));
		
		$manager->persist($categoria);
		$this->addReference('categoria_codigo2', $categoria);
		
		$categoria = new Categoria();
		$categoria->setCategoriaCodigo(3);
		$categoria->setCategoriaNombre('Metodología');
		$categoria->setCategoriaDescripcion('Metodología');
		$categoria->setMenuCodigo($manager->merge($this->getReference('menu1')));
		
		$manager->persist($categoria);
		$this->addReference('categoria_codigo3', $categoria);
		
		$manager->flush();
		
		$producto = new Producto();
		$producto->setProductoCodigo(1);
		$producto->setProductoNombre('Bienvenidos');
		$producto->setProductoDescripcion('Bienvenidos');
		$producto->setProductoFechacreacion(new \DateTime('2012-08-07'));
		$producto->setProductoFechamodificacion(new \DateTime('2011-08-07'));
		$producto->setCategoriaCodigo($manager->merge($this->getReference('categoria_codigo1')));
		
		$manager->persist($producto);
		
		$producto = new Producto();
		$producto->setProductoCodigo(2);
		$producto->setProductoNombre('¿Quien Soy?');
		$producto->setProductoDescripcion('¿Quien Soy?');
		$producto->setProductoFechacreacion(new \DateTime('2012-08-07'));
		$producto->setProductoFechamodificacion(new \DateTime('2011-08-07'));
		$producto->setCategoriaCodigo($manager->merge($this->getReference('categoria_codigo1')));
		
		$manager->persist($producto);
		
		$producto = new Producto();
		$producto->setProductoCodigo(2);
		$producto->setProductoNombre('Sobre este taller');
		$producto->setProductoDescripcion('Sobre este taller');
		$producto->setProductoFechacreacion(new \DateTime('2012-08-07'));
		$producto->setProductoFechamodificacion(new \DateTime('2011-08-07'));
		$producto->setCategoriaCodigo($manager->merge($this->getReference('categoria_codigo1')));

		$manager->persist($producto);
		
		$producto = new Producto();
		$producto->setProductoCodigo(3);
		$producto->setProductoNombre('Agradecimientos');
		$producto->setProductoDescripcion('Agradecimientos');
		$producto->setProductoFechacreacion(new \DateTime('2012-08-07'));
		$producto->setProductoFechamodificacion(new \DateTime('2011-08-07'));
		$producto->setCategoriaCodigo($manager->merge($this->getReference('categoria_codigo1')));
		
		$manager->persist($producto);
			
		$producto = new Producto();
		$producto->setProductoCodigo(5);
		$producto->setProductoNombre('Objetivos Generales');
		$producto->setProductoDescripcion('SEGUNDO PROYECTO');
		$producto->setProductoFechacreacion(new \DateTime('2012-08-07'));
		$producto->setProductoFechamodificacion(new \DateTime('2011-08-07'));
		$producto->setCategoriaCodigo($manager->merge($this->getReference('categoria_codigo2')));
		
		$manager->persist($producto);
		
		$producto = new Producto();
		$producto->setProductoCodigo(6);
		$producto->setProductoNombre('Objetivos Especificos');
		$producto->setProductoDescripcion('Objetivos Especificos');
		$producto->setProductoFechacreacion(new \DateTime('2012-08-07'));
		$producto->setProductoFechamodificacion(new \DateTime('2011-08-07'));
		$producto->setCategoriaCodigo($manager->merge($this->getReference('categoria_codigo2')));
		
		$manager->persist($producto);
		
		$producto = new Producto();
		$producto->setProductoCodigo(8);
		$producto->setProductoNombre('Teoria');
		$producto->setProductoDescripcion('Teoria');
		$producto->setProductoFechacreacion(new \DateTime('2012-08-07'));
		$producto->setProductoFechamodificacion(new \DateTime('2011-08-07'));
		$producto->setCategoriaCodigo($manager->merge($this->getReference('categoria_codigo3')));
		
		$manager->persist($producto);
		
		$producto = new Producto();
		$producto->setProductoCodigo(9);
		$producto->setProductoNombre('Práctica');
		$producto->setProductoDescripcion('Practica');
		$producto->setProductoFechacreacion(new \DateTime('2012-08-07'));
		$producto->setProductoFechamodificacion(new \DateTime('2011-08-07'));
		$producto->setCategoriaCodigo($manager->merge($this->getReference('categoria_codigo3')));
		
		$manager->persist($producto);
		$manager->flush();
		
		
		$introimagen = new Introimagen();
		$introimagen->setImagenCodigo(1);
		$introimagen->setImagen1Nombre('intro_left');
		$introimagen->setImagen1Titulo('intro_left');
		$introimagen->setImagen2Nombre('intro_up');
		$introimagen->setImagen2Titulo('intro_up');
		$introimagen->setImagen3Nombre('intro_down');
		$introimagen->setImagen3Titulo('intro_down');
		$manager->persist($introimagen);
		
		
		$introimagen = new Introimagen();
		$introimagen->setImagenCodigo(2);
		$introimagen->setImagen1Nombre('productointro_left');
		$introimagen->setImagen1Titulo('v de verde');
		$introimagen->setImagen2Nombre('productointro_up');
		$introimagen->setImagen2Titulo('jarrón bronce');
		$introimagen->setImagen3Nombre('productointro_down');
		$introimagen->setImagen3Titulo('from russia with love');
		$introimagen->setMenuCodigo($manager->merge($this->getReference('menu1')));
		$manager->persist($introimagen);
		
		
		$introimagen = new Introimagen();
		$introimagen->setImagenCodigo(3);
		$introimagen->setImagen1Nombre('espaciointro_left');
		$introimagen->setImagen1Titulo('espaciointro_left');
		$introimagen->setImagen2Nombre('espaciointro_up');
		$introimagen->setImagen2Titulo('espaciointro_up');
		$introimagen->setImagen3Nombre('espaciointro_down');
		$introimagen->setImagen3Titulo('espaciointro_down');
		$introimagen->setMenuCodigo($manager->merge($this->getReference('menu2')));
		$manager->persist($introimagen);
		
		
		$introimagen = new Introimagen();
		$introimagen->setImagenCodigo(4);
		$introimagen->setImagen1Nombre('mobiliariointro_left');
		$introimagen->setImagen1Titulo('mobiliariointro_left');
		$introimagen->setImagen2Nombre('mobiliariointro_up');
		$introimagen->setImagen2Titulo('mobiliariointro_up');
		$introimagen->setImagen3Nombre('mobiliariointro_down');
		$introimagen->setImagen3Titulo('mobiliariointro_down');
		$introimagen->setMenuCodigo($manager->merge($this->getReference('menu3')));
		$manager->persist($introimagen);
		
		
		$introimagen = new Introimagen();
		$introimagen->setImagenCodigo(5);
		$introimagen->setImagen1Nombre('prensaintro_left');
		$introimagen->setImagen1Titulo('prensaintro_left');
		$introimagen->setImagen2Nombre('prensaintro_up');
		$introimagen->setImagen2Titulo('prensaintro_up');
		$introimagen->setImagen3Nombre('prensaintro_down');
		$introimagen->setImagen3Titulo('prensaintro_down');
		$introimagen->setMenuCodigo($manager->merge($this->getReference('menu4')));
		$manager->persist($introimagen);
		
		
		$hojavida = new Hojavida();
		$hojavida->setHojavidaCodigo(1);
		$hojavida->setHojavidaNombre('sin archivo');
		$manager->persist($hojavida);
	
		$manager->flush();
		
	}
	
	public function getOrder()
    {
        return 1;
    }
}
