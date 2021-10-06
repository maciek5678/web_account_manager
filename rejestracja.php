<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
	<head>
		<meta charset="utf-8"/>
		<title>O$zczedzaj pieniądze</title>
		<meta name="description" content="Strona przeznaczona do oszczedzania pieniedzy"/>
		<meta name="keywords" content="bilans, przychod,wydatek "/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />	
		<link rel="stylesheet" href="main.css" type="text/css" />
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/fontello.css" type="text/css" />		
		<link href="https://fonts.googleapis.com/css2?family=Style+Script&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
				
		
		
	</head>
	<body>
		<div id="container">
			<div id="title">
				<img  id="dollar" src="img/dolar.png" alt ="dolar"/>O$zczedzaj pieniądze
				<div class="quote">
				Żyje się za pieniądze, ale nie warto żyć dla pieniędzy. Wszystko, co można dostać za pieniądze, jest tanie.</div>
			</div>
			<div id="menu">  
				<div id="menuoption">  
					<ul>
						<li>
							<a href="rejestracja.php">
							Rejestracja
							</a>
						</li>
						<li>
							<a href="index.php">
							Logowanie
							</a>
						</li>
					</ul>
					<div style="clear:both;"></div>
				</div>
			</div>

			<div id="registration" class="col-8  col-md-6 col-lg-4 col-xl-3">
			Zarejestruj się

				<form id="reglog" method="post" action="save.php">
					<i class="icon-mail-alt"></i>				
					<input class="col-8 col-md-6" type="email" placeholder="e-mail" onfocus="this.placeholder=''" onblur="this.placeholder='e-mail'"  name="email">
		<?php

if (isset($_SESSION['e_email']))
{
	echo '<div class="error">'.$_SESSION['e_email'].'</div>';
	unset($_SESSION['e_email']);
}

?>			
					
					
					<div style="clear:both;"></div>		
					
					<i class="icon-user"></i>
					<input class="col-8 col-md-6" type="text" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'" name="login">
																														<?php

if (isset($_SESSION['e_login']))
{
	echo '<div class="error">'.$_SESSION['e_login'].'</div>';
	unset($_SESSION['e_login']);
}

?>

					<div style="clear:both;"></div>					
					<i class="icon-lock"></i>
					<input class="col-8 col-md-6" type="password" placeholder="hasło" onfocus="this.placeholder=''" onblur="this.placeholder='haslo'" name="password1">
<?php

if (isset($_SESSION['e_haslo']))
{
	echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
	unset($_SESSION['e_haslo']);
}
?>
					
					<div style="clear:both;"></div>					
					<i class="icon-lock"></i>					
					<input class="col-8 col-md-6" type="password" placeholder="powtórz hasło" onfocus="this.placeholder=''" onblur="this.placeholder='powtórz hasło'" name="password2">					
					<div style="clear:both;"></div>
					<input type="submit" value="Zarejestruj się">
	
					
				</form>
			</div>

		</div>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
		<script src="js/bootstrap.js"></script>
	</body>
</html>