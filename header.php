<?php 
	session_start();
	include("function.php");
if (isset($_SESSION['id'])) {
	$id = $_SESSION['id'];
}
	

	if(isset($_GET["deco"]))
	{
		session_destroy();
		header("location: connexion.php");
	}

?>

<header class="flex  head-foot">
	<?php  if(!isset($_SESSION["id"])) { ?>
		<a class="oc-color-blue" href="connexion.php">Connexion</a>
		<a class="oc-color-white" href="inscription.php">Inscription</a>
	<?php } 
	else { ?>

		<a class="oc-color-blue" href="profil.php?<?php echo"id=$id"; ?> ">profil</a>
		<a class="oc-color-white" href="profil.php?deco=true">Deconnexion</a>
	<?php } ?>
		
	<a class="oc-color-red" href="forum.php">Forums</a>
	
</header>