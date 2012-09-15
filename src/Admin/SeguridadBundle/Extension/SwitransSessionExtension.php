<?php

namespace Admin\SeguridadBundle\Extension;
use Symfony\Component\HttpFoundation\SessionStorage\PdoSessionStorage,
	Symfony\Component\DependencyInjection\ContainerInterface,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\Security\Core\SecurityContextInterface,
	Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class SwitransSessionExtension extends PdoSessionStorage
{
	protected $request; 	
			
	private $db;
    private $dbOptions;	
	
	private $ip;
	private $user;
	

	public function __construct(Request $request, ContainerInterface $container, \PDO $db, array $options = array(), array $dbOptions = array())
    {
        if (!array_key_exists('db_table', $dbOptions)) {
            throw new \InvalidArgumentException('You must provide the "db_table" option for a PdoSessionStorage.');
        }
		$this->db = $db;
        $this->dbOptions = $dbOptions;
		$this->request = $request;
		
        $this->ip = $this->request->getClientIp();
        parent::__construct($db, $options, $dbOptions);
	}
	
	/*
	 * Funcion sessionWrite personalizada para Switrans2
	*/
	public function sessionWrite($id, $data)
    {
        // get table/column
        $dbTable   = $this->dbOptions['db_table'];
        $dbDataCol = $this->dbOptions['db_data_col'];
        $dbIdCol   = $this->dbOptions['db_id_col'];
        $dbTimeCol = $this->dbOptions['db_time_col'];
		$dbIpCol = $this->dbOptions['db_ip_col'];
		$dbUserCol = $this->dbOptions['db_user_col']; 
		
		$sql = ('mysql' === $this->db->getAttribute(\PDO::ATTR_DRIVER_NAME))
            ? "INSERT INTO $dbTable ($dbIdCol, $dbDataCol, $dbTimeCol, $dbUserCol, $dbIpCol) VALUES (:id, :data, :time, :user, :ip) "
              ."ON DUPLICATE KEY UPDATE $dbDataCol = VALUES($dbDataCol), $dbTimeCol = CASE WHEN $dbTimeCol = :time THEN (VALUES($dbTimeCol) + 1) ELSE VALUES($dbTimeCol) END"
            : "UPDATE $dbTable SET $dbDataCol = :data, $dbTimeCol = :time, $dbUserCol = :user, $dbIpCol = :ip WHERE $dbIdCol = :id";

        try {
            $encoded = base64_encode($data);
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, \PDO::PARAM_STR);
            $stmt->bindParam(':data', $encoded, \PDO::PARAM_STR);
            $stmt->bindValue(':time', time(), \PDO::PARAM_INT);			
			$stmt->bindValue(':user', $this->user, \PDO::PARAM_INT);
			$stmt->bindParam(':ip', $this->ip, \PDO::PARAM_STR);
            $stmt->execute();

            if (!$stmt->rowCount()) {
                $this->createNewSession($id, $data);
            }
        } catch (\PDOException $e) {
            throw new \RuntimeException(sprintf('PDOException was thrown when trying to manipulate session data: %s', $e->getMessage()), 0, $e);
        }

        return true;
    }

    /*
	 * Funcion createNewSession personalizada para Switrans2
	*/
    private function createNewSession($id, $data = '')
    {
        // get table/column
        $dbTable    = $this->dbOptions['db_table'];
        $dbDataCol = $this->dbOptions['db_data_col'];
        $dbIdCol   = $this->dbOptions['db_id_col'];
        $dbTimeCol = $this->dbOptions['db_time_col'];
		$dbIpCol = $this->dbOptions['db_ip_col'];
		$dbUserCol = $this->dbOptions['db_user_col']; 
		
        $sql = "INSERT INTO $dbTable ($dbIdCol, $dbDataCol, $dbTimeCol, $dbUserCol, $dbIpCol) VALUES (:id, :data, :time, :user, :ip)";
		
        $encoded = base64_encode($data);
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmt->bindParam(':data', $encoded, \PDO::PARAM_STR);
        $stmt->bindValue(':time', time(), \PDO::PARAM_INT);
		$stmt->bindValue(':user', $this->user, \PDO::PARAM_INT);
		$stmt->bindParam(':ip', $this->ip, \PDO::PARAM_STR);
        $stmt->execute();

        return true;
    }
}