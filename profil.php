

<html>
<head>
	   <meta charset="utf-8">
     <link rel="stylesheet" type="text/css" href="css/profil.css">

     <title>profil</title>
</head>
       <body class="oc-body-accueil-btp">
  

					 <!--HEADER ADMIN -->
     <section class="section-deventure">    
     <!-- HEADER-->  
  <header class="oc-header-btp">
           <?php include ('header.php'); ?>  
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
    $ocreqnom = ("SELECT pseudo FROM utilisateurs WHERE id = $id");
    $fusionreq = mysqli_query($connexion,$ocreqnom);
    $ocname = mysqli_fetch_assoc($fusionreq);

?>



    <!--titre-->
    <h1 class="oc-titreh">profil de <?php echo $ocname['pseudo']; ?></h1>
<?php
  $reqimg = ("SELECT profilPic FROM utilisateurs WHERE id = $id");
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
?>
       

  

<main>
  <section>
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
         
<?php
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
                         //  echo "test";
                          // $ocnewimg = $_POST['image'];           
                           //$requeteupdate ="UPDATE utilisateurs SET pseudo = '$login', profilPic = 'profilpics/$ocnewimg' , mdp = '$password' WHERE id='$id'"; 
                         
                           //  $inser= mysqli_query($connexion,$requeteupdate);
                          
                       ;
                          
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
                                                      
                                                      $requeteupdate ="UPDATE utilisateurs SET pseudo = '$login', profilPic = '$chemin' , mdp = '$password' WHERE id='$id'"; 
                         
                                                      $inser= mysqli_query($connexion,$requeteupdate);
                                                           header("location: profil.php");
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


               // $reqecolog = "SELECT  login FROM utilisateurs where id='".$_SESSION['id']."'";
//$reqlog = mysqli_query($connexion,$reqecolog);
//$loginid = mysqli_fetch_row($reqlog);


?>
</form> 
  </section>


</main>
  <!--FOOTER-->

</body>
</html>