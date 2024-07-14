<?php

    $towns = $result["data"]["towns"];

?>

<h3 class="titleH3">Liste des villes</h3>

<div class="content towns">
    <?php foreach ($towns as $town) { ?>


        <div class="photoFrame">

            <p>
                <a href="index.php?ctrl=photo&action=seePhotoByTowns&id=<?= $town->getId() ?>"> <?= $town->getName() ?> </a>
            </p>
            
            <p><?= $town->getPostalCode() ?></p>
            <p><?= $town->getCountry() ?></p>

            <figure>
                <a href="index.php?ctrl=photo&action=seePhotoByTowns&id=<?= $town->getId() ?>">
                    <img src="public/image/towns/<?= $town->getImage() ?>" alt="photo ville">
                </a>
            </figure>

            <p><?= $town->getDescription() ?></p>

 
        </div>

    <?php }; ?>
</div>




<?php 

    $title = "liste villes";

?>