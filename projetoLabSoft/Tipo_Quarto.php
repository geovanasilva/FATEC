<?php
	class Tipo_Quarto
	{
		/*private $descricao;
		private $valor;
		private $qtd_pessoas;*/	
		
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
		
		public function CadastrarTipoQuarto( $desc, $valor, $qtdp )
		{			
			if( $this->conn )
			{
				$desc = mysqli_real_escape_string( $this->conn, $desc );
				
				$sqlc = "INSERT INTO Tipo_Quarto VALUES (
					NULL, '".
					$desc."', ".
					floatval($valor).", ".
					intval($qtdp)."
				)";
				
				echo "<h1> $sqlc </h1>";
				
				if( mysqli_query( $this->conn, $sqlc ) ) return 1;
				else return 0;
			}
			else return 0;
		}
		
		public function LerTipoQuarto( $todos = false, $codigo = null )
		{
			if( $this->conn )
			{
				$sqlc = "SELECT * FROM Tipo_Quarto";
								
				if( !empty( $codigo ) ) $sqlc .= " WHERE CD_Tipo_Quarto = ".$codigo;
								
				if( $res = mysqli_query( $this->conn, $sqlc ) )
				{		
					if( mysqli_num_rows($res) > 0 )
					{
						$return = array();
						
						$count = 1;
						
						while( $row = mysqli_fetch_assoc($res) )
						{
							$return[$count] = array(
								'CD_Tipo_Quarto' => $row['CD_Tipo_Quarto'],
								'DS_Tipo_Quarto' => $row['DS_Tipo_Quarto'],
								'VL_Tipo_Quarto' => $row['VL_Tipo_Quarto'],
								'QT_Max_Pessoas_Quarto' => $row['QT_Max_Pessoas_Quarto']
							);
							
							$count++;
						}
						
						return $return;
					}
					else return 0;
				}
				else 
					return 0;
			}
			else return 0;
		}
		
		public function AlterarTipoQuarto( $codigo, $parameters )
		{
			if( $this->conn )
			{
				$sqlc = "UPDATE Tipo_Quarto SET ";
								
				foreach( $parameters as $key => $value )
				{
					$parameters[$key] = mysqli_real_escape_string( $this->conn, $value );
					
					$sqlc .= $key."='".$value."',";
				}
					
				$sqlc = substr( $sqlc, 0, strlen( $sqlc ) - 1 );
				
				$sqlc .= " WHERE CD_Tipo_Quarto = ".$codigo;
						
				if( mysqli_query( $this->conn, $sqlc ) )					
					return 1;
				else
					return 0;
			}
			else return 0;
		}
		
		public function RemoverTipoQuarto( $codigo )
		{
			if( $this->conn )
			{
				$sqlc = "DELETE FROM Tipo_Quarto WHERE CD_Tipo_Quarto = ".$codigo;
				
				if( mysqli_query( $this->conn, $sqlc ) ) return 1;
				else return 0;
			}
			else return 0;
		}
	}
?>