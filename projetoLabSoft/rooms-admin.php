<!DOCTYPE html>
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<html>

<head>
	<title>Echo Hotel</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- CSS -->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css">
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
		require 'Tipo_Quarto.php';
		require 'Quarto.php';
		
		$user = new Usuario();
		
		if( $user->getAccess() != "Admin" )
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
									
							if( $access == 'Admin') $headerLoc .= 'rooms-admin.php';
							else if( $access == 'Usuario') $headerLoc .= 'index-user.php';
						}
						else
							$headerLoc .= 'rooms-admin.php?email='.$email;

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
			$quarto = new Quarto();
			$tipoQuarto = new Tipo_Quarto();

			$defaultHeader = "Location: http://marcelo.outroll.com/";
			
			if( array_key_exists( 'exit', $_POST ) )
				if( $user->Logout() == 1 )
					header ($defaultHeader."index.php" );
				
			if( array_key_exists( 'save', $_POST ) )
			{				
				$codQuarto = $_POST['cd_quarto'];
				$codTipo = $_POST['cd_tipo_quarto'];
				$status = $_POST['ds_status'];
				
				$arrStatus = array( "Disponível", "Em uso", "Manutenção" );
				
				if( is_numeric( $codQuarto ) && intval( $codQuarto ) > 0 && intval( $codQuarto ) <  PHP_INT_MAX )
				{
					if( is_numeric( $codTipo ) && intval( $codTipo ) > 0 )
					{
						if( !empty( $status ) && in_array( $status, $arrStatus ) )
						{
							if( $quarto->CadastrarQuarto( $codQuarto, $status, $codTipo ) == 1 )
								header("Location: ".$_SERVER['PHP_SELF']);
						}
						// else invalid status
					}
					// else invalid codTipo
				}
				// else invalid codQuarto
			}
			
			if( array_key_exists( 'edit', $_POST ) )
			{
				$codQuarto = $_POST['cd_quarto'];
				$codTipo = $_POST['cd_tipo_quarto'];
				$status = $_POST['ds_status'];
				
				if( is_numeric($codQuarto) && intval($codQuarto) > 0 )
				{
					$originValues = $quarto->LerQuarto($codQuarto, null, null);
					$arrStatus = array( "Disponível", "Em uso", "Manutenção" );
			
					$varToSend = array();
				
					if( is_numeric($codTipo) && intval($codTipo) > 0 && $originValues[1]['CD_Tipo_Quarto'] != $codTipo )
						$varToSend['CD_Tipo_Quarto'] = $codTipo;
					if( !empty($status) && in_array($status, $arrStatus) && $originValues[1]['DS_Status_Quarto'] != $status )
						$varToSend['DS_Status_Quarto'] = $status;
					
					if( sizeof($varToSend) > 0 )					
						if( $quarto->AlterarQuarto($codQuarto, $varToSend) == 1 )
							header("Location: ".$_SERVER['PHP_SELF']);
				}
			}
			
			if( array_key_exists( 'drop', $_POST ) )
			{
				$senha = $_POST['nm_senha'];
				$codUsuario = $_POST['cd_usuario'];
				$codQuarto = $_POST['cd_quarto'];

				if( is_numeric( $codUsuario ) && is_numeric( $codQuarto ) && intval( $codUsuario ) > 0 && intval( $codQuarto ) > 0 && !empty( $senha ) )
				{
					$info = $user->LerUsuario( false, $codUsuario, false, false);

					if( $senha == $info[1]['PW_Usuario'] )
					{
						if( $quarto->RemoverQuarto( $codQuarto ) == 1 )
							header("Location: ".$_SERVER['PHP_SELF']);
					}
				}
			}
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
					<!-- END OVERVIEW -->
					<div class="row">
						<div class="col-md-12">
							<!-- RECENT PURCHASES -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Quartos</h3>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
									</div>
								</div>
								<div class="panel-body no-padding">
									<table class="table table-striped">
										<thead>
											<tr>
												<th>Número do quarto</th>
												<th>Código do tipo</th>
												<th>Tipo de quarto</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$listQuartos = $quarto->LerQuarto(null, null, null);
												
												if( is_array( $listQuartos ) )
												{
													$table = NULL;
													
													foreach( $listQuartos as $key => $value )
													{
														$table .= "<tr>";
														
														foreach( $value as $chave => $valor )
														{
															if( $chave == "DS_Status_Quarto" )
															{
																if( $valor == "Disponível" )
																	$table .= "<td><span class='label label-success'>$valor</span></td>";
																else if( $valor == "Em uso" )
																	$table .= "<td><span class='label label-warning'>$valor</span></td>";
																else if( $valor == "Manutenção" )
																	$table .= "<td><span class='label label-danger'>$valor</span></td>";
															}
															else 
																$table .= "<td> $valor </td>";
														}
															
														$table .= "<td><a role='button' class='editarQuarto' data-toggle='modal' data-target='#modalEdicao' onClick='return getByCodigo(".$value['CD_Quarto'].");'><i class='lnr lnr-pencil'></i></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
														
														if( $value['DS_Status_Quarto'] == "Disponível" )
															$table .= "<a role='button' class='excluirConta' data-toggle='modal' data-target='#modalDelecao' onClick='return ChangeDropModal(".$_SESSION['codigo'].", ".$value['CD_Quarto'].");'><i class='lnr lnr-trash'></i></a></td>";
														else
															$table .= "<a role='button' class='excluirConta' data-toggle='modal' data-target='#modalDelecao' id='linkDrop' onMouseOver='document.getElementById(\"linkDrop\").disabled = true'><i class='lnr lnr-trash'></i></a></td>";

														$table .= "</tr>";
													}
													
													echo $table;
												}
											?>
										</tbody>
									</table>
								</div>
								<div class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right"><a href="#" class="btn btn-primary">Ver todos os quartos</a></div>
									</div>
								</div>
							</div>
							<!-- END RECENT -->
						</div>
					</div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
			<!-- MODAL AREA -->
			<div class="modal fade" id="modalEdicao" role="dialog">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Editar quarto</h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<form role="form" method="POST" action="#">
										<div class="form-group has-feedback">
											<label for="cd_quarto"><strong>Número do quarto</strong></label>
											<input type="text" name="cd_quarto" id="cd_quarto_edit" class="form-control" title="Código de barras da conta" data-toggle="tooltip" data-placement="right" placeholder="Digite aqui o número do quarto" value="" readonly/>
											<i class="glyphicon glyphicon-question-sign form-control-feedback about"></i>
										</div>
										<div class="form-group">
											<label for="ds_tipoquarto_edit">Tipo de quarto</label>
											<select class="form-control" id="ds_tipoquarto_edit" name="cd_tipo_quarto">
											<?php 
												$tipos = $tipoQuarto->LerTipoQuarto(true, null);
												
												foreach($tipos as $key => $value)
													echo "<option index=".$tipos[$key]['CD_Tipo_Quarto']." value=".$tipos[$key]['CD_Tipo_Quarto'].">".$tipos[$key]['DS_Tipo_Quarto']."</option>";
											?>
											</select>
										</div>
										<div class="form-group">
											<label for="ds_email"><strong>Status</strong></label>&nbsp;&nbsp;&nbsp;&nbsp;
											<label class="radio-inline"><input type="radio" id="status1" name="ds_status" value="Disponível">Disponível</label>
											<label class="radio-inline"><input type="radio" id="status2" name="ds_status" value="Em uso">Em uso</label>
											<label class="radio-inline"><input type="radio" id="status3" name="ds_status" value="Manutenção">Manutenção</label>
										</div>
										<div class="form-group text-center">
											<button class="btn btn-success" type="submit" name="edit" title="Salvar">Salvar</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="modalDelecao" role="dialog">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Você tem certeza que deseja excluir este quarto?</h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<form role="form" method="POST" action="#">
										<div class="form-group">
											<input type="password" name="nm_senha" id="nm_senha" class="form-control" placeholder="Entre com sua senha para confirmar o ato" />
											<input type="hidden" name="cd_usuario" id="cd_usuario_drop" value="" />
											<input type="hidden" name="cd_quarto" id="cd_quarto_drop" value="" />
										</div>
										<div class="form-group text-center">
											<button class="btn btn-danger" type="submit" name="drop" title="Excluir">Excluir</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="novoQuarto" role="dialog">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Novo quarto</h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<form role="form" action="#" method="POST">
										<div class="form-group has-feedback">
											<label for="cd_quarto"><strong>Número do quarto</strong></label>
											<input type="text" name="cd_quarto" id="cd_quarto" class="form-control" title="Código de barras da conta" data-toggle="tooltip" data-placement="right" placeholder="Digite aqui o número do quarto" />
											<i class="glyphicon glyphicon-question-sign form-control-feedback about"></i>
										</div>
										<div class="form-group">
											<label for="ds_tipoquarto">Tipo de quarto</label>
											<select class="form-control" id="ds_tipoquarto" name="cd_tipo_quarto">
											<?php 
												$tipos = $tipoQuarto->LerTipoQuarto(true, null);
												
												foreach($tipos as $key => $value)
													echo "<option value=".$tipos[$key]['CD_Tipo_Quarto'].">".$tipos[$key]['DS_Tipo_Quarto']."</option>";
											?>
										</select>
										</div>
										<div class="form-group">
											<label for="ds_email"><strong>Status</strong></label>&nbsp;&nbsp;&nbsp;&nbsp;
											<label class="radio-inline"><input type="radio" name="ds_status" value="Disponível">Disponível</label>
											<label class="radio-inline"><input type="radio" name="ds_status" value="Em uso">Em uso</label>
											<label class="radio-inline"><input type="radio" name="ds_status" value="Manutenção">Manutenção</label>
										</div>
										<div class="form-group text-center">
											<button class="btn btn-success" type="submit" name="save" title="Salvar">Salvar</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END MODAL AREA -->
			<footer>
				<div class="col-md-12 text-right">
					<button type="button" class="btn btn-circle btn-xl novoQuarto" data-toggle="modal" data-target="#novoQuarto"><i class="glyphicon glyphicon-plus"></i></button>
				</div>
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
		function Logout(){
			$.post('/rooms-admin.php', { exit: 'disc' }, function(result) {
				window.location.replace("http://marcelo.outroll.com/index.php");
			});
		}
		function generateXMLHttp() 
		{
			if (typeof XMLHttpRequest != "undefined"){
				return new XMLHttpRequest();
			}
			else
			{	
				if (window.ActiveXObject)
				{
					var versions = ["MSXML2.XMLHttp.5.0", 
									"MSXML2.XMLHttp.4.0", 
									"MSXML2.XMLHttp.3.0",
									"MSXML2.XMLHttp", 
									"Microsoft.XMLHttp" ];
				}
			}
			for ( var i = 0; i < versions.length; i++ )
			{
				try{ return new ActiveXObject(versions[i]) }
				catch(e){}
			}
			alert('Seu navegador não pode trabalhar com Ajax!');
		}
		function getByCodigo(value)
		{
			var XMLHttp = generateXMLHttp();
			
			XMLHttp.open("GET", "AjaxTester.php?codQuartoEdit=" + value, true );
			XMLHttp.onreadystatechange = function()
			{
				if (XMLHttp.readyState == 4)
					if (XMLHttp.status == 200)
						ChangeEditModal(XMLHttp.responseText);					
			};
			XMLHttp.send();
		}
		function ChangeEditModal(String)
		{
			var editCod = document.getElementById('cd_quarto_edit');
			var editTipo = document.getElementById('ds_tipoquarto_edit');
			
			var values = String.split("*");
			// Valor 0 = Código do quarto
			// Valor 1 = Código do Tipo Quarto
			// Valor 2 = Descrição do Tipo Quarto
			// Valor 3 = Descrição do Status
			// Valor 4 = Código do index do select
			editCod.value = values[0];
			
			editTipo.selectedIndex = values[4];
			
			if(values[3] == "Disponível") document.getElementById("status1").setAttribute("checked", "checked");
			else if(values[3] == "Em uso") document.getElementById("status2").setAttribute("checked", "checked");
			else if(values[3] == "Manutenção") document.getElementById("status3").setAttribute("checked", "checked");
		}
		function ChangeDropModal(codUsuario, codQuarto)
		{
			var dropUser = document.getElementById('cd_usuario_drop');
			var dropQuarto = document.getElementById('cd_quarto_drop');

			dropUser.value = codUsuario;
			dropQuarto.value = codQuarto;
		}
	</script>
		<?php } ?>
</body>

</html>
