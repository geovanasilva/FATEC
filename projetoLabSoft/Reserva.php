<?php
    class Reserva
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

        public function CadastrarReserva( $usuario, $entrada, $saida, $quartos, $vlReserva, $status )
        {
            if( $this->conn )
            {
                $sqlc = "INSERT INTO Reserva VALUES ( NULL, '$entrada', '$saida', $usuario, '$status' )";

                if( mysqli_query( $this->conn, $sqlc ) )
                {
                    $codReserva = mysqli_insert_id( $this->conn );

                    foreach( $quartos as $codQuarto => $codTipo )
                    {
                        $sqlc = "INSERT INTO Tipo_Reserva VALUES ( NULL, $codTipo, $codReserva, $codQuarto, $vlReserva ) ";

                        if( !mysqli_query( $this->conn, $sqlc ) )
                        {
                            $sqlc = "DELETE FROM Reserva WHERE CD_Reserva = $codReserva";

                            mysqli_query( $this->conn, $sqlc );

                            return 0;
                        }
                    }

                    return 1;
                }
                else return 0;
            }
            else return 0;
        }

        public function LerReserva( $codReserva = null, $codUsuario = null )
        {
            if( $this->conn )
            {
                $sqlc = "SELECT * FROM Reserva";

                if( !empty( $codReserva ) ) $sqlc .= " WHERE CD_Reserva = $codReserva";
                if( !empty( $codUsuario ) ) $sqlc .= " WHERE CD_Usuario = $codUsuario";

                if( $res = mysqli_query( $this->conn, $sqlc ) )
                {
                    if( mysqli_num_rows( $res ) > 0 )
                    {
                        $return = array();

                        $count = 1;

                        while( $row = mysqli_fetch_assoc( $res ) )
                        {
                            $return[$count] = array(
                                'CD_Reserva' => $row['CD_Reserva'],
                                'DT_Entrada_Reserva' => $row['DT_Entrada_Reserva'],
                                'DT_Saida_Reserva' => $row['DT_Saida_Reserva'],
                                'CD_Usuario' => $row['CD_Usuario'],
                                'DS_Status_Reserva' => $row['DS_Status_Reserva'],
                                'CD_Tipo_Reserva' => null
                            );

                            $count++;
                        }

                        mysqli_free_result( $res );

                        $row = NULL;

                        $count = 0;

                        foreach( $return as $key => $value )
                        {
                            $sqlc = "SELECT TR.CD_Tipo_Reserva, TR.CD_Tipo_Quarto, TR.CD_Reserva, TR.CD_Quarto,
                            TR.VL_Reserva, TQ.DS_Tipo_Quarto FROM Tipo_Reserva TR JOIN Tipo_Quarto TQ 
                            ON( TQ.CD_Tipo_Quarto = TR.CD_Tipo_Quarto ) WHERE CD_Reserva = ".$value['CD_Reserva'];

                            if( $res = mysqli_query( $this->conn, $sqlc ) )
                            {
                                if( mysqli_num_rows( $res ) > 0 )
                                {
                                    $count = 1;

                                    while( $row = mysqli_fetch_assoc( $res ) )
                                    {                                        
                                        $return[$key]['CD_Tipo_Reserva'] = array(
                                                $count => array(
                                                    'CD_Tipo_Reserva' => $row['CD_Tipo_Reserva'],
                                                    'CD_Tipo_Quarto' => $row['CD_Tipo_Quarto'],
                                                    'CD_Quarto' => $row['CD_Quarto'],
                                                    'CD_Reserva' => $row['CD_Reserva'],
                                                    'VL_Reserva' => $row['VL_Reserva'],
                                                    'DS_Tipo_Quarto' => $row['DS_Tipo_Quarto']
                                                )
                                            );

                                        $count++;
                                    }
                                }
                                else return 0;
                            }
                            else return 0;
                        }
                        return $return;
                    }
                    else return 0;
                }
                else return 0;
            }
            else return 0;
        }

        public function AlterarReserva( $codigo, $parameters )
        {
            if( $this->conn )
			{
				$sqlc = "UPDATE Reserva SET ";
								
				foreach( $parameters as $key => $value )
				{
					$parameters[$key] = mysqli_real_escape_string( $this->conn, $value );
					
					$sqlc .= $key."='".$value."',";
				}
					
				$sqlc = substr( $sqlc, 0, strlen( $sqlc ) - 1 );
				
				$sqlc .= " WHERE CD_Reserva = ".$codigo;
						
				if( mysqli_query( $this->conn, $sqlc ) )					
					return 1;
				else
					return 0;
			}
			else return 0;
        }

        public function DeletarReserva( $codigo )
        {
            if( $this->conn )
            {
                $sqlc = "SELECT CD_Quarto FROM Tipo_Reserva WHERE CD_Reserva = $codigo";

                if( $res = mysqli_query( $this->conn, $sqlc ) )
                {
                    if( mysqli_num_rows( $res ) > 0 )
                    {
                        while( $row = mysqli_fetch_assoc( $res ) )
                        {
                            $sqlc = "UPDATE Quarto SET DS_Status_Quarto = 'Disponível' WHERE CD_Quarto = ".$row['CD_Quarto'];

                            if( !mysqli_query( $this->conn, $sqlc ) )
                                return 0;
                        }

                        $sqlc = "DELETE FROM Tipo_Reserva WHERE CD_Reserva = $codigo";

                        if( mysqli_query( $this->conn, $sqlc ) )
                        {
                            $sqlc = "DELETE FROM Reserva WHERE CD_Reserva = $codigo";

                            if( mysqli_query( $this->conn, $sqlc ) )
                                return 1;
                            else
                                return 0;
                        }
                        else return 0;
                    }
                }
            }
            else
                return 0;
        }
    }
?>