<?php
	require 'Connection.php';
	require 'Usuario.php';
	require 'Tipo_Quarto.php';
	require 'Quarto.php';
	require 'Reserva.php';
	
	$user = new Usuario();
	$tipo = new Tipo_Quarto();
	$quarto = new Quarto();
	$reserva = new Reserva();
	
	if( array_key_exists( 'codUsuario', $_GET ) )
	{
		$codigo = $_GET['codUsuario'];

		if( is_numeric( $codigo ) && intval( $codigo ) > 0 )
		{
			$res = $user->LerUsuario( false, $codigo );

			$saida = $codigo."*".$res[1]['NM_Usuario']."*".$res[1]['DS_CPF']."*".$res[1]['DS_Email_Usuario']."*".$res[1]['BL_Ativo'];
		}
		else $saida = "NULL*NULL*NULL*NULL*NULL*NULL";

		echo $saida;
	}

	if( array_key_exists( 'codigo', $_GET ) )
	{
		$codigo = $_GET['codigo'];
				
		if( is_numeric( $codigo ) && intval( $codigo ) > 0 )
		{
			$res = $tipo->LerTipoQuarto(false, $codigo);
						
			$saida = $codigo."*".$res[1]['DS_Tipo_Quarto']."*".$res[1]['VL_Tipo_Quarto']."*".$res[1]['QT_Max_Pessoas_Quarto'];
		}
		else $saida = "0*NULL*NULL*NULL";
		
		echo $saida;
	}
	
	if( array_key_exists( 'codQuartoEdit', $_GET ) )
	{
		$codigo = $_GET['codQuartoEdit'];
		
		if( is_numeric( $codigo ) && intval( $codigo ) > 0 )	
		{
			$res = $quarto->LerQuarto( $codigo, null, null );

			$tipos = $tipo->LerTipoQuarto( NULL, NULL );

			$index = -1;

			foreach( $tipos as $key => $value )
			{
				if( $value['DS_Tipo_Quarto'] == $res[1]['DS_Tipo_Quarto'] )
				{
					$index = $key - 1;

					break;
				}
			}
			
			$saida = $codigo."*".$res[1]['CD_Tipo_Quarto']."*".$res[1]['DS_Tipo_Quarto']."*".$res[1]['DS_Status_Quarto']."*".$index;
		}
		else $saida = "0*NULL*NULL*NULL";
		
		echo $saida;
	}

	if( array_key_exists( 'codReservaEdit', $_GET ) )
	{
		$codigo = $_GET['codReservaEdit'];

		if( is_numeric( $codigo ) && intval( $codigo ) > 0 )
		{
			$res = $reserva->LerReserva( $codigo, null );

			$saida = $codigo."*".$res[1]['DT_Entrada_Reserva']."*".$res[1]['DT_Saida_Reserva']."*".$res[1]['DS_Status_Reserva'];
		}
		else $saida="0*NULL*NULL*NULL";

		echo $saida;
	}
?>