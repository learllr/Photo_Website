<?php
  require_once('bdd.php');
  require_once('requêtes.php');
  require_once('menu.php');
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Premi&egrave;re inscription</title>
  
  <!-- Bootstrap core CSS -->
  <link rel = "stylesheet" href = "bootstrap/bootstrap.css">
  <link rel = "stylesheet" href = "bootstrap/bootstrap.min.css">

  <style>

  html, body 
  {
    height: 100%;
    background-color: rgb(245, 245, 245);
  }

  .body
  {
    position: relative;
    top : 200px;
  }

  .form-signin 
  {
    width: 100%;
    max-width: 350px;
    padding: 15px;
    margin: auto;
  }

  .form-signin .checkbox 
  {
    font-weight: 400px;
  }

  .bd-placeholder-img 
  {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }

  #idf, #mdp, #confirmmdp
  {
    position: absolute;
    top: -15px;
  }

  form h1
  {
    background-color: rgb(255, 255, 255);
    position: relative;
    bottom: 25px;
  }

  #inscrit
  {
    position: relative;
    top: 20px;
    color:rgb(43, 43, 43);
  }

  #inscrit:hover
  {
    color: rgb(25, 104, 207);
  }

  .form-signin input[type="text"] 
  {
    margin-bottom: 10px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
  }

  .form-signin input[type="password"] 
  {
    margin-bottom: 10px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
  }

  </style>
  
</head>

<br> <br>

<!-- Formulaire d'inscription qui demande un identifiant, un mot de passe et une confirmation de mot de passe. -->
<div class = "body" >
<body class="text-center">  
<main class="form-signin" style="position: relative; bottom: 130px;">
<form method="post" action="inscription.php">	

    <h1 class="h3 mb-3 fw-normal"> Veuillez vous inscrire </h1>

    <div class="form-floating">
      <label id = "idf" for="floatingInput"> Identifiant </label>
      <input name="idf" type="text" class="form-control" id="floatingInput" >
    </div>
    <div class="form-floating">
      <label id = "mdp" for="floatingPassword"> Mot de passe </label>
      <input name="mdp" type="password" class="form-control" id="floatingPassword" placeholder="Mot de passe">
    </div>
    <div class="form-floating">
      <label id = "confirmmdp" for="floatingPassword"> Confirmation mot de passe </label>
      <input name="mdp2" type="password" class="form-control" id="floatingPassword" placeholder="Mot de passe">
    </div>

    <input class="w-100 btn btn-lg btn-primary" name = "connexion" type="submit" value="Connexion"> </button>

    <a id ="inscrit" href = "connexion.php" > Je suis déjà inscrit. </a>

    <p class="mt-5 mb-3 text-muted">&copy; 2020 &#45; 2021</p>
    
  </form>
</main>
 
<?php

// On vérifie que le visiteur a correctement saisi puis envoyé le formulaire.
if( (isset($_POST['connexion'])) && ($_POST['connexion'] = 'Connexion') )
{
  // On vérifie que l'identifiant, le mot de passe et la confirmation du mot de passe ont été remplis.
  if ( (isset($_POST['idf']) && !empty($_POST['idf'])) && (isset($_POST['mdp']) && !empty($_POST['mdp'])) && (isset($_POST['mdp2']) && !empty($_POST['mdp2'])) )
  {
    $pseudo = htmlspecialchars($_POST['idf']);
    $mdptemp = $_POST['mdp'];

    // Cryptage des mots de passe.
    $mdp = md5($_POST['mdp']);
    $mdp2 = md5($_POST['mdp2']);

    // Calcule du nombre de caractères du pseudo et de l'ancien mot de passe.
    $taillePseudo = strlen($pseudo);
    $tailleMdp = strlen($mdptemp);

    // On vérifie que le pseudo est disponible.
    if(pseudoDispo($pseudo, $bdd) == 0)
    {
      // On vérifie que le pseudo est compris entre 3 et 30 caractères et le mot de passe entre 8 et 40 caractères.
      if ( ($taillePseudo <= 30) && ($taillePseudo >= 3) && ($tailleMdp <= 40) && ($tailleMdp >= 8) )
      {
        // On vérifie que le mot de passe et la confirmation de celui-ci sont identiques.
        if($mdp == $mdp2)
        {
          // On ajoute le nouvel utilisateur à la base de données.
          nouveauUtilisateur($pseudo, $mdp, $bdd);
          
          ?>
          <div style="position: relative; bottom: 660px;">
          <?php
          $msg = "Votre compte a bien été créé ! <br> <a href=\"connexion.php\"> Me connecter </a>";
          echo '<font color="green">'."$msg"."</font>";?>
          </div> <?php
        }
        else
        {
          $msg = "Les deux mots de passes ne correspondent pas !";
          echo '<font color="red">'."$msg"."</font>";
        }
      }
      else 
      {
        $msg = "Votre identifiant doit être compris entre 3 et 30 caractères et votre mot de passe entre 8 et 40 caractères !";
        echo '<font color="red">'."$msg"."</font>";
      }
    }
    else 
    {
    $msg = "L'identifiant est déjà utilisé !";
    echo '<font color="red">'."$msg"."</font>";
    }
  }
  else
  {
    $msg = "Tous les champs doivent être complétés !";
    echo '<font color="red">'."$msg"."</font>";
  }
}

?>

  </body>
</div>
    
</html>
