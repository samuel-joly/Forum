<?php 
	session_start();
	include("function.php");
	
	if(isset($_GET["deco"]))
	{
		session_destroy();
		header("location: connexion.php");
	}

?>



<header class="flex just-between head-foot">
	<?php  if(!isset($_SESSION["id"])) { ?>
		<a href="connexion.php">Connexion</a>
		<a href="inscription.php">Inscription</a>
	<?php } 
	else {
		///////////////////////////////////////verif l'identité pour modifier le profil////////////////////////////////////////
		$connexion=mysqli_connect("localhost","root","","forum");
		$id_user = $_SESSION['id'];
		  $requette_id = "SELECT id FROM utilisateurs where id = $id_user ";
		  $requette_id_connexion = mysqli_query($connexion,$requette_id);
		  $result_id = mysqli_fetch_assoc($requette_id_connexion);
		  
		  $id_user_profil = $result_id['id'];
		?>

		<a href="<?php echo "profil.php?id=".$id_user_profil." "?> ">profil</a>
		<a href="profil.php?deco=true">Deconnexion</a>
	<?php } 
////////////////////////////////////////////////////////fin de liens vers le profil////////////////////////////////////////////
	?>
		
	<a href="forum.php">Forums</a>
	
	<?php if(!empty($_SESSION["login"]) ) 
	{
	  if ($_SESSION["login"] == "admin" ) 
	   { ?>
   
		<a href="admin.php">Admin</a>
<?php  }
	}	   ?>
</header>