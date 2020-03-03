

<html>
<head>
	   <meta charset="utf-8">
     <link rel="stylesheet" type="text/css" href="css/profil.css">
     <link rel="stylesheet" type="text/css" href="stylesheet.css">

     <title>profil</title>
</head>
       <body class="oc-body-accueil-btp">
  

					 <!--HEADER ADMIN -->
     <section class="section-deventure">    
     <!-- HEADER-->  
  <header class="oc-header-btp">
           <?php include('header.php'); ?>  
  </header>

<?php

 $connexion=mysqli_connect("localhost","root","","forum");
$log=$_SESSION['login'];
$id=$_SESSION['id'];
    if(!isset($_SESSION['login']))
    {
      header("location: connexion.php");
    }





               //si on clique sur la deconnexion
    if (!empty($_POST['deconection'])) 
    {    
    unset ( $_SESSION ['id'] );
    unset ($_SESSION['login']); 
    header("location: index.php");
    }
    ////////////////////////////////////////////////si on viste le profil/////////////////////////////
    if(isset($_GET['id']) AND $_GET['id'] > 0) 
    {
     
    $idvisiter =$_GET['id'];
    $ocreqnom = ("SELECT pseudo FROM utilisateurs WHERE id = $idvisiter");
    $fusionreq = mysqli_query($connexion,$ocreqnom);
    $ocname = mysqli_fetch_assoc($fusionreq);
    }
    /////////////////////////////////////////////si c'est profil perso///////////////////////////////////////
    else
    {
    $ocreqnom = ("SELECT pseudo FROM utilisateurs WHERE id = $id");
    $fusionreq = mysqli_query($connexion,$ocreqnom);
    $ocname = mysqli_fetch_assoc($fusionreq);
    }
?>



    <!--titre-->

    <h1 class="oc-titreh">profil de <?php echo $ocname['pseudo']; ?></h1>
<?php



   if(isset($_GET['id']) AND $_GET['id'] > 0)
   {     ///////////////////////////////////////////////////select image du profil visiter////////////////////////////////
    $reqimg = ("SELECT profilPic FROM utilisateurs WHERE id = $idvisiter");
   }
    else
    {      ///////////////////////////////////////////////select image  de son profil//////////////////
    $reqimg = ("SELECT profilPic FROM utilisateurs WHERE id = $id");
    }
    $reqimgco = mysqli_query($connexion,$reqimg);
    $imgrecup = mysqli_fetch_array($reqimgco);
          if (!empty($imgrecup[0])) 
          {
     # code...
?>
     <img class = "oc-img-profil" src="<?php echo $imgrecup[0] ; ?>" > 
<?php
     }
         else
         {
           ?>
           <img class = "oc-img-profil" src="profilPics/profil.jpg" >
           <?php
         }

           ///////////////////////////////////////////VERIF DE DROITS //////////////////////////////////////////////////////
$id=$_SESSION['id'];

$requet_admin_a = "SELECT id_droits FROM utilisateurs where id = '$id' ";
  $connexion_requet_admin_a = mysqli_query($connexion,$requet_admin_a);
  $resultat_requet_admin_a = mysqli_fetch_assoc($connexion_requet_admin_a);
  $id_droits_a = $resultat_requet_admin_a['id_droits'];
 

if ($id_droits_a == 3  OR $_SESSION['id'] == $_GET['id']) 
{
 
?>
       

  

<main>
  <section class="oc-section-profil">
<?php
   $connexion=mysqli_connect("localhost","root","","forum");




   
          //TABLEAU FORM
?>
<form class="form" method="POST" enctype="multipart/form-data">
  <table class="oc-tablinscri">
          <tr>
            <td>
              <label  for="login">modifier le login :</label>
        </td>
        <td>
              <input type="text" name="login" placeholder="ecrire votre pseudo" value="<?php if(isset($login)){echo $login;} ?>">
            </td>
          </tr>
           <tr>
            <td>
              <label for="image">inserer votre image de profil : </label>
            </td>
            <td>
              <input type="file" name ="image" placeholder="">
            </td>
          </tr>
          <tr>
              <td>
                
                <label  for="password">modifier le mot de passe :</label>
              </td>
              <td>
                <input type="password" name="password" placeholder="ecrire votre mot de passe">
              </td>
          </tr>
          <tr>
               <td>
                <label  for="newpassword2">confirmer votre mot de passe :</label>
              </td>
              <td>
                <input type="password" name="password2" placeholder="ecrire votre mot de passe">
              </td>
          </tr>
          
        </table>
        <br/>
                   <input  class="buton-inscription" type="submit" name="modif" value="modifier le profil !"/>
         
<?php //////////////////////////////modif formulaire//////////////////////////////////////////
      if (!empty($_POST['modif']))
       {       
       if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['password2'])) 
       {               
            if (($_POST['password']) == ($_POST['password2']))  
                 {             
                  $login= htmlspecialchars($_POST["login"]);
                  $password= password_hash($_POST["password"], PASSWORD_DEFAULT,array('cost'=> 12));
                  $reqdoublon = "SELECT pseudo FROM `utilisateurs` where pseudo =\"$login\";";
                  $req=mysqli_query($connexion,$reqdoublon); 
                  $retour=mysqli_num_rows($req);

                           if($retour==0)
                           {             
                              if (isset($_POST['image'])) 
                              {
                                $ocnewimg = $_POST['image'];
                              }
                                      
                           $requeteupdate ="UPDATE utilisateurs SET pseudo = '$login' , mdp = '$password' WHERE id='$id'";        
                             $inser= mysqli_query($connexion,$requeteupdate);
                             header("location: profil.php?id=".$id_user_profil."");
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
  //enregistrement de limage
                               if (isset($_FILES['image']))
                                { 
                                 
                                   $taillemax = 2097152 ;  
                                   $extensionvalide = array('jpg', 'jpeg', 'gif', 'png');  
                                     if ($_FILES['image']['size'] <= $taillemax)
                                      { 
                                        // met tous les carractere en minuscule                                    1=limite de chaine
                                         $extensionupload = strtolower(substr(strchr($_FILES['image']['name'],'.'), 1));
                                         //verif extention
                                             if (in_array($extensionupload, $extensionvalide)) 
                                             {
                                               $chemin = "profilPics/".".".$_SESSION['id'].".".$extensionupload;
                                               $couenta = move_uploaded_file($_FILES['image']['tmp_name'], $chemin);
                                                    if ($couenta)
                                                     {
                                                      $requeteupdate ="UPDATE utilisateurs SET  profilPic = '$chemin'  WHERE id='$id'"; 
                         
                                                      $inser= mysqli_query($connexion,$requeteupdate);

                ///////////////////////////////////////verif l'identité pour modifier le profil////////////////////////////////////////
                                                      $connexion=mysqli_connect("localhost","root","","forum");
                                                      $id_user = $_SESSION['id'];
                                                      $requette_id = "SELECT id FROM utilisateurs where id = $id_user ";
                                                      $requette_id_connexion = mysqli_query($connexion,$requette_id);
                                                      $result_id = mysqli_fetch_assoc($requette_id_connexion);
      
                                                      $id_user_profil = $result_id['id'];
                                                      header("location: profil.php?id=".$id_user_profil."");
                                                     }
                                                     else
                                                     {
                                                       echo "erreur lors du telechargement !";
                                                     }
                                             }
                                             else
                                             {
                                              echo "votre imga doit etre au format jpg, jpeg, gif, png";
                                             }
                                      }
                                      else
                                      {
                                        echo "votre foto ne doit pas depasser 2 mo";
                                      }
                                 }   
                                 //fin avatar  
}
}
?>
  </form> 
  
<?php

/////////////////////////////////////////////////////si on visite un profil
 if(isset($_GET['id']) AND $_GET['id'] > 0)
 {

///////////////////////////////////////////VERIF DE DROITS //////////////////////////////////////////////////////
$id=$_SESSION['id'];

$requet_admin_a = "SELECT id_droits FROM utilisateurs where id = '$id' ";
  $connexion_requet_admin_a = mysqli_query($connexion,$requet_admin_a);
  $resultat_requet_admin_a = mysqli_fetch_assoc($connexion_requet_admin_a);
  $id_droits_a = $resultat_requet_admin_a['id_droits'];


    if ($id_droits_a == 3 )
    {
      # code...
    
echo "string";

  $requet_admin = "SELECT id_droits FROM utilisateurs where id = '$idvisiter' ";
  $connexion_requet_admin = mysqli_query($connexion,$requet_admin);
  $resultat_requet_admin = mysqli_fetch_assoc($connexion_requet_admin);

  $id_droits = $resultat_requet_admin['id_droits'];
 

///////////////////////////////////////////CONDITION POUR UTILISATEUR/////////////////////////////////////////////
  if ($id_droits == 1 ) 
  {
    ?>

    <form method="POST" action="">
      <input class="oc-zindex-profil-definir-admin" type="submit" name="bouton-valid-admin" value="definir en temps qu'administrateur">
      <input class="oc-zindex-profil" type="submit" name="bouton-supression-moderateur" value="definir en temp que moderateur">
    </form>
   
    <?php
    if (isset($_POST['bouton-valid-admin']))
     {
       $requete_modif_admin_1 ="UPDATE utilisateurs SET  id_droits = '3'  WHERE id='$idvisiter'";
       $connexion_requete_modif_1 = mysqli_query($connexion,$requete_modif_admin_1);
       header("location: profil.php?id=".$_GET['id']."");
     }
     if (isset($_POST['bouton-supression-moderateur'])) 
     {
       $requete_modif_admin_11 ="UPDATE utilisateurs SET  id_droits = '2'  WHERE id='$idvisiter'";
       $connexion_requete_modif_11 = mysqli_query($connexion,$requete_modif_admin_11); 
       header("location: profil.php?id=".$_GET['id']."");
     }
  }
  ///////////////////////////////////si moderateur////////////////////////////////////////////////////////////////////////////////
  elseif ( $id_droits == 2 ) 
  {
    ?>

    <form method="POST" action="">
      <input class="oc-zindex-profil-definir-admin" type="submit" name="bouton-valid-admin" value="definir en temps qu'administrateur">
      <input class="oc-zindex-profil" type="submit" name="bouton-supression-moderateur" value="suprimé en temp que moderateur">
    </form>
    
    <?php
    if (isset($_POST['bouton-valid-admin']))
     {
       $requete_modif_admin_1 ="UPDATE utilisateurs SET  id_droits = '3'  WHERE id='$idvisiter'";
       $connexion_requete_modif_1 = mysqli_query($connexion,$requete_modif_admin_1);
       header("location: profil.php?id=".$_GET['id']."");
     }
     if (isset($_POST['bouton-supression-moderateur'])) 
     {
       $requete_modif_admin_11 ="UPDATE utilisateurs SET  id_droits = '1'  WHERE id='$idvisiter'";
       $connexion_requete_modif_11 = mysqli_query($connexion,$requete_modif_admin_11); 
       header("location: profil.php?id=".$_GET['id']."");
     }
  }
  //////////////////////////////////////////////////////////si admin/////////////////////////////////////////////////////////////
  elseif ( $id_droits == 3 )
   {
    ?>

    <form method="POST" action="">
      <input class="oc-zindex-profil" type="submit" name="bouton-suprime-admin" value="suprimé en temps qu'administrateur">
      <input class="oc-zindex-profil" type="submit" name="bouton-valid-moderateur" value="metre en temp que moderateur">
    </form>
  
    <?php
    if (isset($_POST['bouton-suprime-admin']))
     {
       $requete_modif_admin_2 ="UPDATE utilisateurs SET  id_droits = '1'  WHERE id='$idvisiter'";
       $connexion_requete_modif_2 = mysqli_query($connexion,$requete_modif_admin_2);
       header("location: profil.php?id=".$_GET['id']."");
     }
     if (isset($_POST['bouton-valid-moderateur'])) 
     {
       $requete_modif_admin_2 ="UPDATE utilisateurs SET  id_droits = '2'  WHERE id='$idvisiter'";
       $connexion_requete_modif_2 = mysqli_query($connexion,$requete_modif_admin_2); 
       header("location: profil.php?id=".$_GET['id']."");
     }
  }
  else
  {
    
  }
  ?>
      <form method="POST" action="">
      <input class="oc-supression-user" type="submit" name="bouton-suprime-user" value="suprimé l'utilisateur">
    </form> 
     </section>
  <?php
      if (isset($_POST['bouton-suprime-user'])) 
      {
        
      }
  }
}
?>



</main>
  <!--FOOTER-->

</body>
</html>