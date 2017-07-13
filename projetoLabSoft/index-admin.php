<!DOCTYPE html>
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<html>

<head>
	<title>Echo Hotel</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- CSS -->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/vendor/icon-sets.css">
	<link rel="stylesheet" href="assets/css/main-admin.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
</head>

<body>
	<?php
		session_start();
		
		require 'Connection.php';
		require 'Usuario.php';
		
		$user = new Usuario();
	
		if( $user->getAccess() != 'Admin' )
		{
			if( array_key_exists( 'submit-login', $_POST ) )
			{
				$email = $_POST['email'];
				$password = $_POST['password'];

				if( !empty( $email ) && filter_var( $email, FILTER_VALIDATE_EMAIL ) && strlen( $email ) <= 50 )
				{
					if( !empty( $password ) && strlen( $password ) <= 50 )
					{
						$headerLoc = 'Location: http://marcelo.outroll.com/';
							
						if( $user->Login( $email, $password ) == 1 )
						{
							$access = $user->getAccess();
								
							if( $access == 'Admin') $headerLoc .= 'index-admin.php';
							else if( $access == 'Usuario') $headerLoc .= 'index-user.php';
						}
						else
							$headerLoc .= 'index-admin.php?email='.$email;

						header( $headerLoc );
					}
				}
			}

		?>
			<div id="wrapper">
				<div class="vertical-align-wrap">
					<div class="auth-box lockscreen clearfix">
						<div class="content">
							<h1 class="sr-only">Echo Hotel</h1>
							<div class="logo text-center"><img src="assets/img/logoec.png" alt="Echo Logo"></div>
							<div class="user text-center">
								<!--<img src="assets/img/user-medium.png" class="img-circle" alt="Avatar">-->
								<h2 class="name">Parece que você não está logado no site...</h2>
							</div>
							<form method="POST" action="#">
								<!--<div class="input-group">
									<input type="text" class="form-control" name="email" placeholder="Digite seu e-mail...">
									<span class="input-group-btn"><button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right"></i></button></span>
								</div><br>-->
								<div class="form-group">
									<input type="text" class="form-control" name="email" placeholder="Digite seu e-mail..." value="<?php  echo ( array_key_exists( 'email', $_GET ) ? $_GET['email'] : null ); ?>">
								</div>
								<div class="form-group">
									<input type="password" class="form-control" name="password" placeholder="Digite sua senha...">
								</div>
								<!--<div class="input-group">
									<input type="password" name="password" class="form-control" placeholder="Digite sua senha...">
									<span class="input-group-btn"><button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right"></i></button></span>
								</div>-->
								<button type="submit" class="btn btn-primary" name="submit-login">Entrar</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
		else
		{
			if( array_key_exists( 'exit', $_POST ) )
				if( $user->Logout() == 1 )
					header("Location: http://marcelo.outroll.com/index.php");
	?>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- SIDEBAR -->
		<div class="sidebar">
			<div class="brand">
				<a href="index-admin.php"><img src="assets/img/logoec.png" alt="Echo Hotel Logo" class="img-responsive logo"></a>
			</div>
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="index-admin.php" class=""><i class="lnr lnr-home"></i><span>Dashboard</span></a></li>
						<li><a href="clients-admin.php" class=""><i class="lnr lnr-user"></i><span>Clientes</span></a></li>
						<li><a href="panels-admin.php" class=""><i class="lnr lnr-cog"></i><span>Configurações</span></a></li>
						<li><a href="rooms-admin.php" class=""><i class="fa fa-bed"></i><span>Quartos</span></a></li>
						<li><a href="type-rooms-admin.php" class=""><i class="fa fa-check-square"></i><span>Tipo de quarto</span></a></li>
						<li><a href="reservations-admin.php" class=""><i class="lnr lnr-apartment"></i><span>Reservas</span></a></li>
						<li><a href="#" onClick="return Logout();"><i class="lnr lnr-exit"></i> <span>Sair</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- END SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- NAVBAR -->
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-btn">
						<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
					</div>
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-menu">
							<span class="sr-only">Toggle Navigation</span>
							<i class="fa fa-bars icon-nav"></i>
						</button>
					</div>
					<div id="navbar-menu" class="navbar-collapse collapse">
						<ul class="nav navbar-nav navbar-right">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="lnr lnr-question-circle"></i> <span>Ajuda</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
								<ul class="dropdown-menu">
									<li><a href="#">Termos de uso</a></li>
									<li><a href="#">Fale conosco</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="assets/img/user.png" class="img-circle" alt="Avatar"> <span><?php echo $_SESSION['usuario']; ?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
								<ul class="dropdown-menu">
									<li><a href="index-admin.php"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
									<li><a href="panels-admin.php"><i class="lnr lnr-cog"></i> <span>Configurações</span></a></li>
									<li><a href="#" onClick="return Logout();"><i class="lnr lnr-exit"></i> <span>Sair</span></a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>
			<!-- END NAVBAR -->
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Visão geral semanal</h3>
							<p class="panel-subtitle">Período: 14 de Jan de 2017 - 21 de Fev de 2017</p>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-3">
									<div class="metric">
										<span class="icon"><i class="fa fa-shopping-bag"></i></span>
										<p>
											<span class="number">203</span>
											<span class="title">Reservas</span>
										</p>
									</div>
								</div>
								<div class="col-md-3">
									<div class="metric">
										<span class="icon"><i class="fa fa-eye"></i></span>
										<p>
											<span class="number">274,678</span>
											<span class="title">Visitas</span>
										</p>
									</div>
								</div>
								<div class="col-md-3">
									<div class="metric">
										<span class="icon"><i class="fa fa-bar-chart"></i></span>
										<p>
											<span class="number">65%</span>
											<span class="title">Financeiro</span>
										</p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-9">
									<div id="demo-bar-chart" class="ct-chart"></div>
								</div>
								<div class="col-md-3">
									<div class="weekly-summary text-right">
										<span class="number">2,315</span> <span class="percentage"><i class="fa fa-caret-up text-success"></i> 12%</span>
										<span class="info-label">Total Reservas</span>
									</div>
									<div class="weekly-summary text-right">
										<span class="number">R$5,758</span> <span class="percentage"><i class="fa fa-caret-up text-success"></i> 23%</span>
										<span class="info-label">Renda Mensal</span>
									</div>
									<div class="weekly-summary text-right">
										<span class="number">R$65,938</span> <span class="percentage"><i class="fa fa-caret-down text-danger"></i> 8%</span>
										<span class="info-label">Renda Total</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
			<footer>
				<div class="container-fluid">
					<p class="copyright">&copy; 2017. Desenvolvido por <a href="https://github.com/geovanasilva">Grupo FATEC</a></p>
				</div>
			</footer>
		</div>
		<!-- END MAIN -->
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/js/plugins/jquery-easypiechart/jquery.easypiechart.min.js"></script>
	<script src="assets/js/plugins/chartist/chartist.min.js"></script>
	<script src="assets/js/extern.min.js"></script>
	<script>
		function Logout()
		{
			$.post('/index-admin.php', { exit: 'disc' }, function(result) {
				window.location.replace("http://marcelo.outroll.com/index.php");
			});
		}
	</script>
	<?php } ?>
</body>

</html>
