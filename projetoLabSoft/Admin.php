<?php	
	$host = "localhost";
	$user = "marcelo_marcelo";
	$pass = "9969db2c";

	$conn = mysqli_connect($host, $user, $pass);
	
	if( !$conn ) echo mysqli_error( $conn );
	
	$dtbs = "marcelo_Hotel";
	
	$sqlc = "CREATE DATABASE IF NOT EXISTS ".$dtbs;
					
	if( mysqli_query( $conn, $sqlc ) ) echo "<p>Database ".$dtbs." foi criada com sucesso ou já existia</p><br>";
	else echo mysqli_error( $conn );
	
	if( mysqli_select_db( $conn, $dtbs ) ) echo "<p>Database ".$dtbs." foi selecionado com sucesso</p><br>";
	else echo mysqli_error( $conn );
	
	$sqlc = "CREATE TABLE Usuario(CD_Usuario INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
								  NM_Usuario VARCHAR(50) NOT NULL,
								  PW_Usuario VARCHAR(50) NOT NULL,
								  DS_Acesso_Usuario VARCHAR(15) NOT NULL,
								  DS_Email_Usuario VARCHAR(50) UNIQUE NOT NULL,
								  SG_Sexo CHAR(1),
								  DS_CPF VARCHAR(14) UNIQUE,
								  DS_RG VARCHAR(12) UNIQUE,
								  DS_Telefone VARCHAR(20),
								  BL_Ativo TINYINT(1)
	)";
	
	if( mysqli_query( $conn, $sqlc ) ) echo "<p> Tabela Usuario foi criada com sucesso </p><br>";
	else echo mysqli_error( $conn );
	
	$sqlc = "CREATE TABLE Tipo_Quarto(CD_Tipo_Quarto INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
									  DS_Tipo_Quarto VARCHAR(30) NOT NULL,
									  VL_Tipo_Quarto DOUBLE(8, 2) NOT NULL,
									  QT_Max_Pessoas_Quarto INTEGER
	)";
	
	if( mysqli_query( $conn, $sqlc ) ) echo "<p> Tabela Tipo_Quarto foi criada com sucesso </p><br>";
	else echo mysqli_error( $conn );
	
	$sqlc = "CREATE TABLE Reserva(CD_Reserva INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
								  DT_Entrada_Reserva DATE NOT NULL,
								  DT_Saida_Reserva DATE NOT NULL,
								  CD_Usuario INTEGER UNSIGNED NOT NULL,
								  FOREIGN KEY(CD_Usuario) REFERENCES Usuario(CD_Usuario)
	)";
	
	if( mysqli_query( $conn, $sqlc ) ) echo "<p> Tabela Reserva foi criada com sucesso </p><br>";
	else echo mysqli_error( $conn );
	
	$sqlc = "CREATE TABLE Tipo_Reserva(CD_Tipo_Reserva INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
									   CD_Tipo_Quarto INTEGER UNSIGNED NOT NULL,
									   CD_Reserva INTEGER UNSIGNED NOT NULL,
									   CD_Quarto INTEGER UNSIGNED NOT NULL,
									   VL_Reserva DOUBLE(8, 2) NOT NULL,
									   FOREIGN KEY(CD_Reserva) REFERENCES Reserva(CD_Reserva),
									   FOREIGN KEY(CD_Tipo_Quarto) REFERENCES Tipo_Quarto(CD_Tipo_Quarto),
									   FOREIGN KEY(CD_Quarto) REFERENCES Quarto(CD_Quarto)
	)";
	
	if( mysqli_query( $conn, $sqlc ) ) echo "<p> Tabela Tipo_Reserva foi criada com sucesso </p><br>";
	else echo mysqli_error( $conn );
	
	$sqlc = "CREATE TABLE Quarto(CD_Quarto INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
								 DS_Status_Quarto VARCHAR(20) NOT NULL,
								 CD_Tipo_Quarto INTEGER UNSIGNED NOT NULL,
								 FOREIGN KEY(CD_Tipo_Quarto) REFERENCES Tipo_Quarto(CD_Tipo_Quarto)
	)";
	
	if( mysqli_query( $conn, $sqlc ) ) echo "<p> Tabela Quarto foi criada com sucesso </p><br>";
	else echo mysqli_error( $conn );
	
	$sqlc = "CREATE TABLE Hospedagem(CD_Hospedagem INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
									 CD_Reserva INTEGER UNSIGNED NOT NULL,
									 DT_Entrada_Hospedagem DATE NOT NULL,
									 DT_Saida_Hospedagem DATE NOT NULL,
									 VL_Total_Hospedagem DOUBLE(8, 2),
									 FOREIGN KEY(CD_Reserva) REFERENCES Reserva(CD_Reserva)
	)";
	
	if( mysqli_query( $conn, $sqlc ) ) echo "<p> Tabela Hospedagem foi criada com sucesso </p><br>";
	else echo mysqli_error( $conn );
	
	$sqlc = "INSERT INTO Usuario VALUES (NULL, 'Administrador', 'admin', 'Admin', 'admin@admin.com.br', 'M', '1234567893', '403782023', '34938215', 1 )";
	
	if( mysqli_query( $conn, $sqlc ) ) echo "<p> Usuario administrador criado com sucesso </p><br>";
	else echo mysqli_error( $conn );
?>