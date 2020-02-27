<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
		<title>admin</title>
	</head>


	<body>

		    <header>
		    	<?php 
		    	include("header.php"); 
			
		    	      if (empty($_SESSION['login']) or $_SESSION['login'] != "admin")
		    	       {
		    	      	header('Location: connexion.php');
		    	      }
		       ?>
	    </header>

	</body>

</html>