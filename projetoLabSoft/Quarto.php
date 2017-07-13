<?php
	class Quarto
	{		
		private $link;
		private $conn;
		
		function __construct( )
		{
			$this->link = new Connection( );
			
			$this->conn = $this->link->Connect();
		}
		
		function __destruct( )
		{
			mysqli_close( $this->conn );
			
			unset( $this->link );
		}
		
		public function CadastrarQuarto( $codigo, $status, $codTipo )
		{			
			if( $this->conn )
			{
				$status = mysqli_real_escape_string( $this->conn, $status );
				
				$sqlc = "INSERT INTO Quarto VALUES (".intval($codigo).", '$status', ".intval($codTipo).")";
								
				if( mysqli_query( $this->conn, $sqlc ) ) return 1;
				else return 0;
			}
			else return 0;
		}
		
		public function LerQuarto( $codigo = null, $status = null, $dispType = null )
		{
			if( $this->conn )
			{
				$sqlc = "SELECT Q.CD_Quarto, Q.DS_Status_Quarto, Q.CD_Tipo_Quarto, TQ.DS_Tipo_Quarto FROM Quarto Q 
						JOIN Tipo_Quarto TQ ON ( Q.CD_Tipo_Quarto = TQ.CD_Tipo_Quarto )";
								
				if( !empty( $codigo ) ) $sqlc .= " WHERE CD_Quarto = ".$codigo;
				if( !empty( $status ) ) $sqlc .= " WHERE DS_Status_Quarto = ".$status;
				if( !empty( $dispType ) ) $sqlc .= " WHERE Q.CD_Tipo_Quarto = ".$dispType." AND DS_Status_Quarto = 'Disponível'";
								
				if( $res = mysqli_query( $this->conn, $sqlc ) )
				{		
					if( mysqli_num_rows( $res ) > 0 )
					{
						$return = array();
						
						$count = 1;
						
						while( $row = mysqli_fetch_assoc( $res ) )
						{
							$return[$count] = array(
								'CD_Quarto' => $row['CD_Quarto'],
								'CD_Tipo_Quarto' => $row['CD_Tipo_Quarto'],
								'DS_Tipo_Quarto' => $row['DS_Tipo_Quarto'],
								'DS_Status_Quarto' => $row['DS_Status_Quarto']
							);
							
							$count++;
						}
						
						return $return;
					}
					else return 0;
				}
				else return 0;
			}
			else return 0;
		}
		
		public function AlterarQuarto( $codigo, $parameters )
		{
			if( $this->conn )
			{
				$sqlc = "UPDATE Quarto SET ";
								
				foreach( $parameters as $key => $value )
				{
					$parameters[$key] = mysqli_real_escape_string( $this->conn, $value );
					
					$sqlc .= $key."='".$value."',";
				}
					
				$sqlc = substr( $sqlc, 0, strlen( $sqlc ) - 1 );
				
				$sqlc .= " WHERE CD_Quarto = ".$codigo;
						
				if( mysqli_query( $this->conn, $sqlc ) )					
					return 1;
				else
					return 0;
			}
			else return 0;
		}

		public function ListAvailableTypes()
		{
			if( $this->conn )
			{
				$sqlc = "SELECT DISTINCT TQ.DS_Tipo_Quarto, TQ.CD_Tipo_Quarto FROM Quarto Q JOIN Tipo_Quarto TQ ON ( TQ.CD_Tipo_Quarto = Q.CD_Tipo_Quarto )
						 WHERE Q.DS_Status_Quarto = 'Disponível'"; // Lista todos os tipos de quarto disponível, sem repetição

				if( $res = mysqli_query( $this->conn, $sqlc) )
				{
					if( mysqli_num_rows( $res ) > 0 )
					{
						$return = array();

						$count = 1;

						while( $row = mysqli_fetch_assoc( $res ) )
						{
							$return[$count] = array(
								'CD_Tipo_Quarto' => $row['CD_Tipo_Quarto'],
								'DS_Tipo_Quarto' => $row['DS_Tipo_Quarto']
							);

							$count++;
						}

						return $return;
					}
					else return 0;
				}
				else return 0;
			}
			else return 0;
		}

		public function RemoverQuarto( $codigo )
		{
			if( $this->conn )
			{
				$sqlc = "DELETE FROM Quarto WHERE CD_Quarto = $codigo";

				if( mysqli_query( $this->conn, $sqlc ) ) 
					return 1;
				else 
					return 0;
			}
			else return 0;
		}
	}
?>