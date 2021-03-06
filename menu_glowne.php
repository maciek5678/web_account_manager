<?php
session_start();
		require_once  'database.php';

if (!isset($_SESSION['logged_id'])){


	if(isset($_POST['username']))
	{
		$login = filter_input(INPUT_POST, 'username');
		$password = filter_input(INPUT_POST, 'pass');
		//echo $login. " ".$password;
		

		
		$userQuery = $db->prepare(' SELECT id, password FROM users WHERE username = :username');
		$userQuery->bindValue(':username', $login, PDO::PARAM_STR);
		$userQuery->execute();

		
		$user = $userQuery-> fetch();
		
		if ($user && password_verify($password, $user['password']))
		{
			$_SESSION ['logged_id']=$user['id'];
			unset($_SESSION['bad_attempt']);
		$_SESSION ['log']=$_POST['username'];
		}
	else{
		$_SESSION['bad_attempt']= true;
		header ('Location: index.php');
		exit();
	}


	}else
	{
		
		header ('Location: index.php');
		exit();
	}
}
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
		<link rel="stylesheet" href="css/fontello.css" type="text/css" />
	<link rel="stylesheet" href="css/bootstrap.css"/>	
		<link href="https://fonts.googleapis.com/css2?family=Style+Script&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
		
	</head>

	<body>
		<div id="container">
			<div id="title">
				<img  id="dollar" src="img/dolar.png" alt="dolar"/>O$zczedzaj pieniądze
				<div class="quote">
			Żyje się za pieniądze, ale nie warto żyć dla pieniędzy. Wszystko, co można dostać za pieniądze, jest tanie.</div>
			</div>
		 <nav class="navbar navbar-expand-xxl navbar-dark bg-secondary">
		 <div class="container-fluid ">
	
		 <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
	  
    </button>
	<div class="collapse navbar-collapse " id="navbarSupportedContent">
				<ul class="navbar-nav">
				<li class="navbar-item">
				<a class="nav-link disabled" href="menu_glowne.html">
							<i class="icon-home"></i>
							Menu Główne
							</a>
				</li>
				<li class="navbar-item">
					<a href="dodaj_przychod.php">
							<i class="icon-dollar"></i>
							Dodaj przychód
							</a>
				</li>
				<li class="navbar-item">
				<a href="dodaj_wydatek.php">
							<i class="icon-basket-1"></i>
							Dodaj wydatek
							</a>
				</li>
				<li class="navbar-item">
				<a href="przegladaj_bilans.php">
							<i class="icon-chart-line"></i>
							Przeglądaj bilans
							</a>
				</li>
				<li class="navbar-item">
							<a href="ustawienia.html">
							<i class="icon-wrench"></i>
							Ustawienia
							</a>
						</li>
						<li class="navbar-item">
							<a href="wyloguj.php">
							<i class="icon-logout"></i>
							Wyloguj się
							</a>
						</li>
</ul>
					
	</div>
  </div>
</nav>
				
			<div id="expence" class="col-10">
			
		<div class="elements">
<div class="elem">
			<img src="img/z3.jpg" class="img-fluid" alt="pieniądze">
</div>
<div class="elem">
			<span class="welcome"><span class="welcomebold">Witaj<?php    
echo " ".$_SESSION ['log'];

			?></span><br/>
			Zapraszamy do oszczędzania. <br/>
			Pamiętaj że pieniądze to nie wszystko</span>
			<br/>
			<br/>
			<br/>
			</div>

		</div>
		</div>
		</div>
				<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
		<script src="js/bootstrap.js"></script>
	</body>
</html>