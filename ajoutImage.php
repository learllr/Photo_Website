<?php
    require_once('bdd.php');
    require_once('requêtes.php');
    require_once('menu.php');
?>

<!doctype html>
<html lang="en">
  <head>
    <title> Ajout d'image </title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">
    
    <!-- Bootstrap core CSS -->
    <link rel = "stylesheet" href = "bootstrap/bootstrap.css">
    <link rel = "stylesheet" href = "bootstrap/bootstrap.min.css">

    <style>
    body
    {
        background-color: rgb(245, 245, 245);
    }
    </style>

  </head>
  
  <center>
  <?php

// On vérifie que le membre a validé le formulaire.
if( (isset($_POST['envoyer'])) && ($_POST['envoyer'] = 'Envoyer') )
{
    // On vérifie que le fichier a bien été envoyé et s'il n'y a pas d'erreur.
    if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] == 0)
    {
        // On vérifie que la description est bien remplis.
        if (isset($_POST['desc']))
        { 
            $desc = htmlspecialchars($_POST['desc']);

            // On calcule le nombre de caractères qu'a la description.
            $taille_desc = strlen($desc);

            // La description contient au moins une lettre et ait compris entre 1 et 150 caractères.
            if ( preg_match("#[a-z_A-Z]+#", $_POST['desc']) && ($taille_desc >= 1) && ($taille_desc <= 150) )
            {
                // Vérifie que la catégorie est bien remplis mais n'est pas égale à "--".
                if (isset($_POST['cat']) && $_POST['cat'] != '--')
                {
                    $categorie = htmlspecialchars($_POST['cat']);

                    // Vérifie que la taille de l’image ne doit pas excéder 100 Ko.
                    if ($_FILES['fichier']['size'] <= 100000)
                    {
                        // Vérifie que l'image a une extension autorisée : jpeg, gif, jpg ou png.
                        $infosfichier = pathinfo($_FILES['fichier']['name']);
                        $extension_upload = $infosfichier['extension'];
                        $extensions_autorisees = array('jpeg', 'gif', 'png', 'jpg');
                        if (in_array($extension_upload, $extensions_autorisees))
                        {
                            // Le fichier est renommé en rajoutant DSC- devant.
                            $nom = $_FILES['fichier']['name'];
                            $nomFich = "DSC-".$nom."";

                            // On vérifie que le fichier n'a pas le même nom qu'un autre dans la base de données.
                            if (memeNom($bdd, $nomFich) == 0)
                            {
                                // On ajoute dans le dossier images/ l'image ajoutée.
                                move_uploaded_file($_FILES['fichier']['tmp_name'], './images/' . $_FILES['fichier']['name']);

                                // On récupère l'id de l'utilisateur qui a posté l'image.
                                $req = $bdd->query("SELECT utilisateurId FROM Utilisateur WHERE pseudo = '".$_SESSION['logged']."';");
                                $rep = $req->fetch();
                                $req->closeCursor();

                                // On récupère l'id de l'utilisateur qu'on stocke dans une variable de session pour l'utiliser autre part.
                                $_SESSION['utilisateurId'] = $rep['utilisateurId'];

                                // On ajoute la photo à la base de données avec l'id de la personne qui a posté cette image.
                                ajoutImageBdd($bdd, $nomFich, $desc, $categorie, $rep['utilisateurId']);

                                // On récupère l'id de la photo ainsi que sa catégorie pour l'utiliser ensuite lors de la redirection à sa page de détails.
                                $rep = $bdd->query("SELECT photoId, catId FROM Photo WHERE nomFich = '".$nomFich."' AND description = '".$desc."' AND catId = '".$categorie."';");
                                $reponse = $rep->fetch();
                                $rep->closeCursor();

                                // Suivant si le membre est un admin ou non, il est redirigé sur une certaine page.
                                if($_SESSION['statut'] == "admin")
                                {
                                    header("Location:./detailsLesPhotos.php?id=$reponse[photoId]&categ=$reponse[catId]&visib=$reponse[visible]");
                                }
                                else
                                {
                                    header("Location:./details.php?id=$reponse[photoId]&categ=$reponse[catId]&mesPhotos=oui");
                                }
                            }
                            else 
                            {
                                // Nous changeons le nom du fichier en rajoutant des parenthèses et un i qui s'incrémente derrière le nom.
                                $i = 1;
                                $reserveNom = $nomFich;
                                $nomFich = "$nomFich($i)"; // Exemple : DSC-plage.jpeg -> DSC-plage.jpeg(1) s'il apparaît 2 fois dans la base de données.

                                // Tant qu'un fichier porte le même nom, on ajoute 1 au i.
                                while(memeNom($bdd, $nomFich) !== 0)
                                {
                                    $i++;
                                    $nomFich = "$reserveNom($i)";
                                }
                                
                                // On ajoute dans le dossier images/ l'image ajoutée.
                                move_uploaded_file($_FILES['fichier']['tmp_name'], './images/' . $_FILES['fichier']['name']);

                                // On récupère l'id de l'utilisateur qui a posté l'image.
                                $req = $bdd->query("SELECT utilisateurId FROM Utilisateur WHERE pseudo = '".$_SESSION['logged']."';");
                                $rep = $req->fetch();
                                $req->closeCursor();

                                // On récupère l'id de l'utilisateur qu'on stocke dans une variable de session pour l'utiliser autre part.
                                $_SESSION['utilisateurId'] = $rep['utilisateurId'];

                                // On ajoute la photo à la base de données avec l'id de la personne qui a posté cette image.
                                ajoutImageBdd($bdd, $nomFich, $desc, $categorie, $rep['utilisateurId']);

                                // On récupère l'id de la photo ainsi que sa catégorie pour l'utiliser ensuite lors de la redirection à sa page de détails.
                                $rep = $bdd->query("SELECT photoId, catId FROM Photo WHERE nomFich = '".$nomFich."' AND description = '".$desc."' AND catId = '".$categorie."';");
                                $reponse = $rep->fetch();
                                $rep->closeCursor();

                                // Redirection vers une page.
                                header("Location:./details.php?id=$reponse[photoId]&categ=$reponse[catId]&mesPhotos=oui");
                            } 
                        }
                        else
                        {
                            $msg = "Seulement les extensions jpeg, gif et png sont autorisées !";
                            echo '<font color="red">'."$msg"."</font>";
                        }
                    }
                    else
                    {
                        $msg = "La taille de l’image ne doit pas excéder 100 Ko !";
                        echo '<font color="red">'."$msg"."</font>";
                    }
                }
                else
                {
                    $msg = "Veuillez sélectionner une catégorie !";
                    echo '<font color="red">'."$msg"."</font>";
                }
            }
            else
            {
                $msg = "La description doit contenir au moins une lettre et ne pas excéder 150 caractères !";
                echo '<font color="red">'."$msg"."</font>";
            }
            
        }
        else 
        {
            $msg = "Veuillez remplir la description !";
            echo '<font color="red">'."$msg"."</font>";
        }
    }
    else
    {
        $msg = "Il y a une erreur avec l'image, veuillez remplir le champ ou réessayer !";
        echo '<font color="red">'."$msg"."</font>";
    }
}
?>
</center>

<!-- Formulaire d'ajout d'image qui demande le fichier (l'image), la description ainsi que sa catégorie. -->
  <body>
    <br> <br>
  <center><form method="post" action="ajoutImage.php" enctype="multipart/form-data">
  <div style="width: 400px;">
    <div style="font-size: 30px;">
    <p> Ajouter une photo </p> 
    </div>
    <div class="input-group mb-3">
        <input type="file" class="form-control input-group-text" id="inputGroupFile02" name="fichier">
        <label class="input-group-text" for="inputGroupFile02">Upload</label>
    </div>
    <div class="form-floating">
        <textarea name="desc" minlength="1" maxlength="145" class="form-control" id="floatingTextarea2" style="height: 100px"></textarea>
        <label for="floatingTextarea2">Décrire la photo en une phrase :</label>
    </div> <br>
    <div class="form-floating">
        <select class="form-select" id="floatingSelect" name="cat" aria-label="Floating label select example">
            <option value="--">--</option>
            <option value="1">Animaux</option>
            <option value="2">Art</option>
            <option value="3">Cuisine</option>
            <option value="4">Sport</option>
            <option value="5">Voyage</option>
        </select>
        <label for="floatingSelect">Choisir une catégorie :</label>
    </div> <br>
    <input type = "submit" name="envoyer" class = "btn btn-dark" value = "Envoyer"/>
    <p class="mt-5 mb-3 text-muted">&copy; 2020 &#45; 2021</p>
  </div>
  
  </form></center>

  </body>
</html>