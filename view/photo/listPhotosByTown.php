<?php

    $town = $result["data"]["town"];
    $photos = $result["data"]["photos"];
    
?>

<h3 class="titleH3">photos de la ville de <?= $town->getName() ?></h3>


<div class="informationTown">

    <div>
        <a href="https://fr.wikipedia.org/wiki/<?= $town->getName() ?>">
            <p><?= $town->getName() ?></p>
        </a>
        <p><?= $town->getPostalCode() ?></p>
        <p><?= $town->getCountry() ?></p>
    </div>

    <figure>
        <img src="public/image/towns/<?= $town->getImage() ?>" alt="<?= $town->getName() ?> photo">
    </figure>

</div>



<?php if (isset($photos)) {

    echo "<div class='content'>";

        foreach ($photos as $photo) { ?>

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

        <?php };

    echo "</div>";

} else {

    echo "<p> aucune photo pour la ville de ".$town->getName()." actuellement </p>";

}; ?>




<?php 

    $title = "liste photos de ".$town->getName()."";

?>