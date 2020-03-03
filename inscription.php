<?php

	$connexion=mysqli_connect("localhost","root","","forum");

?>
<DOCTYPE html>
<html>
<head>
	   <meta charset="utf-8">
     <link rel="stylesheet" type="text/css" href="css/inscription.css">
     <title>inscription</title>
</head>
       <body class="oc-body-incription">
  

					 <!--HEADER ADMIN -->
     <section class="oc-section-deventure">      
     	<main>
     		<header class="">
<?php         
            	include ('header.php'); 
?>
        	</header>
             	<h1 class="oc-titre-inscr">Insrivez-vous !<h1>
                        <form class="oc-form" method="POST" action=""  >
<?php

                          


if (!empty($_POST["submit"])) 
{

      if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['password2'])) 
      {
                 if (($_POST['password']) == ($_POST['password2']))  
                 {    
                 	 //si utilisateur existe deja

                  $login= htmlspecialchars($_POST["login"]);
                 
                  $password= password_hash($_POST["password"], PASSWORD_DEFAULT,array('cost'=> 12));
                  $reqdoublon = "SELECT pseudo FROM `utilisateurs` where pseudo=\"$login\";";           
                  $req=mysqli_query($connexion,$reqdoublon);               
                  $retour=mysqli_num_rows($req);
                 
                           if($retour==0)
                           {       
                             $zero = 1;
                                 //insertion utilisateur                 
                            $help = "profilPics/profil.jpg";
                            $requete="INSERT INTO utilisateurs (pseudo,profilPic,mdp,id_droits)
                            VALUES (\"$login\",\"$help\",\"$password\",\"$zero\")";    
                            $inser= mysqli_query($connexion, $requete);


                            /////selection de ID pour ID_utilisateur
                           $requette_selectionid = "SELECT id FROM utilisateurs";
                            $connexion_bdd_id = mysqli_query($connexion,$requette_selectionid);
                            $compte_le_nombreid = mysqli_num_rows($connexion_bdd_id);
                            $numero_dernier_inscrit = $compte_le_nombreid -1;
                            $dernier_id = mysqli_fetch_all($connexion_bdd_id);   
                            $nombreid = $dernier_id[$numero_dernier_inscrit][0];                    
                       ///////////$dernier_id[$numero_dernier_inscrit][0]; l'id du drenier inscrit

                           
                            /////insertion administrateurs
                            
                           $inseradmin = "INSERT INTO administrateurs (id_utilisateur,admin,moderateur)
                            VALUES (\"$nombreid\",\"$zero\",\"$zero\")";
                            $insertion_admin = mysqli_query($connexion,$inseradmin);
                            
                        
                             header("location: connexion.php");
                          
                          } 
                          else
                          {
                            echo "ce login existe deja !";
                          }
               }
               else
               {
                echo "les passwords ne sont pas identiques !";
               }
    }
  else
  {
    echo "tous les champs doivent etre complétés !";
  }

}

 

?> 

 <table class="oc-tablinscri" class="oc-tableconnexionprofil ">
          <tr>
            <td>
              <label  for="login"> login :</label>
        </td>
        <td>
              <input type="text" name="login" placeholder="ecrire votre pseudo" value="<?php if(isset($login)){echo $login;} ?>">
            </td>
          </tr>
       
          <tr>
              <td>
                
                <label  for="password">mot de passe :</label>
              </td>
              <td>
                <input type="password" name="password" placeholder="ecrire votre mot de passe">
              </td>
          </tr>
          <tr>
               <td>
                <label  for="password2">confirmer votre mot de passe :</label>
              </td>
              <td>
                <input type="password" name="password2" placeholder="ecrire votre mot de passe">
              </td>
          </tr>
          
          
        </table>
        <br/>
                <input  class="buton-inscription" type="submit" name="submit" value="s'inscrire"/>   
          </form>


</section>
       </main>
