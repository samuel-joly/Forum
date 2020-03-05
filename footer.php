<?php 

	if(isset($_GET["deco"]))
	{
		session_destroy();
	}

?>
<!--  -->

<footer class="flex  head-foot">
	<?php  if(!isset($_SESSION["id"])) { ?>
		<a class="oc-color-blue" href="connexion.php">Connexion</a>
		<a class="oc-color-white" href="inscription.php">Inscription</a>
	<?php } 
	else {?>
		<a class="oc-color-blue" href="profil.php">profil</a>
		<a class="oc-color-white" href="profil.php?deco=true">Deconnexion</a>
	<?php } ?>
		
	
	<?php if(isset($_SESSION["login"]) == "admin") { ?>
		<a href="admin.php" class="oc-color-blue" >Admin</a>
	<?php } ?>

	<a class="oc-color-red" href="forum.php">Forums</a>
	
</footer>