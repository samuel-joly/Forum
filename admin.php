<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/admin.css"/>
		<title>admin</title>
	</head>


	<body class="oc-body-admin">

		      <header>
		    	<?php 
		    	include("header.php"); 
			
		    	      if (empty($_SESSION['login']) or $_SESSION['login'] != "admin")
		    	       {
		    	      	 header('Location: connexion.php');
		    	      }
		       ?>
		     </header>
		            <main>
		            	<section >
		            		<article class="oc-article-admin1">
		            			<a  href="gestion/admin-moderateur.php"><p>Moderateur et Administrateur</p></a>
		            		</article>
		            	</section>
		            </main>