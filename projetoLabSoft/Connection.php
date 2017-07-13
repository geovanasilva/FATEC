<?php
	class Connection
	{
		private $host;
		private $user;
		private $pass;
		private $dtbs;
		
		function __construct()
		{
			$this->host = "localhost";
			$this->user = "root";
			$this->pass = "root";
			$this->dtbs = "Hotel";
			
			/*$this->host = "localhost";
			$this->user = "marcelo_marcelo";
			$this->pass = "9969db2c";
			$this->dtbs = "marcelo_Hotel";*/
		}
		
		public function Connect()
		{
			$conn = mysqli_connect( $this->host, $this->user, $this->pass, $this->dtbs );
			
			return $conn;
		}
	}
?>