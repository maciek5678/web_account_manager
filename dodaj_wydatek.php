<?php
session_start();

if(!isset($_SESSION['logged_id']))
{
	header('Location:index.php');
	
}
if (isset($_POST['data']))
{
	$wszystko_OK= true;
	$category=$_POST['category'];
	
$date=$_POST['data'];
$kwota=$_POST['kwota'];
$platnosc=$_POST['platnosc'];


$komentarz=$_POST['komentarz'];


if ($_POST['data']=="")
{
	$_SESSION['e_data']="Wpisz datę!!!";
	$wszystko_OK= false;
}
if ($_POST['kwota']=="")
{
	$_SESSION['e_kwota']="Wpisz kwotę!!!";
		$wszystko_OK= false;
}
if( $wszystko_OK==true)
{
	require_once 'database.php';

			$query1 = $db->prepare("SELECT id FROM expenses_category_assigned_to_users WHERE user_id=:logged_id AND name=:category");
		$query1->bindValue(':category', $category, PDO::PARAM_STR);
		$query1->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_INT);
		$query1->execute();
		
		
		while($row = $query1->fetch(PDO::FETCH_ASSOC)){
            $exp_id = $row['id'];
            }

	

	
			$query3 = $db->prepare("SELECT id FROM payment_methods_assigned_to_users WHERE user_id=:logged_id AND name=:platnosc");
		$query3->bindValue(':platnosc', $platnosc, PDO::PARAM_STR);
		$query3->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_INT);
		
		$query3->execute();
		
				while($row = $query3->fetch(PDO::FETCH_ASSOC)){
            $pay_id = $row['id'];
            }


	$expances_pay = $query3->fetch();
		  $query5=$db->prepare("INSERT INTO expenses VALUES (NULL,:logged_id,:query1,:query3,:kwota,:data,:komentarz)");
$query5->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_INT);
		  		$query5->bindValue(':query1', $exp_id, PDO::PARAM_INT);

		$query5->bindValue(':query3',$pay_id, PDO::PARAM_INT);
		$query5->bindValue(':kwota', $kwota, PDO::PARAM_LOB);		
		$query5->bindValue(':data', $date, PDO::PARAM_STR);
		$query5->bindValue(':komentarz', $komentarz, PDO::PARAM_STR);
$query5->execute();
}
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8"/>
	<title>O$zczedzaj pieniądze</title>
	<script  src="timer.js"> </script>
	<meta name="description" content="Strona przeznaczona do oszczedzania pieniedzy"/>
	<meta name="keywords" content="bilans, przychod,wydatek "/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
	<link rel="stylesheet" href="main.css" type="text/css" />
	<link rel="stylesheet" href="css/fontello.css" type="text/css" />
	<link rel="stylesheet" href="css/bootstrap.css"/>
	<link href="https://fonts.googleapis.com/css2?family=Style+Script&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
	
	

	
</head>

	<body onload="pobierzDate();" >
		<div id="container">
			<div id="title">
			<img  id="dollar" src="img/dolar.png" alt="dolar"/>O$zczedzaj pieniądze
				<div class="quote">
				Żyje się za pieniądze, ale nie warto żyć dla pieniędzy. Wszystko, co można dostać za pieniądze, jest tanie.
				</div>
			</div>
			 <nav class="navbar navbar-expand-xxl navbar-dark bg-secondary">
				 <div class="container-fluid ">
			
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>	  
					</button>
					<div class="collapse navbar-collapse " id="navbarSupportedContent">
								<ul class="navbar-nav">
										<li class="navbar-item">
											<a  href="menu_glowne.php">
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
											<a class="nav-link disabled" href="dodaj_wydatek.php">
													<i class="icon-basket-1"></i>
													Dodaj wydatek
											</a>
										</li>
										<li class="navbar-item">
											<a  href="przegladaj_bilans.php">
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
			<div id="subtitle">
			Dodaj wydatek
			</div>
			<div id="expence" class="col-8 col-xl-6">
				<form method="post">
					<div class="cattitle col-12">Data</div>
						<br/>    
						<input type="date" id="data" name="data"><br/>
												<?php

if (isset($_SESSION['e_data']))
{
	echo '<div class="error">'.$_SESSION['e_data'].'</div>';
	unset($_SESSION['e_data']);
}



?>
						<br/>
						<div class="cattitle col-12">Kwota</div>

						<br/>
						<div class ="cat col-12 ">
						<input type="number"  placeholder="wpisz kwotę" onfocus="this.placeholder='wpisz kwotę'" onblur="this.placeholder='wpisz kwotę'" name="kwota" min="0.01" step="0.01"/>
												<?php

if (isset($_SESSION['e_kwota']))
{
	echo '<div class="error">'.$_SESSION['e_kwota'].'</div>';
	unset($_SESSION['e_kwota']);
}
?>
						<br/>
						<br/>
						</div>
						<div class="cattitle">Sposób płatności</div>
						<br/>
						<label><input type="radio" name="platnosc"  value="Cash"  checked />Gotówka</label><br/>
						<label><input type="radio" name="platnosc" value="Debit Card"/>Karta debetowa</label>		<br/>
						<label><input type="radio" name="platnosc"value="Credit Card"/>Karta kredytowa</label>	<br/>
						<br/>
						<div class="cattitle">Kategoria</div>
						<br/>
						<div class ="cat col-12 col-lg-6 col-xxl-3">
						<label><input type="radio" name="category" value="Transport" checked  />Transport</label><br/>
						<label><input type="radio" name="category" value="Books"/>Ksiązki</label><br/>
							<label><input type="radio" name="category" value="Food"/>Jedzienie</label><br/>

							
						</div>
						<div class ="cat col-12 col-lg-6 col-xxl-3">
						<label><input type="radio" name="category" value="Apartments"/>Mieszkanie</label><br/>
							<label><input type="radio" name="category" value="Telecommunication"/>Telekomunikacja</label><br/>
							<label><input type="radio" name="category" value="Health"/>Opieka zdrowotna</label><br/>
							
						</div>
						<div class ="cat col-12 col-lg-6 col-xxl-3">
						<label><input type="radio" name="category" value="Clothes" />Ubranie</label><br/>
							<label><input type="radio" name="category" value="Hygiene" />Higiena</label><br/>
							<label><input type="radio" name="category" value="Kids" />Dzieci</label><br/>
						</div>
						<div class ="cat col-12 col-lg-6 col-xxl-3">
						<label><input type="radio" name="category" value="Recreation" />Rozrywka</label><br/>
							<label><input type="radio" name="category" value="Trip" />Wycieczka</label><br/>
							<label><input type="radio" name="category" value="Savings"/>Oszczędności</label><br/>
							
						</div>
						<div class ="cat col-12 col-lg-6">
							
							<label><input type="radio" name="category" value="For Retirement" />Na złotą jesień, czyli emeryturę</label><br/>
							<label><input type="radio" name="category" value="Debt Repayment" />Spłata długów</label><br/>
						</div>
						<div class ="cat col-12 col-lg-6">
							<label><input type="radio" name="category" value="Gift"/>Darowizna</label><br/>
							<label><input type="radio" name="category" id="Other" value="Another" />Inne</label> 
						</div>
						<div style ="clear:both;"></div>
						<br/>
												<div class="cattitle col-12">Komentarz</div>
						<br/>
						<div class ="cat col-12 ">
						
						<input type="text"  placeholder="wpisz komentarz" onfocus="this.placeholder='wpisz komentarz'" onblur="this.placeholder='wpisz komentarz'"  name="komentarz"  />
						<br/>
						<br/>
						</div>
						<span class ="add">
							<input type="submit"  value="Dodaj"/>	
						</span>
						<span class ="abort">
							<input type="submit" value="Anuluj" />		
						</span>					
				</form>
			</div>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
		<script src="js/bootstrap.js"></script>
	</body>
</html>