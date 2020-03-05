<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/admin.css"/>
		<title>admin</title>
	</head>


	<body class="oc-body-admin">

		      <header>
		    	<?php 
		    	include("header-admin.php"); 
			
		    	      if (empty($_SESSION['login']) or $_SESSION['login'] != "admin")
		    	       {
		    	      	 header('Location: connexion.php');
		    	      }
		       ?>
		     </header>
		     <body>
		     <?php //..............................titre.......................................
		          


		     ?>
		              <h1>Etes vous sure de vouloir metre <?php echo $_POST['validadmin'] ; ?>  en temp qu'Administreteurs</h1>

		              <main>
		              	<?php



		              	?>


		              </main>


		    </body>
