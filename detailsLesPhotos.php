
<?php
    require_once('bdd.php');
    require_once('requêtes.php');
    include("menu.php");
?>

<!doctype html>
<html lang="en">
  <head>
    <title> Détails de toutes les photos </title>
    
    <!-- Bootstrap core CSS -->
    <link rel = "stylesheet" href = "bootstrap/bootstrap.css">
    <link rel = "stylesheet" href = "bootstrap/bootstrap.min.css">

    <style>
    body
    {
        background-color: white;
    }

    #menu2
    {
        background-color: #ECECEC;
    }

    #menu2 a
    {
        color: #323232;
    }

    p
    {
        font-weight: bold;
        font-size: 30px;
    }
    </style>

  </head>

<br>

</html>

<?php

// On vérifie que le membre a validé le formulaire.
if(isset($_GET['form']) && $_GET['form'] == "envoyer")
{
    // On récupère l'id de la photo et de la catégorie qu'on stocke dans une variable de session pour l'utiliser autre part.
    $idPhoto = $_SESSION['id'];
    $idCategorie = $_SESSION['categ'];

    // On vérifie que la description est bien remplis.
    if(isset($_POST['desc']))
    {
        $desc = htmlspecialchars($_POST['desc']);

        // On calcule le nombre de caractères qu'a la description.
        $taille_desc = strlen($desc);

        // La description contient au moins une lettre et ait compris entre 1 et 150 caractères.
        if ( preg_match("#[a-z_A-Z]+#", $_POST['desc']) && ($taille_desc > 0) && ($taille_desc <= 150) )
        {
            // On met à jour la description dans la base de données.
            $resultat = $bdd->query("UPDATE Photo SET description = '".$desc."' WHERE photoId ='".$idPhoto."';");
            $resultat->closeCursor();

            // On redirige le membre vers le détail de la photo.
            header("Location:./detailsLesPhotos.php?id=$idPhoto&categ=$idCategorie&action=modifier&form=envoyer&descr=oui");?>
            <?php
        }
    }
    // On vérifie que la catégorie est bien remplis et qu'elle ne contient pas "--".
    if(isset($_POST['cat']) && $_POST['cat'] !== "--")
    {
        $cat = htmlspecialchars($_POST['cat']);

        // On met à jour la description dans la base de données.
        $resultat = $bdd->query("UPDATE Photo SET catId = '".$cat."' WHERE photoId ='".$idPhoto."';");
        $resultat->closeCursor();

        // On redirige le membre vers le détail de la photo.
        header("Location:./detailsLesPhotos.php?id=$idPhoto&categ=$idCategorie&action=modifier&form=envoyer&descr=oui");
    }
    // On fait le cas où aucun des deux champs n'est remplis.
    if(isset($_POST['desc']) && ($_POST['desc'] == "") && (isset($_POST['cat']) && $_POST['cat'] == "--"))
    {?>
        <div style="position: absolute; left: 115px; top: 205px;"> <?php
            $msg = "Veuillez compléter au moins un champ !";
            echo '<font color="red">'."$msg"."</font>"; ?>
        </div> <?php
    }
}

// On vérifie que la photo chosie a bien une catégorie.
if(isset($_GET['categ']))
{
    $idCategorie = $_GET['categ'];?>
    <div class="container d-flex flex-column flex-md-row justify-content-between" id="menu2">
    <?php

    // Suivant la catégorie de la photo choisie, un deuxième menu va s'afficher avec l'affichage des autres catégories.
    if ($idCategorie == 1)
    {
        ?>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=tp" > Toutes les photos </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=2" > Art </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=3" > Cuisine </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=4" > Sport </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=5" > Voyage </a> <br>
        <?php
    }
    else if ($idCategorie == 2)
    {
        ?>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=tp" > Toutes les photos </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=1" > Animaux </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=3" > Cuisine </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=4" > Sport </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=5" > Voyage </a> <br>
        <?php
    }
    else if ($idCategorie == 3)
    {
        ?>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=tp" > Toutes les photos </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=1" > Animaux </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=2" > Art </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=4" > Sport </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=5" > Voyage </a> <br>
        <?php
    }
    else if ($idCategorie == 4)
    {
        ?>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=tp" > Toutes les photos </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=1" > Animaux </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=2" > Art </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=3" > Cuisine </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=5" > Voyage </a> <br>
        <?php
    }
    else if ($idCategorie == 5)
    {
        ?>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=tp" > Toutes les photos </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=1" > Animaux </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=2" > Art </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=3" > Cuisine </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./lesPhotos.php?cat=4" > Sport </a> <br>
        <?php
    }

    // On crée une variable de session de la catégorie de la photo pour la réutiliser autre part.
    $_SESSION['categ'] = $idCategorie;
}
?>
</div> <?php

/// On vérifie que la photo chosie a bien un id.
if(isset($_GET['id']))
{
    $idPhoto = $_GET['id'];

    // On réalise une requête qui récupère la photo avec toutes ses informations.
    $reponse = $bdd->query("SELECT * FROM Photo WHERE photoId = '".$idPhoto."';");?>

    <center> <br><p> Les détails sur cette photo </p> <br><br>
    <?php
    while($donnees = $reponse->fetch())
    {
        ?>
        <table class="table table-bordered" style="max-width: 400px; width: 400px; position: absolute; left: 740px; top: 320px;">
        <tbody>
            <tr>
                <!-- On affiche la description de la photo. -->
                <th scope="row">Description</th>
                <td><?php echo $donnees['description']; ?></td>
            </tr>
            <tr>
                <!-- On affiche le nom de la photo. -->
                <th scope="row">Nom du fichier</th>
                <td><?php echo $donnees['nomFich']; ?></td>
            </tr>
            <tr>
                <!-- On affiche la catégorie de la photo transformant l'id de la catégorie en nom (1 -> Animaux). -->
                <th scope="row">Catégorie</th>
                <td>
                <?php
                    if ($donnees['catId'] == 1)
                    { ?>
                        <a href="./lesPhotos.php?cat=1" > Animaux</a> <br> <?php
                    }
                    else if ($donnees['catId'] == 2)
                    { ?>
                    <a href="./lesPhotos.php?cat=2" > Art</a> <br> <?php
                    }
                    else if ($donnees['catId'] == 3)
                    { ?>
                    <a href="./lesPhotos.php?cat=3" > Cuisine</a> <br> <?php
                    }
                    else if ($donnees['catId'] == 4)
                    { ?>
                    <a href="./lesPhotos.php?cat=4" > Sport</a> <br> <?php
                    }
                    else if ($donnees['catId'] == 5)
                    { ?>
                    <a href="./lesPhotos.php?cat=5" > Voyage</a> <br> <?php
                    } ?>    
                </td>
            </tr>
        </tbody>
        </table>
        
        </div>
        <!-- On affiche la photo. -->
        <div style='width:200px; position: absolute; left: 470px; top: 320px;'>
        <?php echo "<img class='img-fluid' src='./images/".$donnees['nomFich']." ' >"; 

        // On crée une variable de session de l'id de la photo pour la réutiliser autre part.
        $_SESSION['id'] = $idPhoto?><br>
        </div></center> 
        <?php 
    }
}

// Si le membre souhaite modifier une photo.
if (isset($_GET['action']) && $_GET['action'] == "modifier")
{?>
    <!-- Formulaire qui permet de modifier la photo, il est possible de modifier la description et/ou la catégorie. -->
    <center><form method="post" <?php echo "action='detailsLesPhotos.php?id=$idPhoto&categ=$idCategorie&action=modifier&form=envoyer'" ?> enctype="multipart/form-data" >
  <div style="width: 320px; position: relative; bottom: 100px; left: -460px;">
    <div style="font-size: 25px; color: black; background-color: #F7F7F7; border: solid black 1px;">
    Modifier la photo 
    </div>
    <br>
    <div class="form-floating">
        <textarea name="desc" minlength="1" maxlength="145" class="form-control" id="floatingTextarea2" style="height: 120px"></textarea>
        <label for="floatingTextarea2">Changement de la description :</label>
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
        <label for="floatingSelect">Changement de la catégorie :</label>
    </div> <br>
    <input style="position: relative; top: 10px;" type = "submit" name="envoyer" class = "btn btn-dark" value = "Modifier"/>
  </div> 
  </form></center>
  <?php
}

// Si le membre souhaite supprimer une photo.
if (isset($_GET['action']) && $_GET['action'] == "supprimer")
{
    supprimePhoto($bdd, $_SESSION['id']);
    header("Location:./lesPhotos.php?visible=oui&supprimer=oui");
}

// Si le membre souhaite rendre visible une photo.
if (isset($_GET['action']) && $_GET['action'] == "visible" || (isset($_GET['visib']) && $_GET['visib'] == "oui"))
{  
    rendPhotoVisible($bdd, $idPhoto);
    ?>
    <!-- Affichage des 3 boutons : modifier, cacher et supprimer. -->
    <div style='position: absolute; left: 566px; top: 570px; border: none;'>
        <a style="color: white;" <?php echo "href='./detailsLesPhotos.php?id=$idPhoto&categ=$idCategorie&action=modifier'"; ?> ><button style="margin: 20px;" type="button" class="btn btn-warning"> Modifier </button> </a>
        <a style="color: white;" <?php echo "href='./detailsLesPhotos.php?id=$idPhoto&categ=$idCategorie&action=cacher&visible=non'"; ?> ><button style="margin: 20px;" type="button" class="btn btn-warning"> Cacher </button> </a> 
        <a style="color: white;" <?php echo "href='./detailsLesPhotos.php?action=supprimer'"; ?> ><button style="margin: 20px;" type="button" class="btn btn-warning"> Supprimer </button> </a> 
    </center>
    </div> 
    <!-- Affichage du bonton de retour aux photos. -->
    <div style='position: absolute; left: 640px; top: 660px;'>
    <center> <a href="./mesPhotos.php?visible=oui" ><button type="button" class="btn btn-dark">Retour à toutes les photos</button> </a> </center>
    </div>
    <?php
}
// Si le membre souhaite cacher une photo.
else if (isset($_GET['action']) && $_GET['action'] == "cacher" || (isset($_GET['visib']) && $_GET['visib'] == "non"))
{
    rendPhotoCachee($bdd, $idPhoto);
    ?>
    <!-- Affichage des 3 boutons : modifier, visible et supprimer. -->
    <div style='position: absolute; left: 566px; top: 570px; border: none;'>
    <center> 
        <a style="color: white;" <?php echo "href='./detailsLesPhotos.php?id=$idPhoto&categ=$idCategorie&action=modifier'"; ?> ><button style="margin: 20px;" type="button" class="btn btn-warning"> Modifier </button> </a>
        <a style="color: white;" <?php echo "href='./detailsLesPhotos.php?id=$idPhoto&categ=$idCategorie&action=visible&visib=oui'"; ?> ><button style="margin: 20px;" type="button" class="btn btn-warning"> Visible </button> </a> 
        <a style="color: white;" <?php echo "href='./detailsLesPhotos.php?action=supprimer'"; ?> ><button style="margin: 20px;" type="button" class="btn btn-warning"> Supprimer </button> </a> 
    </center>
    </div> 
    <!-- Affichage du bonton de retour aux photos. -->
    <div style='position: absolute; left: 640px; top: 660px;'>
    <center> <a href="./lesPhotos.php?visible=oui" ><button type="button" class="btn btn-dark">Retour à toutes les photos</button> </a> </center>
    </div>
    <?php
}
else
{
    ?>
    <!-- Affichage des 3 boutons : modifier, cacher et supprimer. -->
    <div style='position: absolute; left: 566px; top: 570px; border: none;'>
        <a style="color: white;" <?php echo "href='./detailsLesPhotos.php?id=$idPhoto&categ=$idCategorie&action=modifier'"; ?> ><button style="margin: 20px;" type="button" class="btn btn-warning"> Modifier </button> </a>
        <a style="color: white;" <?php echo "href='./detailsLesPhotos.php?id=$idPhoto&categ=$idCategorie&action=cacher&visib=non'"; ?> ><button style="margin: 20px;" type="button" class="btn btn-warning"> Cacher </button> </a> 
        <a style="color: white;" <?php echo "href='./detailsLesPhotos.php?action=supprimer'"; ?> ><button style="margin: 20px;" type="button" class="btn btn-warning"> Supprimer </button> </a> 
    </center>
    </div> 
    <!-- Affichage du bonton de retour aux photos. -->
    <div style='position: absolute; left: 640px; top: 660px;'>
    <center> <a href="./lesPhotos.php?visible=oui" ><button type="button" class="btn btn-dark">Retour à toutes les photos</button> </a> </center>
    </div>
    <?php
}

// Si la description est modifié, alors un message s'affiche le confirmant.
if(isset($_GET['descr']) && $_GET['descr'] == "oui")
{?>
    <div style="position: relative; top: -455px; right: -180px;"> <?php
    $msg = "Modification réussie !";
    echo '<font color="green">'."$msg"."</font>";?>
    </div> <?php
}



?> 
