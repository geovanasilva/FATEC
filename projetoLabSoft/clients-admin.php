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
									
								if( $access == 'Admin') $headerLoc .= 'clients-admin.php';
								else if( $access == 'Usuario') $headerLoc .= 'index-user.php';
							}
							else
								$headerLoc .= 'clients-admin.php?email='.$email;

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
				$defaultHeader = "Location: http://marcelo.outroll.com/";

			if( array_key_exists( 'exit', $_POST ) )
				if( $user->Logout() == 1 )
					header($defaultHeader."index.php");

			if( array_key_exists( 'edit', $_POST ) )
			{
				$cod = $_POST['cd_usuario'];
				$cpf = $_POST['cpf'];
				$name = $_POST['nn_cliente'];
				$password = $_POST['ds_password'];
				$email = $_POST['ds_email'];
				$status = $_POST['bl_ativo'];
			}

			if( array_key_exists( 'save', $_POST ) )
			{
				$nome = $_POST['nm_cliente'];
				$password = $_POST['ds_password'];
				$email = $_POST['ds_email'];
				$status = $_POST['ds_status'];
				$cpf = $_POST['cpf'];
				$acesso = 'Usuario';

				if( !empty( $nome ) && strlen( $nome ) <= 50 )
				{
					if( !empty( $password ) && strlen( $password ) <= 50 )
					{
						if( !empty( $email ) && filter_var( $email, FILTER_VALIDATE_EMAIL ) && strlen($email) <= 50 )
						{
							if( !empty( $cpf ) && strlen( $cpf ) <= 14 && $user->ValidarCPF( $cpf ) == true )
							{
								if( !empty( $status ) && $status == 'Ativo' || $status == 'Inativo' )
								{
									$status = ( $status == 'Ativo' ? 1 : 0 );

									if( $user->CadastrarUsuarioAdv( $nome, $password, $acesso, $email, $cpf, $status ) == 1 )
									{
										$defaultHeader = "Location: http://marcelo.outroll.com/";

										header( $defaultHeader."clients-admin.php" );
									} 
									else echo "<h1> NOT POSSIBLE TO SAVE </h1>";
								} 
								else echo "<h1> INVALID STATUS </h1>";
							} 
							else echo "<h1> INVALID CPF </h1>";
						} 
						else echo "<h1> INVALID E-MAIL </h1>";
					} 
					else echo "<h1> INVALID PASSWORD </h1>";
				}
				else echo "<h1> INVALID NAME </h1>";
			}

			if( array_key_exists( 'drop', $_POST ) )
			{
				$senha = $_POST['nm_senha'];
				$codAdmin = $_POST['cd_admin'];
				$codUsuario = $_POST['cd_usuario'];

				if( is_numeric( $codUsuario ) && is_numeric( $codAdmin ) && intval( $codUsuario ) > 0 && intval( $codAdmin ) > 0 && !empty( $senha ) )
				{
					$info = $user->LerUsuario( false, $codAdmin, false, false );

					if( $senha == $info[1]['PW_Usuario'] )
					{
						if( $user->RemoverUsuario( $codUsuario ) )
							header("Location: ".$_SERVER['PHP_SELF']);
					}
				}
			}
		?>
		<div id="wrapper">
			<!-- SIDEBAR -->
			<div class="sidebar">
				<div class="brand">
					<a href="index.php"><img src="assets/img/logoec.png" alt="Echo Hotel Logo" class="img-responsive logo"></a>
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
										<h3 class="panel-title">Clientes</h3>
										<div class="right">
											<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
											<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
										</div>
									</div>
									<div class="panel-body no-padding">
										<table class="table table-striped">
											<thead>
												<tr>
													<th>CPF</th>
													<th>Nome do Cliente</th>
													<th>Email</th>
													<th>Status</th>
													<th>Editar</th>
													<th>Remover</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$usuarios = $user->LerUsuario(true, null, null, null);

													if( is_array($usuarios) )
													{
														$table = NULL;

														foreach( $usuarios as $key => $value )
														{
															$table .= "<tr>";
															
															$table .= "<td>".$value['DS_CPF']."</td>";
															$table .= "<td>".$value['NM_Usuario']."</td>";
															$table .= "<td>".$value['DS_Email_Usuario']."</td>";
															$table .= "<td>".( $value['BL_Ativo'] == 1 ? "<span class='label label-success'>Ativo</span>" : "<span class='label label-danger'>Inativo</span>" )."</td>";
															$table .= "<td><a role='button' data-title='Edit' data-toggle='modal' data-target='#modalEdicao' onClick='return getByCodigo(".$value['CD_Usuario'].");' ><span class='lnr lnr-pencil'></span></a></td>
															<td><a role='button' data-title='Delete' data-toggle='modal' data-target='#modalDelecao' onClick='return ChangeDropModal(".$_SESSION['codigo'].", ".$value['CD_Usuario'].");' ><span class='lnr lnr-trash'></span></a></td>";

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
								<h4 class="modal-title">Editar cliente</h4>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-12">
										<form role="form">
											<div class="form-group has-feedback">
												<label for="cd_cpfcliente_edit"><strong>CPF</strong></label>
												<input type="text" name="cpf" id="cd_cpfcliente_edit" class="form-control" maxlength="14" placeholder="Digite aqui o CPF" />
											</div>
											<div class="form-group">
												<label for="nm_cliente_edit"><strong>Nome do cliente</strong></label>
												<input type="text" name="nm_cliente" id="nm_cliente_edit" class="form-control" placeholder="Digite aqui o nome do cliente" />
											</div>
											<div class="form-group">
												<label for="ds_password"><strong>Senha</strong></label>
												<input type="password" name="ds_password" id="ds_password" class="form-control" placeholder="Digite aqui a senha" />
											</div>
											<div class="form-group">
												<label for="ds_email"><strong>Email</strong></label>
												<input type="text" name="ds_email" id="ds_email_edit" class="form-control" placeholder="Digite aqui o email" />
											</div>
											<div class="form-group">
												<label for="ds_email"><strong>Status</strong></label>&nbsp;&nbsp;&nbsp;&nbsp;
												<label class="radio-inline"><input type="radio" id="bl_ativo_edit" name="bl_ativo" value="1">Ativo</label>
												<label class="radio-inline"><input type="radio" id="bl_inativo_edit" name="bl_ativo" value="0">Inativo</label>
												<input type="hidden" name="cd_usuario" id="cd_usuario_edit" value="" />
											</div>
											<div class="form-group text-center">
												<button class="btn btn-success" name="edit" type="submit" title="Salvar">Salvar</button>
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
								<h4 class="modal-title">Você tem certeza que deseja excluir este cliente?</h4>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-12">
										<form role="form" action="#" method="POST">
											<div class="form-group">
												<input type="password" name="nm_senha" id="nm_senha" class="form-control" placeholder="Entre com sua senha para confirmar o ato" />
												<input type="hidden" name="cd_admin" id="cd_admin_drop" value="" />
												<input type="hidden" name="cd_usuario" id="cd_usuario_drop" value="" />
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
				<div class="modal fade" id="novaConta" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Novo cliente</h4>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-12">
										<form role="form" id="validator" method="POST" action="#">
											<div class="form-group has-feedback">
												<label for="cd_cpfcliente_add"><strong>CPF</strong></label>
												<input type="text" name="cpf" id="cd_cpfcliente_add" class="form-control"  maxlength="14" placeholder="Digite aqui o CPF" required />
											</div>
											<div class="form-group">
												<label for="nm_cliente_add"><strong>Nome do cliente</strong></label>
												<input type="text" name="nm_cliente" id="nm_cliente_add" class="form-control" maxlength="50" placeholder="Digite aqui o nome do cliente" required />
											</div>
											<div class="form-group">
												<label for="ds_password"><strong>Senha</strong></label>
												<input type="password" name="ds_password" id="ds_password" class="form-control" maxlength="50" placeholder="Digite aqui a senha" required />
											</div>
											<div class="form-group">
												<label for="ds_email_add"><strong>Email</strong></label>
												<input type="text" name="ds_email" id="ds_email_add" class="form-control" maxlength="50" placeholder="Digite aqui o email" required />
											</div>
											<div class="form-group">
												<label for="ds_email_add"><strong>Status</strong></label>&nbsp;&nbsp;&nbsp;&nbsp;
												<label class="radio-inline"><input type="radio" name="ds_status" value="Ativo" required>Ativo</label>
												<label class="radio-inline"><input type="radio" name="ds_status" value="Inativo">Inativo</label>
											</div>
											<div class="form-group text-center">
												<button class="btn btn-success" type="submit" title="Salvar" name="save">Salvar</button>
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
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
		<script type="text/javascript">
			jQuery.fn.removeNot = function( settings ){
			var $this = jQuery( this );
			var defaults = {
				pattern: /[^0-9]/,
				replacement: ''
			}
			settings = jQuery.extend(defaults, settings);
			
			$this.keyup(function(){
				var new_value = $this.val().replace( settings.pattern, settings.replacement );
				$this.val( new_value );
			});
			return $this;
			}
			jQuery.fn
			//$(document).ready(function(){
			//$("#nm_cliente_edit").removeNot({ pattern: /[^a-z ]+/g });
			//$("#nm_cliente_add").removeNot({ pattern: /[^a-z ]+/g });
			//});
			$(document).ready(function () {
			$("#cd_cpfcliente_edit").mask('000.000.000-00', {reverse: true});
			$("#cd_cpfcliente_add").mask('000.000.000-00', {reverse: true});
			});
			</script>
			<script>
				function Logout(){
					$.post('/panels-user.php', { exit: 'disc' }, function(result) {
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
					
					XMLHttp.open("GET", "AjaxTester.php?codUsuario=" + value, true );
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
					var editCod = document.getElementById('cd_usuario_edit');
					var editNome = document.getElementById('nm_cliente_edit');
					var editCPF = document.getElementById('cd_cpfcliente_edit');
					var editEmail = document.getElementById('ds_email_edit');
					
					var values = String.split("*");
										
					/*
					values[0] = Código do usuário
					values[1] = Nome
					values[2] = CPF
					values[3] = Email
					values[4] = Boolean ativo
					*/

					editCod.value = values[0];
					editNome.value = values[1];
					editCPF.value = values[2];
					editEmail.value = values[3];

					if( values[4] == 1) document.getElementById('bl_ativo_edit').setAttribute("checked", "checked");
					else if( value[4] == 0 ) document.getElementById('bl_inativo_edit').setAttribute("checked", "checked");
				}
				function ChangeDropModal(codAdmin, codUsuario)
				{
					var dropAdmin = document.getElementById('cd_admin_drop');
					var dropUsuario = document.getElementById('cd_usuario_drop');

					dropAdmin.value = codAdmin;
					dropUsuario.value = codUsuario;
				}
			</script>
			<?php } ?>
	</body>
</html>