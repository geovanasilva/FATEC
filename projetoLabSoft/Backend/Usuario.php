<?php
	require 'Connection.php';

	class Usuario
	{
		private $nome;
		private $senha;
		private $acesso;
		private $email;
		
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
				$sqlc = "SELECT CD_Usuario, NM_Usuario, DS_Acesso_Usuario
						 FROM Usuario
						 WHERE DS_Email_Usuario = '".$email."' AND
						       PW_User = '".$password."'";
				
				$res = mysqli_query( $this->conn, $sqlc );
				
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
		
		public function HasAccess( $user, $crud_level )
		{
			
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
				$sqlc = "INSERT INTO Usuario VALUES(
					NULL, '".
					$nome."', '".
					$senha."', '".
					$acesso."', '".
					$email."'
				)";
				
				if( mysqli_query( $this->conn, $sqlc ) ) return 1;
				else return 0;
			}
			else return 0;
		}
		
		public function LerUsuario( $todos = false, $codigo = null )
		{
			if( $this->conn )
			{
				$sqlc = "SELECT * FROM Usuario WHERE ";
				
				if( !empty( $codigo ) ) $sqlc .= "CD_Usuario = ".$codigo;
				else $sqlc .= "DS_Email_Usuario = '".$email."'";
				
				$res = mysqli_query( $this->conn, $sqlc );
				
				if( mysqli_num_rows( $res ) > 0 ) return mysqli_fetch_assoc( $res );
				else return 0;
			}
			else return 0;
		}
		
		public function AlterarUsuario( )
		{
			if( $this->conn )
			{
				
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
	}
?>