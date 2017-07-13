<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="hotel, bed and breakfast, accommodations, travel">
		<meta name="description" content="Echo Hotel">
		<meta name="author" content="Geovana Silva">
		<title>Echo Hotel</title>
		<link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
		<!-- Bootstrap Core + plugin CSS -->
		<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="assets/magnific-popup/magnific-popup.css" rel="stylesheet">
		<!-- Custom Fonts -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
		<!-- Theme CSS -->
		<link href="assets/css/main-singlepage.css" rel="stylesheet">
		<link href="assets/css/jquery-ui.css" rel="stylesheet">
	</head>
	<body>
		<?php
			session_start();
			
			require 'Connection.php';
			require 'Usuario.php';
			
			//echo var_dump( $_POST );
			//echo var_dump( $_REQUEST );
			//echo var_dump( $_GET );
									
			if( array_key_exists('login-submit', $_POST ) )
			{			
				$username = $_POST['username'];
				$password = $_POST['password'];
										
				$user = new Usuario();
				
				$headerLoc = 'Location: http://marcelo.outroll.com/';
				
				if( $user->Login( $username, $password ) == 1 )
				{
					$access = $user->getAccess();
					
					if( $access == 'Admin') $headerLoc .= 'index-admin.php';
					else if( $access == 'Usuario') $headerLoc .= 'index-user.php';
				}
				else
					$headerLoc .= 'index.php';
					
				header( $headerLoc );
			}

			if( isset( $_POST['register-submit'] ) )
			{
				$username = $_POST['username'];
				$password = $_POST['password'];
				$confirm = $_POST['confirm-password'];
				$email = $_POST['email'];

				if( !empty($username) && strlen($username) <= 50 )
				{
					if( !empty($password) && strlen($password) <= 50 && $password == $confirm )
					{
						if( !empty($email) && filter_var( $email, FILTER_VALIDATE_EMAIL ) && strlen($email) <= 50 )
						{
							$user = new Usuario();
					
							$acesso = 'Usuario';
					
							$headerLoc = 'Location: http://marcelo.outroll.com/';
					
							if( $user->CadastrarUsuario( $username, $password, $acesso, $email ) == 1 )
							{
								if( $user->Login( $email, $password ) == 1)
									$headerLoc .= 'index-user.php';
								else
									$headerLoc .= 'index.php';
							}
							else
								$headerLoc .= 'index.php?username='.$username.'&email='.$email.'&sent=enviado';
					
							header( $headerLoc );
						}
						// else invalid email 
					}
					// else invalid password or confirm-password
				}
				// else invalid e-mail
			}

			if( array_key_exists( $_POST, 'suggestions-submit'))
			{
				$name = $_POST['name'];
				$email = $_POST['email'];
				$phone = $_POST['phone'];
				$subject = $_POST['subject']; //subject(elogios, sugestoes, outros)
				$message = $_POST['message'];

				if( !empty($name) && strlen($name) <= 30 && preg_match("/^[a-zA-Z ]*$/", $name) )
				{
					if( filter_var( $email, FILTER_VALIDATE_EMAIL ) )
					{
						if( !empty($phone) && strlen($phone) >= 14 && strlen($phone) <= 18 )
						{
							if( !empty($message) && strlen($message) <= 240 )
							{
								$mailTo = "mhenrique1970@hotmail.com";

								$newMessage = "E-mail sent automatically by Echo Hotel System\r\n";

								$newMessage .= $message;

								$newMessage = wordwrap($newMessage, 70, "\r\n");

								$headers = "From: $email \r\nTo: $mailTo";

								mail($mailTo, $subject, $newMessage, $headers);

								$headerLoc = 'Location: http://marcelo.outroll.com/';

								header($headerLoc."index.php");								
							}
							else header($headerLoc."index.php?name=$name&email=$email&phone=$phone&subject=$subject&message=$message");
						}
						else header($headerLoc."index.php?name=$name&email=$email&phone=$phone&subject=$subject&message=$message");
					}
					else header($headerLoc."index.php?name=$name&email=$email&phone=$phone&subject=$subject&message=$message");
				}
				else header($headerLoc."index.php?name=$name&email=$email&phone=$phone&subject=$subject&message=$message");
			}
		?>
		<header id="page-top">
			<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
						</button>
						<div class="logo">
							<div class="brand navbar-brand page-scroll" href="#page-top" style="padding-right:1px">Echo</div>
							<img src="assets/img/Echo-flower.png" style="padding:10px; width:45px; height:45px">
						</div>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right">
							<li>
								<a class="page-scroll" href="#page-top">Início</a>
							</li>
							<li>
								<a class="page-scroll" href="#sign">Entre/Registre-se</a>
							</li>
							<li>
								<a class="page-scroll" href="#services">Serviços</a>
							</li>
							<li>
								<a class="page-scroll" href="#room">Quartos</a>
							</li>
							<li>
								<a class="page-scroll" href="#contact">Contato</a>
							</li>
						</ul>
					</div>
				</div>
			</nav>
			<div class="header-content">
				<div class="header-content-inner">
					<h1 id="homeHeading">No centro de tudo e de frente para o mar</h1>
				</div>
			</div>
		</div>
	</header>
	<section class="bg-primary" id="sign">
		<div class="container">
			<div class="row">
				<div class="col-md-12 tittle" align="center">
					<h2 class="section-heading">Já se registrou?</h2>
					<hr class="light">
				</div>
				<div class="col-md-6 col-md-offset-3">
					<div class="panel panel-login">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-6">
									<a href="#" class="active" id="login-form-link">Entrar</a>
								</div>
								<div class="col-xs-6">
									<a href="#" id="register-form-link">Registre-se</a>
								</div>
							</div>
							<hr>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<form id="login-form" action="#" method="post" role="form" style="display: block;">
										<div class="form-group">
											<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="E-mail" value="">
										</div>
										<div class="form-group">
											<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Senha">
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6 col-sm-offset-3">
													<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-primary" value="Entrar">
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-lg-12">
													<div class="text-center">
														<a href="#" tabindex="5" class="forgot-password">Esqueceu a senha?</a>
													</div>
												</div>
											</div>
										</div>
									</form>
									<form id="register-form" action="#" method="post" role="form" style="display: none;">
										<div class="form-group">
											<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Usuário" value="">
										</div>
										<div class="form-group">
											<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email" value="">
										</div>
										<div class="form-group">
											<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Senha">
										</div>
										<div class="form-group">
											<input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirmar Senha">
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6 col-sm-offset-3">
													<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-primary" value="Registrar">
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="services">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center tittle">
					<h2 class="section-heading">Alguns serviços</h2>
					<hr class="primary">
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 text-center">
					<div class="service-box">
						<i class="fa fa-4x fa-coffee text-primary sr-icons"></i>
						<h3>Café da manhã servido na acomodação</h3>
						<p class="text-muted">Aproveite o seu café da manhã no conforto de sua acomodação! Café da manhã servido para uma pessoa com pães variados, bolos, iogurte, frutas da estação, suco, café, leite, cereais, frios, salada de fruta e salgados quentes.</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 text-center">
					<div class="service-box">
						<i class="fa fa-4x fa-car text-primary sr-icons"></i>
						<h3>Estacionamento</h3>
						<p class="text-muted">Estacionamento privativo com manobrista 24h. (Consultar valor diário diretamente com o hotel).</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 text-center">
					<div class="service-box">
						<i class="fa fa-4x fa-bed text-primary sr-icons"></i>
						<h3>Serviço de quarto</h3>
						<p class="text-muted">Room service até às 23h (Consultar valores e políticas diretamente com o hotel).</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 text-center">
					<div class="service-box">
						<i class="fa fa-4x fa-wifi text-primary sr-icons"></i>
						<h3>Internet</h3>
						<p class="text-muted">O hotel dispõe de internet a cabo de alta velocidade como cortesia, permitindo uma navegação rápida e de qualidade, seja para tratar de negócios online ou apenas para entretenimento.</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="room">
		<div class="row">
			<div class="col-lg-12 text-center tittle">
				<h2 class="section-heading">Nossos Quartos</h2>
				<hr class="primary">
			</div>
		</div>
		<div class="container-fluid">
			<div class="row no-gutter popup-gallery">
				<div class="col-lg-4 col-sm-6">
					<a href="assets/img/room/1.jpg" class="room-box">
						<img src="assets/img/room/1.jpg" class="img-responsive" alt="">
						<div class="room-box-caption">
							<div class="room-box-caption-content">
								<div class="project-name">
									Um quarto
								</div>
							</div>
						</div>
					</a>
					<ul align="center">
						<li>TV de plasma</li>
						<li>Chuveiro</li>
						<li>Cama king size</li>
						<li>Wifi liberado</li>
						<small>(Café da manhã incluso)</small>
					</ul>
				</div>
				<div class="col-lg-4 col-sm-6">
					<a href="assets/img/room/2.jpg" class="room-box">
						<img src="assets/img/room/2.jpg" class="img-responsive" alt="">
						<div class="room-box-caption">
							<div class="room-box-caption-content">
								<div class="project-name">
									Dois quartos
								</div>
							</div>
						</div>
					</a>
					<ul align="center">
						<li>TV de plasma</li>
						<li>Dois chuveiro</li>
						<li>Camas de solteiro</li>
						<li>Wifi liberado</li>
						<li>Cofre</li>
						<small>(Café da manhã incluso)</small>
					</ul>
				</div>
				<div class="col-lg-4 col-sm-6">
					<a href="assets/img/room/3.jpg" class="room-box">
						<img src="assets/img/room/3.jpg" class="img-responsive" alt="">
						<div class="room-box-caption">
							<div class="room-box-caption-content">
								<div class="project-name">
									Suíte
								</div>
							</div>
						</div>
					</a>
					<ul align="center">
						<li>TV de plasma</li>
						<li>Banheira</li>
						<li>Cama king size</li>
						<li>Wifi liberado</li>
						<li>Cofre</li>
						<li>Champanhe de cortesia</li>
						<small>(Café da manhã incluso)</small>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<section id="contact">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-lg-12 tittle">
					<h1 align="center">
					Tem Algo a Dizer? <small>Estamos sempre aceitando sugestões</small></h1>
					<hr>
				</div>
			</div>
			<form class="col-md-12 well" method="POST" action="#">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="name">Nome</label>
							<input type="text" class="form-control" name="name" placeholder="Digite seu nome">
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" class="form-control" name="email" placeholder="Digite seu email">
						</div>
						<div class="form-group">
							<label for="phone">Telefone</label>
							<input type="tel" class="form-control" name="phone" maxlength="18" placeholder="Digite seu telefone">
						</div>
						<div class="form-group">
							<label for="subject">Assunto</label>
							<select class="form-control" name="subject">
								<option selected value="#">Escolha um:</option>
								<option value="Elogios">Elogios</option>
								<option value="Sugestoes">Sugestões</option>
								<option value="Outros">Outros</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="message">Mensagem</label>
							<textarea class="form-control" name="message" maxlength="240" rows="11" placeholder="Digite sua mensagem aqui"></textarea>
						</div>
						<div class="form-group">
							<button class="btn btn-primary pull-right" name="suggestions-submit" type="submit">Enviar</button>
						</div>
					</div>
				</div>
			</form>
		</div>
		<footer>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-md-2 ">
							<p class="muted pull-right">Por<a href="https://github.com/geovanasilva"> Grupo FATEC</a></p>
						</div>
						<div class="col-md-6 col-md-offset-4">
							<p class="muted pull-right">© 2017 Echo Hotel. Todos os direitos reservados</p>
						</div>
					</div>
				</div>
			</div>
		</footer>
	</section>
	<!-- jQuery -->
	<script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
	<!-- Bootstrap Core JavaScript -->
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- Plugin JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
	<script src="assets/scrollreveal/scrollreveal.min.js"></script>
	<script src="assets/magnific-popup/jquery.magnific-popup.js"></script>
	<!-- Theme JavaScript -->
	<script src="assets/js/main.js"></script>
	<script src="assets/js/sign.js"></script>
	<script src="assets/js/jquery-ui.min.js"></script>
</body>
</html>
