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
		<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>
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
		
		if( $user->getAccess() == "Offline" )
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
							else if( $access == 'Usuario') $headerLoc .= 'panels-user.php';
						}
						else
							$headerLoc .= 'panels-user.php?email='.$email;

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
			
			if( array_key_exists( 'save', $_POST ) )
			{				
				$nome = $_POST['nome'];
				$genero = $_POST['gender'];
				$cpf = $_POST['cpf'];
				$rg = $_POST['rg'];
				$phone = $_POST['tel'];
                $senhaAtual = $_POST['senhaatual'];
				$novaSenha = $_POST['novasenha'];
				$confirm = $_POST['confirmarnovasenha'];
								
				$genero = empty($genero) ? null : ($genero == 'Masculino' ? 'M' : 'F');
								
				$originValues = $user->LerUsuario(false, $_SESSION['codigo'], null, null);
				
				if( !empty($senhaAtual) && $senhaAtual == $originValues[1]['PW_Usuario'] )
				{
					$varToSend = array();
										
					if( !empty($nome) && $nome != $originValues[1]['NM_Usuario'] && strlen($nome) <= 50 )
						$varToSend['NM_Usuario'] = $nome;
					if( !empty($genero) && $genero != $originValues[1]['SG_Sexo'] && strlen($genero) < 2 )
						$varToSend['SG_Sexo'] = $genero;
					if( !empty($cpf) && $cpf != $originValues[1]['DS_CPF'] && strlen($cpf) <= 14 && $user->ValidarCPF( $cpf ) == true )
						$varToSend['DS_CPF'] = $cpf;
					if( !empty($rg) && $rg != $originValues[1]['DS_RG'] && strlen($rg) <= 12 )
						$varToSend['DS_RG'] = $rg;
					if( !empty($phone) && $phone != $originValues[1]['DS_Telefone'] && strlen($phone) <= 20)
						$varToSend['DS_Telefone'] = $phone;
                    if( !empty($novaSenha) && !empty($confirm) && $novaSenha == $confirm && $novaSenha != $originValues[1]['PW_Usuario'] )
                        $varToSend['PW_Usuario'] = $novaSenha;
										
					if( sizeof($varToSend) > 0 )					
						if( $user->AlterarUsuario( $_SESSION['codigo'], $varToSend ) == 1 )
							header("Location: ".$_SERVER['PHP_SELF']);
				}
			}
			
			if( array_key_exists( 'drop', $_POST ) )
			{
				$user->RemoverUsuario( $_SESSION['codigo'] );
				
				$user->Logout();
				
				header($defaultHeader."index.php");
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
									<a title="Ajuda" href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="lnr lnr-question-circle"></i> <span>Ajuda</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
									<ul class="dropdown-menu">
										<li title="Termos de uso"><a href="#">Termos de uso</a></li>
										<li title="Fale conosco"><a href="#">Fale conosco</a></li>
									</ul>
								</li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="assets/img/user.png" class="img-circle" alt="Avatar"> <span><?php echo $_SESSION['usuario']; ?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
									<ul class="dropdown-menu">
										<li title="Dashboard"><a href="index-user.php" class=""><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
										<li title="Configurações"><a href="panels-user.php" class=""><i class="lnr lnr-cog"></i> <span>Configurações</span></a></li>
										<li title="Sair"><a href="#" onClick="return Logout();"><i class="lnr lnr-exit"></i> <span>Sair</span></a></li>
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
								<h3 class="panel-title">Meus dados</h3>
							</div>
							<div class="panel-body">
								<!-- INPUTS -->
								<form id="validator" method="POST" action="#">
                                    <?php $origValues = $user->LerUsuario(false, $_SESSION['codigo'], null, null); ?>
									<div class="form-group">
										<input type="text" class="form-control" name="nome" id="nome" placeholder="Digite seu nome completo" value="<?php echo $origValues[1]['NM_Usuario']; ?>">
									</div>
									<div class="form-group">
										<label class="fancy-radio" title="Feminino">
											<input name="gender" value="Feminino" type="radio" <?php if($origValues[1]['SG_Sexo'] == 'F') echo 'checked'; ?>>
											<span><i></i>Feminino</span>
										</label>
										<label class="fancy-radio" title="Masculino">
											<input name="gender" value="Masculino" type="radio" <?php if($origValues[1]['SG_Sexo'] == 'M') echo 'checked'; ?>>
											<span><i></i>Masculino</span>
										</label>
									</div>
									<div class="form-group">
										<input type="text" class="form-control" name="cpf" id="cpf" maxlength="14" placeholder="Digite o seu CPF" value="<?php echo $origValues[1]['DS_CPF']; ?>">
									</div>
									<div class="form-group">
										<input type="text" class="form-control" name="rg" id="rg" maxlength="12" placeholder="Digite o seu RG" value="<?php echo $origValues[1]['DS_RG']; ?>">
									</div>
									<div class="form-group">
										<input type="text" class="form-control" name="tel" id="tel" maxlength="14" placeholder="Digite seu telefone" value="<?php echo $origValues[1]['DS_Telefone']; ?>">
									</div>
									<div class="form-group">
										<input type="password" class="form-control" name="senhaatual" placeholder="Digite sua senha atual" title="Digite sua senha atual">
									</div>
									<div class="form-group">
										<input type="password" class="form-control" name="novasenha" placeholder="Digite sua nova senha" title="Digite sua nova senha">
									</div>
									<div class="form-group">
										<input type="password" class="form-control" name="confirmarnovasenha" placeholder="Confirme sua senha" title="Confirme sua nova senha">
									</div>
									<div class="row">
										<div class="col-md-10 col-xs-8">
											<button type="submit" name="save" class="btn btn-success" title="Botão para salvar dados">Salvar dados</button>
										</div>
										<div class="col-md-2 col-xs-4">
											<button type="submit" name="drop" class="btn btn-danger excluirConta" data-toggle="modal" data-target="#modalDelecao" title="Botão para deletar dados">Deletar Conta</button>
										</div>
									</div>
								</form>
								<!-- END INPUTS -->
							</div>
						</div>
						<!-- END OVERVIEW -->
					</div>
				</div>
				<!-- END MAIN CONTENT -->
				<!-- MODAL -->
				<div class="modal fade" id="modalDelecao" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Você tem certeza que deseja excluir esta conta?</h4>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-12">
										<form role="form">
											<div class="form-group">
												<input type="password" name="nm_senha" id="nm_senha" class="form-control" placeholder="Entre com sua senha para confirmar o ato" />
											</div>
											<div class="form-group text-center">
												<button class="btn btn-danger" type="button" title="Excluir">Excluir</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- END MODAL -->
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
			$(document).ready(function(){
			$("#nome").removeNot({ pattern: /[^a-z ]+/gi });
			});
			$(document).ready(function () {
			$("#cpf").mask('000.000.000-00', {reverse: true});
			$("#rg").mask('00.000.000-0', {'translation': {0: {pattern: /[a-z0-9]/}}});
			$("#tel").mask(newcelmask, teloptions);
			});
			var newcelmask = function (val) {
			return val.replace(/\D/g, '').length === 11 ? '(00)00000-0000' : '(00)0000-00000';
			},
			teloptions = {
			onKeyPress: function(val, e, field, options) {
			field.mask(newcelmask.apply({}, arguments), options);
			}
			};
			$('#validator').bootstrapValidator({
			message: 'Esse valor não é válido.',
			feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
			nome: {
			validators: {
			notEmpty: {
			message: 'O nome não pode ficar em branco.'
			}
			}
			},
			cpf: {
			validators: {
			notEmpty: {
			message: 'O cpf não pode ficar em branco.'
			},
			callback: {
						message: 'CPF inválido',
						callback: function(value) {
								cpf = value.replace(/[^\d]+/g,'');
								var valido = 0;
								for (i=1; i < 11; i++){
								if (cpf.charAt(0)!=cpf.charAt(i)) valido =1;
								}
								if (valido==0) return false;
								aux = 0;
								for (i=0; i < 9; i ++)
								aux += parseInt(cpf.charAt(i)) * (10 - i);
								check = 11 - (aux % 11);
								if (check == 10 || check == 11)
								check = 0;
								if (check != parseInt(cpf.charAt(9)))
								return false;
								
								aux = 0;
								for (i = 0; i < 10; i ++)
								aux += parseInt(cpf.charAt(i)) * (11 - i);
								check = 11 - (aux % 11);
								if (check == 10 || check == 11)
								check = 0;
								if (check != parseInt(cpf.charAt(10)))
								return false;
								return true;
				}
			}
			}
			},
			rg: {
			validators: {
			notEmpty: {
			message: 'O rg não pode ficar em branco.'
			},
			}
			},
			tel: {
			validators: {
			notEmpty: {
			message: 'O telefone não pode ficar em branco.'
			}
			}
			},
			senhaatual: {
				validators: {
				notEmpty: {
			message: 'A senha é necessária para confirmação das alterações.'
			},
				}
				},
			novasenha: {
				validators: {
				identical: {
				field: 'confirmarnovasenha',
				message: 'As senhas não coincidem.'
				}
				}
				},
				confirmarnovasenha: {
				validators: {
				identical: {
				field: 'novasenha',
				message: 'As senhas não coincidem.'
				}
				}
				}
			}
			});
		</script>
        <script>
		function Logout(){
			$.post('/panels-user.php', { exit: 'disc' }, function(result) {
				window.location.replace("http://marcelo.outroll.com/index.php");
			});
		}
		</script>
		<?php } ?>
	</body>
</html>