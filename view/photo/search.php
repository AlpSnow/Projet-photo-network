<?php

    $photos = $result["data"]["photos"];

?>

<h3 class="messageErreur"><?= App\Session::getFlash("error") ?></h3>
<h3 class="messageSucces"><?= App\Session::getFlash("success") ?></h3>

<h3 class="titleH3">Rechercher une ville</h3>


<h3 class="titleH3">Liste des villes</h3>

<a class="arrowRedirection" href="index.php?ctrl=town&action=index">
    <i class="fa-solid fa-arrow-right-to-bracket"></i>
</a>


<h3 class="titleH3">50 dernières photos ajoutées sur le site</h3>

<div class="content">
    <?php foreach ($photos as $photo) { ?>


        <div class="photoFrame">
            <?php  
                if ($photo->getUser() == true) {   
                    echo "<a href='index.php?ctrl=security&action=seeUserById&id=".$photo->getUser()->getId()."'><p>".$photo->getUser()->getPseudonym()."</p></a>";   

                } else {
                    echo "<p> Compte supprimé <p>";
                }
            ?>  

            <figure>
                <a href="index.php?ctrl=photo&action=seePhotoById&id=<?= $photo->getId() ?>&page=1">
                    <img src="public/image/photos/<?= $photo->getFileName() ?>" alt="photo">
                </a>
            </figure>
            
            <?php  
                //if ($photo->getDescription() != null) {
                    //echo "<p>".$photo->getDescription()."</p>";      

                //} else {
                    //echo "";
                //}
            ?>   

            <p><?= $photo->getReleaseDate() ?></p>
        </div>

    <?php }; ?>
</div>




<?php 

    $title = "recherche";

?>