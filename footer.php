<?php 

	if(isset($_GET["deco"]))
	{
		session_destroy();
	}

?>



<footer class="flex just-between head-foot">
	<?php  if(!isset($_SESSION["id"])) { ?>
		<a href="connexion.php">Connexion</a>
		<a href="inscription.php">Inscription</a>
	<?php } 
	else {?>
		<a href="profil.php">profil</a>
		<a href="profil.php?deco=true">Deconnexion</a>
	<?php } ?>
		
	<a href="forum.php">Forums</a>
	
	<?php if(isset($_SESSION["login"]) == "admin") { ?>
		<a href="admin.php">Admin</a>
	<?php } ?>
</footer>