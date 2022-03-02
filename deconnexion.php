<?php
  require_once('bdd.php');
  require_once('requêtes.php');
  require_once('menu.php');
?>

<!doctype html>
<html lang="en">
  <head>
    <title> Déconnexion </title>
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

  .bd-placeholder-img 
  {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }

  form h1
  {
    background-color: rgb(255, 255, 255);
    position: relative;
    bottom: 25px;
  }

  .form-signin 
  {
    width: 100%;
    max-width: 530px;
    padding: 15px;
    margin: auto;
  }

  </style>

  </head>
  
<?php

  // On vérifie que l'utilisateur a cliqué sur "oui" (il veut se déconnecter).
  if (isset($_POST['oui']))
  {
    // S'il était connecté.
    if (isset($_SESSION['logged']))
    {
      // Il est alors déconnecté.
      deconnecteUtilisateur($_SESSION['logged'], $bdd);

      // Les variables de session sont alors supprimées.
      session_start();
      session_destroy();

      // Le membre est redirigé sur la page d'accueil.
      header('Location:./index.php?deco=oui'); 
    }  
  }
  // Si l'utilisateur a cliqué sur "non" (il ne veut pas se déconnecter).
  else if (isset($_POST['non']))
  {
    // Le membre est redirigé sur la page d'accueil.
    header('Location:./index.php');
  } ?>

<!-- Formulaire qui demande si le membre souhaite être déconnecté (oui ou non). -->
<body>
  <center>
  <div class = "body" >
<main class="form-signin">
  <form method="post" action="./deconnexion.php">

    <h1 class="h3 mb-3 fw-normal"> Souhaitez-vous vous déconnecter? </h1>

    <button style="width: 80px;" type = "submit" id = "oui" name = "oui" type="button" class="btn btn-success">Oui</button>
    <button style="width: 80px;" type = "submit" id = "non" name = "non" type="button" class="btn btn-danger">Non</button>
    <br> <br>
    <p class="mt-5 mb-3 text-muted">&copy; 2020 &#45; 2021</p>
    
  </form>
</main>
</div>
</center>
</body>
</html>

