<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
		<title>admin</title>
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