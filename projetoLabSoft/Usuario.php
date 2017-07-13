<?php
	class Usuario
	{		
		private $conn;
		private $link;
		
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
		
		public function Login( $email, $password )
		{
			if( $this->conn )
			{
				$email = mysqli_real_escape_string( $this->conn, $email );
				$password = mysqli_real_escape_string( $this->conn, $password );
				
				$sqlc = "SELECT CD_Usuario, NM_Usuario, DS_Acesso_Usuario
						 FROM Usuario
						 WHERE DS_Email_Usuario = '".$email."' AND
						       PW_Usuario = '".$password."'";
				
				if( $res = mysqli_query( $this->conn, $sqlc ) )
				{				
					if( mysqli_num_rows( $res ) > 0 )
					{
						$rows = mysqli_fetch_assoc( $res );
						
						$_SESSION['codigo'] = $rows['CD_Usuario'];
						$_SESSION['usuario'] = $rows['NM_Usuario'];
						$_SESSION['acesso'] = $rows['DS_Acesso_Usuario'];
						
						return 1;
					}
					else return 0;
				}
				else return 0;
			}
			else return 0;
		}
		
		public function Logout( )
		{
			if( isset( $_SESSION['usuario'] ) )
			{
				unset( $_SESSION['codigo'] );
				unset( $_SESSION['usuario'] );
				unset( $_SESSION['acesso'] );
				
				return 1;
			}
			else return 0;
		}
		
		public function getAccess()
		{
			return isset($_SESSION['acesso']) ? $_SESSION['acesso'] : "Offline";
		}
		
		public function ResetarSenha( $email )
		{
			$user = LerUsuario( $email );
			
			if( $user )
			{				
				$user['PW_User'] = CreateNewPassword(9, false, 'luds');
				
				$message = "Olá, foi solicidada uma alteração de senha na data seguinte data/hora ".date( "Y-m-d H:i:s" );
				$message .= "\nO IP solicitador foi: ".$_SERVER['REMOTE_ADDR'];
				$message .= "\nSua nova senha é: ".$newPass;
				$message .= "\nSe não foi você que solicitou, acesse o site e muda sua senha utilizando a nova";
				
				mail( $email, "Mudança de Senha", $message );
				
				AlterarUsuario( $user );
				
				return 1;
			}
			else
				return 0; // No user
		}
		
		public function CadastrarUsuario( $nome, $senha, $acesso, $email )
		{
			if( $this->conn )
			{
				$nome = mysqli_real_escape_string( $this->conn, $nome );
				$senha = mysqli_real_escape_string( $this->conn, $senha );
				$acesso = mysqli_real_escape_string( $this->conn, $acesso );
				$email = mysqli_real_escape_string( $this->conn, $email );
				
				$sqlc = "INSERT INTO Usuario VALUES
				(
					NULL, '".
					$nome."', '".
					$senha."', '".
					$acesso."', '".
					$email."', 
					NULL, 
					NULL, 
					NULL, 
					NULL, 
					1)";
				
				if( mysqli_query( $this->conn, $sqlc ) ) return 1;
				else return 0;
			}
			else return 0;
		}

		public function CadastrarUsuarioAdv( $nome, $senha, $acesso, $email, $cpf, $status)
		{
			if( $this->conn )
			{
				$nome = mysqli_real_escape_string( $this->conn, $nome );
				$senha = mysqli_real_escape_string( $this->conn, $senha );
				$acesso = mysqli_real_escape_string( $this->conn, $acesso );
				$email = mysqli_real_escape_string( $this->conn, $email );
				$cpf = mysqli_real_escape_string( $this->conn, $cpf );
				$status = mysqli_real_escape_string( $this->conn, $status );

				$sqlc = "INSERT INTO Usuario VALUES
				(NULL, '$nome', '$senha', '$acesso', '$email', NULL, '$cpf', NULL, NULL,".intval($status).")";

				if( mysqli_query( $this->conn, $sqlc ) ) return 1;
				else return 0;
			}
			else
				return 0;
		}
		
		public function LerUsuario( $todos = false, $codigo = null, $email = null, $ativo = null )
		{
			if( $this->conn )
			{
				$sqlc = "SELECT * FROM Usuario";
								
				if( !empty( $codigo ) ) $sqlc .= " WHERE CD_Usuario = ".$codigo;
				else if( !empty( $email ) ) $sqlc .= " WHERE DS_Email_Usuario = '".$email."'";
				else if( !empty( $ativo ) ) $sqlc .= " WHERE BL_Ativo = ".$ativo;
								
				if( $res = mysqli_query( $this->conn, $sqlc ) )
				{			
					if( mysqli_num_rows( $res ) > 0 )
					{
						$return = array();

						$count = 1;

						while( $row = mysqli_fetch_assoc( $res ) )
						{
							$return[$count] = array(
								'CD_Usuario' => $row['CD_Usuario'],
								'NM_Usuario' => $row['NM_Usuario'],
								'PW_Usuario' => $row['PW_Usuario'],
								'DS_Acesso_Usuario' => $row['DS_Acesso_Usuario'],
								'DS_Email_Usuario' => $row['DS_Email_Usuario'],
								'SG_Sexo' => $row['SG_Sexo'],
								'DS_CPF' => $row['DS_CPF'],
								'DS_RG' => $row['DS_RG'],
								'DS_Telefone' => $row['DS_Telefone'],
								'BL_Ativo' => $row['BL_Ativo']
							);
							
							$count++;
						}
						
						return $return;
					}
				}
				else 
					return 0;
			}
			else return 0;
		}
		
		public function AlterarUsuario( $codigo, $parameters )
		{
			if( $this->conn )
			{
				$sqlc = "UPDATE Usuario SET ";
								
				foreach( $parameters as $key => $value )
				{
					$parameters[$key] = mysqli_real_escape_string( $this->conn, $value );
					
					$sqlc .= $key."='".$value."',";
				}
					
				$sqlc = substr( $sqlc, 0, strlen( $sqlc ) - 1 );
				
				$sqlc .= " WHERE CD_Usuario = ".$codigo;
						
				if( mysqli_query( $this->conn, $sqlc ) )
				{
					if( array_key_exists('NM_Usuario', $parameters ) )
						$_SESSION['usuario'] = $parameters['NM_Usuario'];
					
					return 1;
				}
				else
					return 0;
			}
			else return 0;
		}
		
		public function RemoverUsuario( $codigo )
		{
			if( $this->conn )
			{
				$sqlc = "DELETE FROM Usuario WHERE CD_Usuario = ".$codigo;
				
				if( mysqli_query( $this->conn, $sqlc ) ) return 1;
				else return 0;
			}
			else return 0;
		}
		
		private function CreateNewPassword($length = 9, $add_dashes = false, $available_sets = 'luds')
		{
			$sets = array();
			
			if(strpos($available_sets, 'l') !== false)
				$sets[] = 'abcdefghjkmnpqrstuvwxyz';
			
			if(strpos($available_sets, 'u') !== false)
				$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
			
			if(strpos($available_sets, 'd') !== false)
				$sets[] = '23456789';
			
			if(strpos($available_sets, 's') !== false)
				$sets[] = '!@#$%&*?';
			
			$all = '';
			$password = '';
			
			foreach($sets as $set)
			{
				$password .= $set[array_rand(str_split($set))];
				$all .= $set;
			}
			
			$all = str_split($all);
			
			for($i = 0; $i < $length - count($sets); $i++)
				$password .= $all[array_rand($all)];
			
			$password = str_shuffle($password);
			
			if(!$add_dashes)
				return $password;
			
			$dash_len = floor(sqrt($length));
			$dash_str = '';
			
			while(strlen($password) > $dash_len)
			{
				$dash_str .= substr($password, 0, $dash_len) . '-';
				$password = substr($password, $dash_len);
			}
			
			$dash_str .= $password;
			
			return $dash_str;
		}
		
		function ValidarCPF($cpf)
		{
			$cpf = preg_replace('/[^0-9]/', '', (string) $cpf); // Remove all characters
			
			if (strlen($cpf) != 11) // Make sure the amount of numbers is right
				return false;
			
			$invalid = array('00000000000', '11111111111', '22222222222', '33333333333', '44444444444',
							   '55555555555', '66666666666', '77777777777', '88888888888', '99999999999'); // Invalid numbers
			
			if (in_array($cpf, $invalid)) // If it is equal to one of them, it is not valid
				return false;
			
			for ($i = 0, $j = 10, $sum = 0; $i < 9; $i++, $j--) // Using CPF rules - $cpf[0] * 10, $cpf[1] * 9 and so on
				$sum += $cpf{$i} * $j; // we need to store the sum
			
			$rest = $sum % 11; // Take only the rest
			
			if ($cpf{9} != ($rest < 2 ? 0 : 11 - $rest))
				return false;
			
			for ($i = 0, $j = 11, $sum = 0; $i < 10; $i++, $j--) // Using CPF rules - $cpf[0] * 11, $cpf[1] * 10 and so on
				$sum += $cpf{$i} * $j;  // we need to store the sum
			
			$rest = $sum % 11; // Take only the rest
			
			return $cpf{10} == ($rest < 2 ? 0 : 11 - $rest); // Return true if equal
		}
	}
?>