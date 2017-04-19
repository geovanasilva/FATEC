<!DOCTYPE html>
<html 
	<head>
		<meta charset="UTF-8">
		<title>Login Page</title>  
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<div class="login-page">
			<div class="form">
				<form class="register-form" method="POST">
					<input type="text" name="username" placeholder="name"/>
					<input type="password" name="password" placeholder="password"/>
					<input type="text" name="email" placeholder="email address"/>
					<button name="create" type="submit">Create</button>
					<p class="message">Already registered? <a href="#">Sign In</a></p>
				</form>
				<form class="login-form" method="POST">
					<input type="text" name="username" placeholder="username"/>
					<input type="password" name="password" placeholder="password"/>
					<button name="login" type="submit">Login</button>
					<p class="message">Not registered? <a href="#">Create an account</a></p>
				</form>
			</div>
		</div>
		<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
		<script src="js/index.js"></script>
		<?php
			if( isset($_POST['login']) )
			{
				$user = isset($_POST['username']) ? $_POST['username'] : null;
				$pass = isset($_POST['password']) ? $_POST['password'] : null;
			
				if( !empty($user) && !empty($pass) )
				{
					$host = "localhost";
					$usdb = "root";
					$pwdb = "root";
					$dbdb = "projetophp";
					
					$conn = mysqli_connect($host, $usdb, $pwdb, $dbdb);
					
					if($conn) // Connected to the DB
					{
						$query = "SELECT NM_User, PW_User FROM User WHERE DS_Email_User = '".$user.
						"' AND PW_User = '".$pass."'";
						
						$res = mysqli_query($conn, $query);
																			
						if(mysqli_num_rows($res) > 0) // Found the user
						{
							$rows = mysqli_fetch_assoc($res);
							
							session_start();
							
							$_SESSION['username'] = $rows['NM_User'];
							$_SESSION['access'] = $rows['DS_Access_User'];
							
							header("Location: http://frontend.dev.fatecpg.com/index.php");
						}
						else echo "Invalid User"; // Invalid User
						
						mysqli_close($conn);
					}
				}
			}
			else if( isset($_POST['create']) )
			{
				$user = isset($_POST['username']) ? $_POST['username'] : null;
				$pass = isset($_POST['password']) ? $_POST['password'] : null;
				$mail = isset($_POST['email']) ? $_POST['email'] : null;
				
				$host = "localhost";
				$usdb = "root";
				$pwdb = "root";
				$dbdb = "projetophp";
					
				$conn = mysqli_connect($host, $usdb, $pwdb, $dbdb);
					
				if($conn) // Connected to the DB
				{
					$query = "SELECT NM_User, DS_Email_User FROM User WHERE DS_Email_User = '".$mail."'";
					
					$res = mysqli_query($conn, $query);
					
					if(mysqli_num_rows($res) == 0) // Email not used
					{
						$query = "INSERT INTO User VALUES (null,'".$user."','".$pass."','".$mail."')";
						
						mysqli_query($conn, $query);
						
						echo "<h1>Inserido com sucesso</h1>";
					}
					else echo "<h1> Este e-mail ja foi utilizado </h1>";
					
					mysqli_close($conn);
				}
			}
		?>
	</body>
</html>
