<?php
    require_once('bdd.php');
    require_once('requêtes.php');
    include("menu.php");
?>

<!doctype html>
<html lang="en">
  <head>
    <title> Détails des photos </title>
    
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

// On vérifie que la photo choisie a bien une catégorie.
if(isset($_GET['categ']))
{
    $idCategorie = $_GET['categ'];?>
    <div class="container d-flex flex-column flex-md-row justify-content-between" id="menu2">
    <?php

    // Suivant la catégorie de la photo choisie, un deuxième menu va s'afficher avec l'affichage des autres catégories.
    if ($idCategorie == 1)
    {
        ?>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=tp" > Toutes les photos </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=2" > Art </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=3" > Cuisine </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=4" > Sport </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=5" > Voyage </a> <br>
        <?php
    }
    else if ($idCategorie == 2)
    {
        ?>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=tp" > Toutes les photos </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=1" > Animaux </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=3" > Cuisine </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=4" > Sport </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=5" > Voyage </a> <br>
        <?php
    }
    else if ($idCategorie == 3)
    {
        ?>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=tp" > Toutes les photos </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=1" > Animaux </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=2" > Art </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=4" > Sport </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=5" > Voyage </a> <br>
        <?php
    }
    else if ($idCategorie == 4)
    {
        ?>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=tp" > Toutes les photos </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=1" > Animaux </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=2" > Art </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=3" > Cuisine </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=5" > Voyage </a> <br>
        <?php
    }
    else if ($idCategorie == 5)
    {
        ?>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=tp" > Toutes les photos </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=1" > Animaux </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=2" > Art </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=3" > Cuisine </a> <br>
        <a class="py-2 d-none d-md-inline-block" href="./index.php?cat=4" > Sport </a> <br>
        <?php
    }
    
    // On crée une variable de session de la catégorie de la photo pour la réutiliser autre part.
    $_SESSION['categ'] = $idCategorie;

?>
</div> <?php

    // On vérifie que la photo chosie a bien un id.
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
                            <a href="./index.php?cat=1" > Animaux</a> <br> <?php
                        }
                        else if ($donnees['catId'] == 2)
                        { ?>
                        <a href="./index.php?cat=2" > Art</a> <br> <?php
                        }
                        else if ($donnees['catId'] == 3)
                        { ?>
                        <a href="./index.php?cat=3" > Cuisine</a> <br> <?php
                        }
                        else if ($donnees['catId'] == 4)
                        { ?>
                        <a href="./index.php?cat=4" > Sport</a> <br> <?php
                        }
                        else if ($donnees['catId'] == 5)
                        { ?>
                        <a href="./index.php?cat=5" > Voyage</a> <br> <?php
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
}
