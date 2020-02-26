<?php 
	session_start();
	include("function.php");

?>



<header>
	<?php  if(!isset($_SESSION["id"])) { ?>
		<a href="connexion.php">Connexion</a>
		<a href="inscription.php">Inscription</a>
	<?php } ?>

	<?php if (isset($_SESSION["id"])) {?>
		<a href="profil.php">profil</a>
	<?php } ?>
		
	<a href="forum.php">Forums</a>
	
	<?php if(!empty($_SESSION["login"]) ) 
	{
              if ($_SESSION["login"] == "admin" ) 
               {
              			# code...
              				?>
		<a href="admin.php">Admin</a>
<?php } 
              }?>
	<?php if (isset($_POST["oc-deco"])) { 
		session_destroy();
	}
	
	?>
		

	

	<form method="POST" action="">
	<label for="oc-deco"></label>
	<input type="submit" name="oc-deco" value="deconnection">
	</form>
</header>