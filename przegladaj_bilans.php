<?php
session_start();
if(!isset($_SESSION['logged_id']))
{
	header('Location:index.php');
	
}
require_once  'database.php';

$daty_graniczne=false;
if (!isset($_POST['period']))
{
	$data=date("Y-m").'%';


}	else{
if ($_POST['period']=="currentMonth")
{
$data=date("Y-m").'%';
}


else if ($_POST['period']=="previousMonth")
{
$rok=date("Y");
$miesiac=date("n");
if($miesiac>1){
$miesiac=$miesiac-1;


}
else
{
	$miesiac=12;

	$rok=$rok-1;
}
if($miesiac<10)
	$miesiac="0".$miesiac;

$data=$rok."-".$miesiac."%";


}
if ($_POST['period']=="currentYear")
{
	$data=date("Y").'%';
}
if ($_POST['period']=="unusual")
{
$datapocz=$_POST['datapocz'];
$datakonc=$_POST['datakonc'];
$daty_graniczne=true;
}
}

if($daty_graniczne==false){
$usersQuery = $db->prepare("SELECT incomes.date_of_income, incomes.Amount, incomes_category_assigned_to_users.name FROM incomes_category_assigned_to_users, incomes WHERE incomes_category_assigned_to_users.id=incomes.income_category_assigned_to_user_id AND incomes.user_id=:logged_id AND incomes.date_of_income LIKE :data");

$usersQuery->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_INT);
$usersQuery->bindValue(':data', $data, PDO::PARAM_STR);
$usersQuery->execute();

		$users = $usersQuery-> fetchAll();
		$usersQuery2 = $db->prepare("SELECT expenses.date_of_expense, expenses.Amount, expenses_category_assigned_to_users.name FROM expenses_category_assigned_to_users, expenses WHERE expenses_category_assigned_to_users.id=expenses.expense_category_assigned_to_user_id AND expenses.user_id=:logged_id AND expenses.date_of_expense LIKE :data");

$usersQuery2->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_INT);
$usersQuery2->bindValue(':data', $data, PDO::PARAM_STR);
$usersQuery2->execute();

		$users2 = $usersQuery2-> fetchAll();
}

else
{	
$usersQuery = $db->prepare("SELECT incomes.date_of_income, incomes.Amount, incomes_category_assigned_to_users.name FROM incomes_category_assigned_to_users, incomes WHERE incomes_category_assigned_to_users.id=incomes.income_category_assigned_to_user_id AND incomes.user_id=:logged_id AND incomes.date_of_income BETWEEN :datapocz AND :datakonc");

$usersQuery->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_INT);
$usersQuery->bindValue(':datapocz', $datapocz, PDO::PARAM_STR);
$usersQuery->bindValue(':datakonc', $datakonc, PDO::PARAM_STR);
$usersQuery->execute();

		$users = $usersQuery-> fetchAll();
		$usersQuery2 = $db->prepare("SELECT expenses.date_of_expense, expenses.Amount, expenses_category_assigned_to_users.name FROM expenses_category_assigned_to_users, expenses WHERE expenses_category_assigned_to_users.id=expenses.expense_category_assigned_to_user_id AND expenses.user_id=:logged_id AND expenses.date_of_expense BETWEEN :datapocz AND :datakonc");

$usersQuery2->bindValue(':logged_id', $_SESSION['logged_id'], PDO::PARAM_INT);
$usersQuery2->bindValue(':datapocz', $datapocz, PDO::PARAM_STR);
$usersQuery2->bindValue(':datakonc', $datakonc, PDO::PARAM_STR);
$usersQuery2->execute();

		$users2 = $usersQuery2-> fetchAll();
}
?>
<!DOCTYPE html>
<html lang="pl">
	<head>

		<meta charset="utf-8"/>
		<title>O$zczedzaj pieniądze</title>
<script src="https://cdn.anychart.com/releases/8.10.0/js/anychart-base.min.js"></script>
		<script  src="timer.js">		
<?php		
		echo 'var transport = '.$transport;
		echo 'var books = '.$books;
		echo 'var foods  = '.$foods ;
		echo 'var apartments = '.$apartments;
		echo 'var telecommunication = '.$telecommunication;
		echo 'var health = '.$health;
		echo 'var clothes = '.$clothes;
		echo 'var hygiene = '.$hygiene;
		echo 'var kids = '.$kids;
		echo 'var recreation = '.$recreation;
		echo 'var trip = '.$trip;
		echo 'var savings = '.$transport;
		echo 'var for_Retirement = '.$for_Retirement;
		echo 'var debt_Repayment = '.$debt_Repayment;
		echo 'var gift= '.$gift;
		echo 'var another = '.$another;
?>	</script> 
		<meta name="description" content="Strona przeznaczona do oszczedzania pieniedzy"/>
		<meta name="keywords" content="bilans, przychod,wydatek "/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
		<link rel="stylesheet" href="main.css" type="text/css" />
		<link rel="stylesheet" href="css/fontello.css" type="text/css" />	
		<link rel="stylesheet" href="css/bootstrap.css"/>
		<link href="https://fonts.googleapis.com/css2?family=Style+Script&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
	</head>
	<body onload="pokazWykres()">
		<script id="wykres">

	
		
		</script>
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
									<a href="dodaj_wydatek.php">
										<i class="icon-basket-1"></i>
										Dodaj wydatek
									</a>
								</li>
								<li class="navbar-item">
									<a class="nav-link disabled" href="przegladaj_bilans.php">
										<i class="icon-chart-line"></i>
										Przeglądaj bilans
									</a>
								</li>
								<li class="navbar-item">
									<a href="ustawienia.php">
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
				Przeglądaj bilans
				</div>
				<form method='post'>
				<div id="bilancePeriod">
						<form method='post'>					
					<label for="period">Podaj okres bilansu:</label>
					<select  id="period"  onchange="changeDate(this)" name="period" >
						<option value="currentMonth"<?php if(!isset($_POST['period']) || $_POST['period']=="currentMonth" ) echo "selected" ?>>Bieżący miesiąc</option>
						<option value="previousMonth" <?php if(isset($_POST['period']) && $_POST['period']=="previousMonth") echo "selected" ?>>Poprzedni miesiąc</option>
						<option value="currentYear" <?php if( isset($_POST['period']) && $_POST['period']=="currentYear") echo "selected" ?>>Bieżący rok</option>
						<option value="unusual" <?php if( isset($_POST['period']) && $_POST['period']=="unusual") echo "selected" ?>>Niestandardowy</option>
					</select>
				</div>
				<div id="balance" class="col-10 col-md-8 col-xl-8">
					<div id="balance2">


  <div id="balance3"></div>
							<div id='incomeTable' class='col-12 col-xl-6'> Przychody<br/> 
  <table>
  <thead>
    <tr><th colspan="3">Łącznie rekordów: <?= $usersQuery->rowCount() ?></th></tr>
  <tr><th>data</th><th>kwota</th><th>typ</th></tr>
  </thead>
  <tbody>
  <?php
$suma_przychody=0;

  foreach ($users as $user)
  {
	  echo "<tr><td>{$user['date_of_income']}</td><td>{$user['Amount']}</td><td>{$user['name']}</td</tr>";
	  
	  $suma_przychody=$suma_przychody+$user['Amount'];
	  

	  
  }
  
  
  ?>
  </tbody>
  
  </table>
    <?php    echo "<br/> Przychody= ".$suma_przychody;   ?>
							</div>
							<div id='expenseTable' class='col-12 col-xl-6'>Wydatki<br/>
  <table>
  <thead>
    <tr><th colspan="3">Łącznie rekordów: <?= $usersQuery2->rowCount() ?></th></tr>
  <tr><th>data</th><th>kwota</th><th>typ</th></tr>
  </thead>
  <tbody>
  <?php
  	  $suma_wydatki=0;
	  $transport=0;
	  $books=0;
	  $foods=0;
	  $apartments=0;
	  $telecommunication=0;
	  $health=0;
	  $clothes=0;
	  $hygiene=0;
	  $kids=0;
	  $recreation=0;
	  $trip=0;
	  $savings=0;
	  $for_Retirement=0;
	  $debt_Repayment=0;
	  $gift=0;
	  $another=0;
  foreach ($users2 as $user2)
  {

	  echo "<tr><td>{$user2['date_of_expense']}</td><td>{$user2['Amount']}</td><td>{$user2['name']}</td</tr>";
	  	  $suma_wydatki=$suma_wydatki+$user2['Amount'];
		  
		  	  if($user2['name']=="Transport")
	  {
		$transport=$transport+  $user2['Amount'];
	  }
	  else if($user2['name']=="Books")
	  {
		$books=$bookst+  $user2['Amount'];
	  }
	  	  else if($user2['name']=="Food")
	  {
		$food=$food+  $user2['Amount'];
	  }
	  else if($user2['name']=="Apartments")
	  {
		$apartments=$apartments+  $user2['Amount'];
	  }
	   else if($user2['name']=="Telecommunication")
	  {
		$telecommunication=$telecommunication+  $user2['Amount'];
	  }
	   else if($user2['name']=="Health")
	  {
		$health=$health +$user2['Amount'];
	  }
	   else if($user2['name']=="Clothes")
	  {
		$clothes=$clothes+  $user2['Amount'];
	  }
	   else if($user2['name']=="Hygiene")
	  {
		$hygiene=$hygiene+  $user2['Amount'];
	  }
	   else if($user2['name']=="Kids")
	  {
		$kids=$kids+ $user2['Amount'];
	  }
	  	   else if($user2['name']=="Recreation")
	  {
		$recreation=$recreation+ $user2['Amount'];
	  }
	  	   else if($user2['name']=="Trip")
	  {
		$trip=$trip+ $user2['Amount'];
	  }
	  	   else if($user2['name']=="Savings")
	  {
		$savings=$savings+ $user2['Amount'];
	  }
	  	   else if($user2['name']=="For Retirement")
	  {
		$for_Retirement=$for_Retirement+ $user2['Amount'];
	  }
	  	   else if($user2['name']=="Debt Repayment")
	  {
		$debt_Repayment=$debt_Repayment + $user2['Amount'];
	  }
	  	   else if($user2['name']=="Gift")
	  {
		$gift=$gift+ $user2['Amount'];
	  }
	  	   else if($user2['name']=="Another")
	  {
		$another=$another+ $user2['Amount'];
	  }
  }
  
  
  ?>
  </tbody>
  
  </table>
    <?php   echo "<br/>Wydatki= ".$suma_wydatki;   ?>
							</div>
							<div style='clear:both;'>
							<span class ='add'>
							<input type='submit'  value='Pokaż'/><br/>
							</span>
							<?php   if($suma_przychody>=$suma_wydatki) 
echo "Gratulacje. Świetnie zarządzasz finansami!</div>";
else
	echo "Uważaj. Wpadasz w długi</div>";
								?>


					</div>
					<div  id="c">

				</div>
				</div>
				</form>
			</div>
			<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
			<script src="js/bootstrap.js"></script>
	</body>
</html>