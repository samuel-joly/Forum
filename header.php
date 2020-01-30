<?php 
	session_start();
	include("function.php");

?>



<header>
	<?php  if(!isset($_SESSION["id"])) { ?>
		<a href="connexion.php">Connexion</a>
		<a href="inscription.php">Inscription</a>
	<?php } ?>
		
	<a href="forum.php">Forums</a>
	
	<?php if(isset($_SESSION["admin"])) { ?>
		<a href="admin.php">Admin</a>
	<?php } ?>
</header>