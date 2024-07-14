<?php

    $towns = $result["data"]["towns"];

?>


<h3 class="messageErreur"><?= App\Session::getFlash("error") ?></h3>
<h3 class="messageSucces"><?= App\Session::getFlash("success") ?></h3>




<form class="formulaireAjout positionForm" action="index.php?ctrl=photo&action=addPhoto" method="POST" enctype="multipart/form-data">
    <fieldset>
        <legend>Ajouter une photo</legend>

        <div>
            <label for="ville" class="labelForm">Ville</label>
            <select name="ville" class="selectForm" id="ville" required>
                <option selected>Liste des villes</option>
                
                <?php 
                    foreach($towns as $town){

                        echo "<option value='".$town->getId()."'>".$town->getName()."</option>";
                    }
                ?>
            </select>
        </div> 

        <div>
            <label for="formFile" class="labelForm">Photo</label>
            <input type="file" name="photo" class="inputForm" id="formFile" required>
        </div>
        
        <div>
            <label for="description" class="labelForm">Description</label>
            <textarea type="text" name="description" class="inputForm" id="description" placeholder="Saisissez votre description ici" rows="3"></textarea>
        </div>

        <button type="submit" name="submit" class="boutonForm">Ajouter photo</button>

    </fieldset>
</form>




<?php 

        $title = "ajouter une photo";

?>