<?php

    $photo = $result["data"]["photo"];

?>

<h3 class="messageErreur"><?= App\Session::getFlash("error") ?></h3>
<h3 class="messageSucces"><?= App\Session::getFlash("success") ?></h3>

<form class="formulaireAjout positionForm" id="formModification" action="index.php?ctrl=photo&action=uploadPhoto&id=<?= $photo->getId() ?>" method="POST">
    <fieldset>
        <legend>Modifier votre description</legend>
        
        <div>
            <label for="description" class="labelForm">Description</label>
            <textarea type="text" name="description" class="inputForm" id="description" rows="3"><?= $photo->getDescription()?></textarea>
        </div>

        <button type="submit" name="submit" class="boutonForm">Appliquer les modifications</button>

    </fieldset>
</form>


<div class="photoDetail">

    <figure>
        <img src="public/image/photos/<?= $photo->getFileName() ?>" alt="">
        <figcaption><?= $photo->getReleaseDate() ?></figcaption>
    </figure>

</div>



<?php 

        $title = "modifier photo";

?>