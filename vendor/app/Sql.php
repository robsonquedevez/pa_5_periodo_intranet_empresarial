<?php

	namespace app;

	use \PDO;

	class Sql extends PDO
	{
		private $instPDO = null;
		
		function __construct()
		{
			$opt = [ 
                    PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
                ];

			if($this->instPDO == null){
				$this->instPDO = new PDO('mysql:dbname=db_intranet;host=localhost', 'root', '', $opt);			
			}
		}

		public function getConnection()
		{
			return $this->instPDO;
		}

		private function setParams($statement, $parameters = array())
		{
	
			foreach ($parameters as $key => $value) {
				
				$this->bindParam($statement, $key, $value);
	
			}
	
		}
	
		private function bindParam($statement, $key, $value)
		{
	
			$statement->bindParam($key, $value);
	
		}
	
		public function query($rawQuery, $params = array())
		{
	
			$stmt = $this->instPDO->prepare($rawQuery);
	
			$this->setParams($stmt, $params);
	
			$stmt->execute();
	
		}
	
		public function select($rawQuery, $params = array()):array
		{
	
			$stmt = $this->instPDO->prepare($rawQuery);
	
			$this->setParams($stmt, $params);
	
			$stmt->execute();
	
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	
		}
	}
?>