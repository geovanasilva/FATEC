<html>
    <head>
        <title> Teste </title>
    </head>
    <body>
        <?php
            session_start();

            require 'Connection.php';
            require 'Usuario.php';
            require 'Tipo_Quarto.php';
            require 'Quarto.php';
            require 'Reserva.php';

            $usuario = new Usuario();
            $tipo = new Tipo_Quarto();
            $quarto = new Quarto();
            $reserva = new Reserva();

            echo "<h1> Inicio da página </h1>";

           //$quartos = $quarto->ListAvailableTypes();

            //echo var_dump($quartos);

            //$reservas = $reserva->LerReserva(null, 7);

            $reservas = $reserva->LerReserva();

            var_dump($reservas);

          /* $conn = mysqli_connect('localhost', 'marcelo_marcelo', '9969db2c', 'marcelo_Hotel');

            $return = null;

            if( $conn )
            {
                $sqlc = "SELECT * FROM Reserva WHERE CD_Reserva >= 10";

                if( $res = mysqli_query( $conn, $sqlc ) )
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
                                'CD_Usuario' => $row['CD_Usuario']
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

                            if( $res = mysqli_query( $conn, $sqlc ) )
                            {
                                if( mysqli_num_rows( $res ) > 0 )
                                {
                                    $count = 1;

                                    while( $row = mysqli_fetch_assoc( $res ) )
                                    {                                        
                                        $return[$key] += array(
                                            'CD_Tipo_Reserva' => array( 
                                                $count => array(
                                                    'CD_Tipo_Reserva' => $row['CD_Tipo_Reserva'],
                                                    'CD_Tipo_Quarto' => $row['CD_Tipo_Quarto'],
                                                    'CD_Quarto' => $row['CD_Quarto'],
                                                    'CD_Reserva' => $row['CD_Reserva'],
                                                    'VL_Reserva' => $row['VL_Reserva'],
                                                    'DS_Tipo_Quarto' => $row['DS_Tipo_Quarto']
                                                )
                                            )
                                        );

                                        $count++;
                                    }
                                }
                                else echo mysqli_error( $conn );
                            }
                            else echo mysqli_error( $conn );
                        }
                    }
                    else echo mysqli_error( $conn );
                }
                else echo mysqli_error( $conn );
            }
            else echo mysqli_error( $conn );

            var_Dump($return);*/

            echo "<h1> Fim da página </h1>";
        ?>
    </body>
</html>