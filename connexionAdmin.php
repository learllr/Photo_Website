<?php
  require_once('bdd.php');
  require_once('requêtes.php');
  require_once('menu.php');
?>

<!doctype html>
<html lang="en">
  <head>
    <title> Connexion administrateur </title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">
    
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
    max-width: 330px;
    padding: 15px;
    margin: auto;
  }

  .form-signin .checkbox 
  {
    font-weight: 400;
  }

  .form-signin .form-floating:focus-within 
  {
    z-index: 2;
  }

  .form-signin input[type="text"] 
  {
    margin-bottom: -1px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
  }

  .form-signin input[type="password"] 
  {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
  }

  .bd-placeholder-img 
  {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }

  nav
  {
    background-color: #1D1D1D;
  }

  nav a
  {
    color: #999;
    text-decoration: none;
  }

  nav a:hover
  {
    color: #fff;
  }

  #idf, #mdp
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

  #pasInscrit
  {
    position: relative;
    top: 20px;
    color:rgb(43, 43, 43);
  }

  #pasInscrit:hover
  {
    color: rgb(25, 104, 207);
  }

  </style>
  </head>

<?php 
// On vérifie que le membre a validé le formulaire.
if( (isset($_POST['connexion'])) && ($_POST['connexion'] = 'Connexion') )
{
  // On vérifie que l'identifiant et le mot de passe ont été remplis.
  if ( (isset($_POST['idf']) && !empty($_POST['idf'])) && (isset($_POST['mdp']) && !empty($_POST['mdp'])))
  {
    $pseudo = htmlspecialchars($_POST['idf']);

    // Cryptage du mot de passe.
    $mdp = md5($_POST['mdp']);

    // On vérifie que l'utilisateur existe.
    if (utilisateurExiste($pseudo, $mdp, $bdd) == 1)
    {
      // On récupère le statut d'un membre (admin ou utilisateur).
      $resultat = $bdd->query("SELECT statut FROM Utilisateur WHERE pseudo = '".$pseudo."';");
      $rep = $resultat->fetch();
      $resultat->closeCursor();

      // On vérifie que le membre est un administrateur.
      if ($rep['statut'] == "admin")
      {
        // Il est connecté car il est dans le bon espace.
        connecteUtilisateur($pseudo, $bdd); 

        // Il est redirigé sur la page des statistiques.
        header('Location:./statistiques.php'); 

        // On récupère le pseudo de l'utilisateur, son mot de passe et son statut qu'on stocke dans une variable de session pour l'utiliser autre part.
        $_SESSION['logged'] = $pseudo;
        $_SESSION['mdp'] = $mdp;
        $_SESSION['statut'] = $rep['statut'];
      }
      // Si le membre est un utilisateur, il n'est pas dans le bon espace.
      else if($rep['statut'] == "utilisateur")
      {
        $msg = "Pour vous connecter à l'espace utilisateur, veuillez cliquer sur le bouton vert en haut à droite !";
        echo '<font color="red">'."$msg"."</font>";
      }?>
      </div><?php
    }
    else
    {
      $msg = "Identifiant ou mot de passe incorrect !";
      echo '<font color="red">'."$msg"."</font>";
    }
  }
  else 
  {
    $msg = "Tous les champs doivent être complétés !";
    echo '<font color="red">'."$msg"."</font>";
  }
}?>

<!-- Formulaire de connexion de l'espace utilisateur qui demande un identifiant et un mot de passe -->
<div style="position: absolute; right: 100px; top: 88px; color: white;">
<a href="connexion.php" role="button" class="btn btn-success">Espace utilisateur</button> </a>
</div>
<div class = "body" >
<body class="text-center">  
<main class="form-signin" style="position: relative; top: -100px;">
  <form method="post" action="connexionAdmin.php">	
  <h1 class="h3 mb-3 fw-normal"> Veuillez vous connecter à l'espace administrateur</h1>
  <div class="form-floating">
    <label id = "idf" for="idf"> Identifiant </label>
    <input name = "idf" type="text" class="form-control" id="floatingInput" >
  </div>
  <div class="form-floating">
    <label id = "mdp" for="mdp"> Mot de passe </label>
    <input name="mdp" type="password" class="form-control" id="floatingPassword" placeholder="Mot de passe">
  </div>

  <input class="w-100 btn btn-lg btn-primary" name = "connexion" type="submit" value="Connexion"> </button>
  </form>
  <a id ="pasInscrit" href = "inscription.php" > Je ne suis pas inscrit. </a>
  <p class="mt-5 mb-3 text-muted">&copy; 2020 &#45; 2021</p>
</main>

</body>
</div>
</html>

