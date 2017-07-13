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
		<link rel="stylesheet" href="assets/css/main-user.css">
		<link href="assets/css/jquery-ui.css" rel="stylesheet">
		
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
			require 'Reserva.php';
			
			$user = new Usuario();
					
			if( $user->getAccess() == "Offline")
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
								$headerLoc .= 'index-user.php?email='.$email;

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
				$tipo = new Tipo_Quarto();
				$quarto = new Quarto();
				$reserva = new Reserva();

				$defaultHeader = "Location: http://marcelo.outroll.com/";

				if( array_key_exists( 'exit', $_POST ) )
					if( $user->Logout() == 1 )
						header( $defaultHeader."index.php" );

				if( array_key_exists( 'save', $_POST ) )
				{
					$tipoQuarto = $_POST['cd_tipo_quarto'];
					$dtChegada = strtr($_POST['start'], '/', '-');
					$dtSaida = strtr($_POST['end'], '/', '-');

					$dtChegada = date('Y-m-d', strtotime($dtChegada));
					$dtSaida = date('Y-m-d', strtotime($dtSaida));

					if( strtotime( $dtChegada ) <= strtotime( $dtSaida ) && is_numeric( $tipoQuarto ) && intval( $tipoQuarto ) > 0 )
					{
						$disponiveis = $quarto->LerQuarto(null, null, $tipoQuarto);

						$randomQuarto = rand(1, sizeof($disponiveis));

						$rooms[$disponiveis[$randomQuarto]['CD_Quarto']] = $tipoQuarto;

						$precos = $tipo->LerTipoQuarto( null, $disponiveis[$randomQuarto]['CD_Tipo_Quarto'] );

						if( $reserva->CadastrarReserva( $_SESSION['codigo'], $dtChegada, $dtSaida, $rooms, $precos[1]['VL_Tipo_Quarto'], "Pendente" ) == 1 )
						{	
							$varToSend = array('DS_Status_Quarto' => 'Em uso');

							if( $quarto->AlterarQuarto( $disponiveis[$randomQuarto]['CD_Quarto'],  $varToSend) == 1 )
							{
								$defaultHeader .= "index-user.php";

								header( $defaultHeader );
							}
						}
					}
				}

				if( array_key_exists( 'drop', $_POST ) )
				{
					$senha = $_POST['nm_senha'];
					$codUsuario = $_POST['cd_usuario'];
					$codReserva = $_POST['cd_reserva'];

					if( is_numeric( $codUsuario ) && is_numeric( $codReserva ) && intval( $codUsuario ) > 0 && intval( $codReserva ) > 0 && !empty( $senha ) )
					{
						$info = $user->LerUsuario( false, $codUsuario, false, false);

						if( $senha == $info[1]['PW_Usuario'] )
						{
							if( $reserva->DeletarReserva( $codReserva ) == 1)
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
					<a href="index-user.php"><img src="assets/img/logoec.png" alt="Echo Hotel Logo" class="img-responsive logo"></a>
				</div>
				<div class="sidebar-scroll">
					<nav>
						<ul class="nav">
							<li title="Dashboard"><a href="index-user.php" class=""><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
							<li title="Configurações"><a href="panels-user.php" class=""><i class="lnr lnr-cog"></i> <span>Configurações</span></a></li>
							<li title="Sair"><a href="#" onClick="return Logout();"><i class="lnr lnr-exit"></i> <span>Sair</span></a></li>
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
										<li><a href="index.php">Fale conosco</a></li>
									</ul>
								</li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="assets/img/user.png" class="img-circle" alt="Avatar"> <span><?php echo $_SESSION['usuario']; ?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
									<ul class="dropdown-menu">
										<li><a href="index-user.php"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
										<li><a href="panels-user.php"><i class="lnr lnr-cog"></i> <span>Configurações</span></a></li>
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
										<h3 class="panel-title">Últimas reservas</h3>
										<div class="right">
											<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
											<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
										</div>
									</div>
									<div class="panel-body no-padding">
										<table class="table table-striped">
											<thead>
												<tr>
													<th>Reserva</th>
													<th>Tipo quarto</th>
													<th>Data de chegada</th>
													<th>Data de saída</th>
													<th>Valor total gasto</th>
													<th>Status</th>
													<th>Cancelar?</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$reservas = $reserva->LerReserva( null, $_SESSION['codigo'] );

													$table = NULL;
													
													if( is_array( $reservas ) )
													{
														foreach( $reservas as $key => $arrayReserva )
														{
															$valorTotal = 0;

															$table .= "<tr>";
															$table .= "<td>".$arrayReserva['CD_Reserva']."</td>";
															
															foreach( $arrayReserva['CD_Tipo_Reserva'] as $keyValue => $realValue )
															{																														
																$table .= "<td>".$arrayReserva['CD_Tipo_Reserva'][$keyValue]['DS_Tipo_Quarto']."</td>";

																$valorTotal += $realValue['VL_Reserva'];
															}

															$table .= "<td>".date('d/m/Y', strtotime($arrayReserva['DT_Entrada_Reserva']))."</td>";
															$table .= "<td>".date('d/m/Y', strtotime($arrayReserva['DT_Saida_Reserva']))."</td>";
															$table .= "<td>R$ ".number_format($valorTotal, 2, ',', '.')."</td>";
															
															if( $arrayReserva['DS_Status_Reserva'] == "Pendente" )
																$table .= "<td><span class='label label-warning'>".$arrayReserva['DS_Status_Reserva']."</span></td>";
															else if( $arrayReserva['DS_Status_Reserva'] == "Em uso" )
																$table .= "<td><span class='label label-success'>".$arrayReserva['DS_Status_Reserva']."</span></td>";
															else if( $arrayReserva['DS_Status_Reserva'] == "Finalizado" )
																$table .= "<td><span class='label label-danger'>".$arrayReserva['DS_Status_Reserva']."</span></td>";

															$table .= "<td><a role='button' data-title='Delete' data-toggle='modal' data-target='#modalCancelamento' onClick='return ChangeDropModal(".$_SESSION['codigo'].", ".$arrayReserva['CD_Reserva'].");'><span class='lnr lnr-undo'></span></a></td>";

															$table .= "</tr>";
														}

														echo $table;
													}
												?>
											</tbody>
										</table>
									</div>
									<!--<div class="panel-footer">
										<div class="row">
											<ul class="pagination pull-right">
												<li class="disabled"><a href="#"><span class="glyphicon glyphicon-chevron-left"></span></a></li>
												<li class="active"><a href="#">1</a></li>
												<li><a href="#">2</a></li>
												<li><a href="#">3</a></li>
												<li><a href="#">4</a></li>
												<li><a href="#">5</a></li>
												<li><a href="#"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
											</ul>
										</div>
									</div>-->
								</div>
								<!-- END RECENT -->
							</div>
						</div>
					</div>
				</div>
				<!-- END MAIN CONTENT -->
				<!-- MODAL AREA -->
				<div class="modal fade" id="novaConta" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Nova reserva</h4>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-12">
										<form role="form" action="#" method="POST">
											<div class="form-group" >
												<label for="ds_tipoquarto">Tipo de quarto</label>
												<select class="form-control modelo" id="ds_tipoquarto" name="cd_tipo_quarto">
												<?php
													$quartos = $quarto->ListAvailableTypes();

													if( is_array( $quartos ) )
														foreach($quartos as $key => $value)
															echo "<option index='".$quartos[$key]['CD_Tipo_Quarto']."' value='".$quartos[$key]['CD_Tipo_Quarto']."'>".$quartos[$key]['DS_Tipo_Quarto']."</option>";
													else
														echo "<option index=0 value=0> Não há quartos disponíveis no momento </option>";
												?>
												</select>
												<div class="form-group" id="teste">
													<button type="button" id="qt_quartos_aumentar"><span class="lnr lnr-plus-circle"></span></button>
													<button type="button"  id="qt_quartos_diminuir"><span class="lnr lnr-undo"></span></button>
												</div>
											</div>
											<div class="form-group">
												<label><strong>Data de chegada</strong></label>
												<input type="text" class="form-control" name="start" value="dd/mm/yy" id="dt-chegada"/>
											</div>
											<div class="form-group">
												<label><strong>Data de saída</strong></label>
												<input type="text" class="form-control" name="end" value="dd/mm/yy" id="dt-saida" />
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
				<div class="modal fade" id="modalCancelamento" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Você tem certeza que deseja cancelar esta reserva?</h4>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-12">
										<form role="form" method="POST" action="#">
											<div class="form-group">
												<input type="password" name="nm_senha" id="nm_senha" class="form-control" placeholder="Entre com sua senha para confirmar o ato" />
												<input type="hidden" name="cd_usuario" id="cd_usuario_drop" value="" />
												<input type="hidden" name="cd_reserva" id="cd_reserva_drop" value="" />	
											</div>
											<div class="form-group text-center">
												<button class="btn btn-danger" type="submit" name="drop" title="Cancelar">Cancelar</button>
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
						<button type="button" id="button-glyphicon" class="btn btn-circle btn-xl novaConta" data-toggle="modal" data-target="#novaConta"><i class="glyphicon glyphicon-plus"></i></button>
					</div>
					<div class="container-fluid">
						<p class="copyright">&copy; 2017. Desenvolvido por <a href="https://github.com/geovanasilva">Geovana Silva</a></p>
					</div>
				</footer>
			</div>
			<!-- END MAIN -->
		</div>
		<!-- END WRAPPER -->
		<!-- Javascript -->
		<script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src="assets/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/js/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
		<script src="assets/js/plugins/jquery-easypiechart/jquery.easypiechart.min.js"></script>
		<script src="assets/js/plugins/chartist/chartist.min.js"></script>
		<script src="assets/js/extern.min.js"></script>
		<script>
			$(document).ready(function(){
				$('#dt-chegada, #dt-saida').datepicker({
					dateFormat: "dd/mm/yy",
					todayBtn: "linked",
					language: "pt-BR",
					autoclose: true,
					minDate: 0,
					dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
				dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
				dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
				monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
				monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
				nextText: 'Próximo',
				prevText: 'Anterior'
				});
				
				$("#qt_quartos_aumentar").on('click', function(button){
					var $this = $(this);
					
					var indice = $('.modelo').length;
					
					if ($('[data-item]').length > 0) {
						var item = $('[data-item]').last().clone();
					} else {
						var item = $('.modelo').last().clone();
					}
					
					item.attr("name", "teste[]");
					item.css({"display": 'block', 'margin-bottom' : '1vw'});
					item.attr("data-item", indice);
					item.addClass("selectpicker form-control");
					
					$this.parent().append(item);
				});
				
				$("#qt_quartos_diminuir").on('click', function(button){
					var $this = $(this);
					
					$('[data-item]').last().remove();
				});
			});
		</script>
		<script>
		function Logout(){
			$.post('/index-user.php', { exit: 'disc' }, function(result) {
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
		function ChangeDropModal(codUsuario, codReserva)
		{
			var dropUser = document.getElementById('cd_usuario_drop');
			var dropReserva = document.getElementById('cd_reserva_drop');

			dropUser.value = codUsuario;
			dropReserva.value = codReserva;
		}
		</script>
		<?php } ?>
	</body>
</html>