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
	}
?>