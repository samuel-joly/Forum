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
		    	      	 header('Location: ../connexion.php');
		    	      }
		       ?>
		     </header>
		     
	  	<main>
	  		<h1 class="oc-titre-admin">Gestion Administrateurs<h1>

		 	<!--RECUPERATION DES UTILISATEURS-->
		 	<?php
		 	$connexion=mysqli_connect("localhost","root","","forum");
		 	$ocrequetteuser =("SELECT pseudo FROM utilisateurs ");
		 	$ocassemblageuser = mysqli_query($connexion,$ocrequetteuser);
		 	$recupalluser = mysqli_fetch_all($ocassemblageuser);
		 	$compte =count($recupalluser);

		 	//<--RECUPERATION DES ADMIN-->

		 	$connexion_admin =mysqli_connect("localhost","root","","forum");
		 	$ocrequetteuser_admin =("SELECT pseudo FROM utilisateurs ");
		 	$ocassemblageuser_admin = mysqli_query($connexion_admin,$ocrequetteuser_admin);
		 	$recupalluser_admin = mysqli_fetch_all($ocassemblageuser_admin);
		 	$compte_admin =count($recupalluser_admin);


		 		?>
		 		<!--AFFICHAGE DU TABLEAU DES UTILISATEURS-->
		 	<section class="oc-section-gestionadmin">
		 		<table class="oc-table-gestionadmin">
		 			<thead>
		 				<tr>
		 					<td>pseudo</td><td></td>
		 				</tr>
		 			</thead>

		 			     <form  method="POST" action="" >
		 	<?php

		 	$coup = 0;
		 	while ( $coup < $compte) 
		 	{
		 		//echo "<tr><td>".$recupalluser[$coup][0]."</td>
		 		//<td>"."<a class=\"oc-admin-admin\" href = \"admin-moderateur-verif.php\">'definir en temp qu'Administrateurs"."</td>
		 		//</tr>";	
		 		echo "<tr><td>".$recupalluser[$coup][0]."<input  class=\"buton-admin\" type=\"submit\" name=\"validadmin\"$coup  value=\"definir en temp qu'Administrateurs\">"." </td>
		 		<td></td>
		 		</tr>";	
		 		if (!empty($_POST['validadmin$coup'])) 
		 		{

		 			$_SESSION['pseudoo'] = $recupalluser[$coup][0];
		 			echo "string";
		 			//header('Location:$pseudoo. admin-moderateur-verif.php');
		 		}
		 		$coup = $coup + 1; 
		 	}echo $_SESSION['pseudoo'];
		 	?>
		           
		       </table>
		        </form>
		   </section>
		 </main>
	</body>

</html>