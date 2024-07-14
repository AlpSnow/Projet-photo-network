<?php

    $user = $result["data"]["user"];

?>

<h3 class="messageErreur"><?= App\Session::getFlash("error") ?></h3>
<h3 class="messageSucces"><?= App\Session::getFlash("success") ?></h3>

<form id="formUploadPassword" class="formulaireAjout positionForm" action="index.php?ctrl=security&action=modifyPassword&id=<?= $user->getId() ?>" method="POST" enctype="multipart/form-data">
    <fieldset>
        <legend>Modifier votre mot de passe</legend>

        <div>
            <label for="password1" class="labelForm">Ecrivez votre ancien mot de passe</label>
            <input type="password" name="passwordOld" class="inputForm" id="password1" placeholder="Ancien mot de passe" required />
        </div>

        <div>
            <label for="password2" class="labelForm">Choisissez votre nouveau mot de passe</label>
            <input type="password" name="passwordNew" class="inputForm" id="password2" placeholder="Nouveau mot de passe" required />
        </div>

        <div>
            <label for="password3" class="labelForm">Retaper votre nouveau mot de passe</label>
            <input type="password" name="passwordNewConfirm" class="inputForm" id="password3" placeholder="Nouveau mot de passe" required />
        </div>

        <button class="g-recaptcha boutonForm"
                data-sitekey="<?php echo SITE_KEY ?>" 
                data-callback='onSubmit' 
                data-action='submit'>
                Modifier votre mot de passe
        </button>

    </fieldset>
</form>




<?php 

    $title = "modifier mot de passe";
    $recaptcha = "formUploadPassword";

?>