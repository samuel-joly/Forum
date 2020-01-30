<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
		<title>Connexion</title>
	</head>

	<body>
		<?php 
			include("header.php"); 
			
			if(isset($_SESSION["errCo"])) {	
				if(!isset($_SESSION["errcoCount"])) {

					if($_SESSION["errCo"] > 0) {			
						echo "Il vous reste ".$_SESSION["errCo"]." esssais";
					}
					else {
						$_SESSION["errcoCount"] = getdate()[0];
						header("location:connexion.php");
					}
				}
				else {
					echo "Vous etes bloqués pendant 60 secondes";
					if(getdate()[0] - $_SESSION["errcoCount"] > 60) {
						unset($_SESSION["errcoCount"]);
						unset($_SESSION["errCo"]);

						header("location:connexion.php");
					}
				}				
			}	
		?>

		<main>
			<form action="connexion.php" method="post">
				<label for="pseudo">Pseudo</label>
				<input type="text" name="pseudo" placeholder="Alan Smithee" required/>

				<label for="psw">Password</label>
				<input type="password" name="psw" required/>

				<input type="submit" name="submit"/>
				<input type="reset" value="Effacer"/>
			</form>
		</main>

		<footer>
		</footer>
	</body>

</html>


<?php

	if(isset($_POST["submit"])) { // Si on clique sur  le btn valider
		if(required($_POST)) {
			
			$usrData = sql_request("SELECT * FROM utilisateurs WHERE pseudo = '".$_POST["pseudo"]."'", true, true);
			
			if(password_verify($_POST["psw"], $usrData[2])) {
				$_SESSION["id"] = $usrData[0];
				$_SESSION["login"] = $usrData[1];
				header("location:forum.php");
			}
			else
			{
				if(!isset($_SESSION["errCo"])) {
					$_SESSION["errCo"] = 3;
				}
				else if($_SESSION["errCo"] > 0){
					$_SESSION["errCo"] -= 1;
				}

				header("location:connexion.php");
			}
		}
	}
?>