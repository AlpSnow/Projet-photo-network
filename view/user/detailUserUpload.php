<?php

    $user = $result["data"]["user"];

?>

<h3 class="messageErreur"><?= App\Session::getFlash("error") ?></h3>
<h3 class="messageSucces"><?= App\Session::getFlash("success") ?></h3>

<form id="formUploadUser" class="formulaireAjout positionForm" action="index.php?ctrl=security&action=uploadUser&id=<?= $user->getId() ?>" method="POST" enctype="multipart/form-data">
    <fieldset>
        <legend>Modifier votre profil</legend>

        <div>
            <label for="email" class="labelForm">Email</label>
            <input type="email" name="email" class="inputForm" id="email" value="<?= $user->getEmail()?>" required>
        </div>

        <div>
            <label for="pseudonym" class="labelForm">Pseudonyme</label>
            <input type="text" name="pseudo" class="inputForm" id="pseudonym" value="<?= $user->getPseudonym()?>" required>
        </div>

        <div>
            <label for="formFile" class="labelForm">Image de profil</label>
            <input type="file" name="image" class="inputForm" id="formFile">
        </div>
        
        <!--<div>
            <label for="description" class="labelForm">Description</label>
            <textarea type="text" name="description" class="inputForm" id="description" placeholder="Saisissez votre description ici" rows="3"></textarea>
        </div> -->

     
  
        <input type="hidden" name="userOldImage" value="<?= $user->getImage()?>" required>
      

        <button class="g-recaptcha boutonForm"
                data-sitekey="<?php echo SITE_KEY ?>" 
                data-callback='onSubmit' 
                data-action='submit'>
                Modifier votre profil
        </button>

    </fieldset>
</form>





<?php 

        $title = "modifier profil";
        $recaptcha = "formUploadUser";

?>