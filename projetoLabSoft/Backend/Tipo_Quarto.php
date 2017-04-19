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
				$sqlc = "INSERT INTO Tipo_Quarto VALUES (
					NULL, '".
					$desc."', ".
					$valor.", ".
					$qtdp."
				)";
				
				if( mysqli_query( $this->conn, $sqlc ) ) return 1;
				else return 0;
			}
			else return 0;
		}
		
		public function LerTipoQuarto( $codigo = null )
		{
			if( $this->conn )
			{
				
			}
			else return 0;
		}
		
		public function AlterarTipoQuarto( )
		{
			if( $this->conn )
			{
				
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