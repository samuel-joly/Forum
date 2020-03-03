<?php 

	if(isset($_GET["deco"]))
	{
		session_destroy();
	}

?>

<link rel="stylesheet" type="text/css" href="css/oliv-footer.css">

<footer class="flex just-between head-foot">
	<?php  if(!isset($_SESSION["id"])) { ?>
		<a class="oc-color-blue" href="connexion.php">Connexion</a>
		<a class="oc-color-white" href="inscription.php">Inscription</a>
	<?php } 
	else {?>
		<a class="oc-color-blue" href="profil.php">profil</a>
		<a class="oc-color-white" href="profil.php?deco=true">Deconnexion</a>
	<?php } ?>
		
	<a class="oc-color-red" href="forum.php">Forums</a>
	
	
</footer>