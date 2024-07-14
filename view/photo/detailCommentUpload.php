<?php

    $comment = $result["data"]["comment"];

?>

<h3 class="messageErreur"><?= App\Session::getFlash("error") ?></h3>
<h3 class="messageSucces"><?= App\Session::getFlash("success") ?></h3>
    
<form class="formulaireAjout positionForm" id="formCommentModification" action="index.php?ctrl=comment&action=uploadComment&id=<?= $comment->getId().".".$comment->getPhoto()->getId() ?>" method="POST">
    <fieldset>
        <legend>Modifier votre commentaire</legend>
        
        <div>
            <label for="comment" class="labelForm">Commentaire</label>
            <textarea type="text" name="comment" class="inputForm" id="comment" rows="3"><?= $comment->getContent()?></textarea>
        </div>

        <button type="submit" name="submit" class="boutonForm">Appliquer les modifications</button>

    </fieldset>
</form>
    
    





<?php 

        $title = "modifier commentaire";

?>