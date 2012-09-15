<?php

namespace Admin\DashboardBundle\Extension;

use PDO, Closure, Exception,
	Doctrine\DBAL\Connection;
	
class SwitransDbalExtension extends Connection
{

	/**
	* Prepares and executes an SQL query and returns the result as an associative array.
	*
	* @param string $sql The SQL query.
	* @param array $params The query parameters.
	* @return array
	*/
    public function fetchAllAssoc($sql, array $params = array())
    {
        $data = $this->executeQuery($sql, $params)->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC); 
        $data = array_map('reset', $data);

 	  	$assocData = array();
		foreach ($data as $position => $arValue) 
    	{
			foreach ($arValue as $value) 
    		{
				$assocData[$position] = $value; 
			}
		}
		return $assocData;
	}
}