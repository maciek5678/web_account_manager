<?php

session_start();

$wszystko_OK=true;
	
if(isset($_POST['email'] ))
{	
	$nick=$_POST['login'];
	$email=$_POST['email'];
	$login= $_POST['login'];
	$password1= $_POST['password1'];
	$password2= $_POST['password2'];
	$haslo_hash= password_hash($password1, PASSWORD_DEFAULT);

$wszystko_OK=true;
		if((strlen($login)<3) || (strlen($login)>20))
	{
		$wszystko_OK=false;
		$_SESSION['e_login']="Login musi posiadać od 3 do 20 znaków!";
	}
	if(ctype_alnum($login)==false)
	{
		$wszystko_OK=false;
		$_SESSION['e_login']="Login może składać się tylko z liter i cyfr (bez polskich znaków)";
	}
	$emailB= filter_var($email, FILTER_SANITIZE_EMAIL);
	
	if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
	{
		$wszystko_OK=false;
		$_SESSION['e_email']="Podaj poprawny adres e-mail";
	}
	if ((strlen($password1)<8) || (strlen($password1)>20))
	{
				$wszystko_OK=false;
		$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
	}
		if ($password1!=$password2)
	{
				$wszystko_OK=false;
		$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
	}
	require_once 'database.php';
	$query = $db->prepare("SELECT id FROM users WHERE email='$email'");
		
		$query->execute();
if (!$query) throw new Exception($query->error);
	$ile_takich_maili = $query->fetchColumn();
	
	if ($ile_takich_maili>0)
	{
							$wszystko_OK=false;
		$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu email";
	}
	require_once 'database.php';
	$query = $db->prepare("SELECT id FROM users WHERE username='$login'");
	
		$query->execute();
if (!$query) throw new Exception($query->error);
	$ile_takich_loginow = $query->fetchColumn();
	
	if ($ile_takich_loginow>0)
	{
							$wszystko_OK=false;
		$_SESSION['e_login']="Istnieje już konto o podanym loginie";
	}





	if( $wszystko_OK==false)
	{
		header('Location: rejestracja.php');
	}else{

		$query = $db->prepare('INSERT INTO users VALUES (NULL, :username,:password,:email)');
		$query->bindValue(':username', $login, PDO::PARAM_STR);
		$query->bindValue(':password', $haslo_hash, PDO::PARAM_STR);
		$query->bindValue(':email', $email, PDO::PARAM_STR);
		$query->execute();
		
		$registrated_id=$db->prepare("SELECT id FROM users WHERE username=:username ");
		$registrated_id->bindValue(':username', $login, PDO::PARAM_STR);
		$registrated_id->execute();
		
		while($row = $registrated_id->fetch(PDO::FETCH_ASSOC)){
            $id = $row['id'];
            }
		
		
		$query3 = $db->prepare('INSERT INTO expenses_category_assigned_to_users (user_id,name) SELECT :id, name FROM  expenses_category_default');
		$query3->bindValue(':id', $id, PDO::PARAM_INT);
		$query3->execute();
		
				$query4 = $db->prepare('INSERT INTO payment_methods_assigned_to_users (user_id,name) SELECT :id, name FROM  payment_methods_default');
		$query4->bindValue(':id', $id, PDO::PARAM_INT);
		$query4->execute();
						$query4 = $db->prepare('INSERT INTO incomes_category_assigned_to_users (user_id,name) SELECT :id, name FROM  incomes_category_default');
		$query4->bindValue(':id', $id, PDO::PARAM_INT);
		$query4->execute();
	}
}else{
	
	
	
	

	header('Location: rejestracja.php');
	exit();
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
			Dziękujemy za rejestracje
			<br/>
			Przejdź do logowania
				</form>
			</div>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
		<script src="js/bootstrap.js"></script>
	</body>
</html>
