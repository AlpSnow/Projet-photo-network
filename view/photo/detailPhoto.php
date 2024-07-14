<?php

    $photo = $result["data"]["photo"];
    $comments = $result["data"]["comments"];
    $currentPage = $result["data"]["currentPage"];

    $numberCommentsIterator = $result["data"]["numberComments"];

    if($numberCommentsIterator != null){

        $numberCommentsTotal = iterator_count($numberCommentsIterator);
    } else {
        $numberCommentsTotal = 0;
    }

    
    $numberPagesTotal = ceil($numberCommentsTotal / 5);

    // var_dump($numberCommentsTotal);
    // var_dump($numberPagesTotal);
    // die;

?>

<h3 class="messageErreur"><?= App\Session::getFlash("error") ?></h3>
<h3 class="messageSucces"><?= App\Session::getFlash("success") ?></h3>

<h3 class="titleH3">Détail photo</h3>

<div class="photoDetail">
    <?php  
        if ($photo->getUser() == true) {
            echo "<p>Photo de <a href='index.php?ctrl=security&action=seeUserById&id=".$photo->getUser()->getId()."'>".$photo->getUser()->getPseudonym()."</a></p>";     

        } else {
            echo "<p>Compte supprimé</p>";
        }
    ?>  

    <p>Prise à  <a href='index.php?ctrl=photo&action=seePhotoByTowns&id=<?=$photo->getTown()->getId()?>'> <?=$photo->getTown()->getName()?> </a></p>

    <figure>
        <img src="public/image/photos/<?= $photo->getFileName() ?>" alt="photo" class="photoImg">
        <figcaption><?= $photo->getReleaseDate() ?></figcaption>
    </figure>

    <?php  
        if ($photo->getDescription() != null) {
            echo "<p>".$photo->getDescription()."</p>";      

        } else {
            echo "";
        }

    ?>   
</div>


<?php

    if(isset($_SESSION["user"])) {

        if ($photo->getUser()) {

            if( ($photo->getUser()->getId() == $_SESSION["user"]->getId()) || ($_SESSION['user']->hasRole('ROLE_ADMIN')) ){ ?>

                <div class="detailPhotoBtnContent">
                    <a class="btn" href="index.php?ctrl=photo&action=remoteUploadPhoto&id=<?= $photo->getId()  ?>"> Modifier la description </a>
    
                    <a class="btn" href="index.php?ctrl=photo&action=deletePhoto&id=<?= $photo->getId()  ?>"> Supprimer la photo ❌ </a>
                </div>

            <?php }

        } else {

            if($_SESSION['user']->hasRole('ROLE_ADMIN')){ ?>

                <div class="detailPhotoBtnContent">
                    <a class="btn" href="index.php?ctrl=photo&action=remoteUploadPhoto&id=<?= $photo->getId()  ?>"> Modifier la description </a>

                    <a class="btn" href="index.php?ctrl=photo&action=deletePhoto&id=<?= $photo->getId()  ?>"> Supprimer la photo ❌ </a>
                </div>
            <?php }
        }

    }

?>



<div id="sectionComments"></div>
    
<!-- Liste des commentaires :  -->
<?php
    if (!isset($comments)){

        echo "<p>Cette photo ne possède pas de commentaire pour l'instant </p>";

    } else { ?>

        <section class="sectionComments">
            <h3 class="titleH3">Espace commentaire</h3>

            <?php 
                foreach($comments as $comment) { ?>
                    <div class="comment">
                        <?php  
                            if ($comment->getUser() == true) { ?>
                                <div class="headerComment">
                                    <div class="infosUserComment">
                                        <a href="index.php?ctrl=security&action=seeUserById&id=<?=$comment->getUser()->getId()?>">
                                            <?=$comment->getUser()->getPseudonym()?>
                                        </a>

                                        <?php                 
                                            if($comment->getModifiedDate() != null) {
                                                $affichageDate = explode(" ", $comment->getModifiedDate());

                                                echo "<p>Modifié le ".$affichageDate[0]." à ".$affichageDate[1]."</p>";

                                            } else {
                                                echo "<p>Posté le ".$comment->getCreationDate()."</p>";
                                            }
                                        ?>
                                    </div>

                                    <figure>
                                        <?php
                                            if($comment->getUser()->getImage() != null){
                                                echo "<img src='public/image/profiles/".$comment->getUser()->getImage()."' alt='image de l&apos;utilisateur ".$comment->getUser()->getPseudonym()."'>";
                                            } else {
                                                echo "<img class='imageDefault' src='public/image/profiles/default-picture.svg' alt='image de profil par défaut'>";
                                            }
                                        ?>
                                    </figure>


                                <?php 
                                    if ($comment->getUser()) {
    
                                        if(isset($_SESSION["user"])) {
                                            
                                            if ( ($comment->getUser()->getId() == $_SESSION["user"]->getId()) || ($_SESSION['user']->hasRole('ROLE_ADMIN')) ) { ?>
                                            
                                                <?php
                                                    $dateComment = DateTime::createFromFormat('d/m/Y à H:i:s', $comment->getCreationDate());
                                                    $dateNow = new DateTime("now", new DateTimeZone('Europe/Paris'));
                                                    $intervalDate = $dateComment->diff($dateNow);
                                                    // var_dump($intervalDate);
                                                    // var_dump($intervalDate->i);
                                                    // var_dump($intervalDate->y);
                                                    // var_dump($intervalDate->m);
                                                    // var_dump($intervalDate->d);
                                                    // die;
                                                    if(($intervalDate->y == 0) && ($intervalDate->m == 0) && ($intervalDate->d == 0)) { ?>
                                            
                                                        <a class="modifComment" title="modifier le commentaire" href="index.php?ctrl=comment&action=remoteUploadComment&id=<?= $comment->getId()  ?>"> 🖊️ </a>

                                                    <?php } ?>
                                
                                                <a class=<?= (($intervalDate->y == 0) && ($intervalDate->m == 0) && ($intervalDate->d == 0)) ? "deleteComment" : "deleteComment2" ?> title="supprimer le commentaire" href="index.php?ctrl=comment&action=deleteComment&id=<?= $comment->getId().".".$photo->getId()  ?>"> ❌ </a>
                                    
                                            <?php }
                                        } 
                                    }

                                echo "</div>"; 

                            } else {

                                echo "<div class='headerCompteSupp'>", 
                                        "<p class='compteSupp'>Compte supprimé</p>";

                                        if(isset($_SESSION["user"])) {
                                            
                                            if($_SESSION['user']->hasRole('ROLE_ADMIN')) { ?>
                                                <a class="deleteComment2" title="supprimer le commentaire" href="index.php?ctrl=comment&action=deleteComment&id=<?= $comment->getId().".".$photo->getId()  ?>"> ❌ </a>
                                            <?php }
                                        }

                                echo  "</div>";

                            }


                            ?>  
                            <hr class="coupureLigneHr">
                            <p class="contentComment"><?= $comment->getContent() ?></p>
                    </div>
            
                <?php } 
            
            
        echo "</section>";

    }

//* Pagination :

    echo "<div class='pagination'>";

    for($i=1; $i<=$numberPagesTotal; $i++){

        // On ne veut pas pouvoir cliquer sur la page actuelle :
        if($i == $currentPage){
            echo "<span>".$i."</span>";

        } else {

            echo "<a href='index.php?ctrl=photo&action=seePhotoById&id=".$photo->getId()."&page=".$i."&#sectionComments'>".$i."</a>";
        }
    }

    echo "</div>";

//* Ajouter un commentaire :

    if(isset($_SESSION["user"])){ ?>
        <div class="addComment">

            <button class="buttonAddComment">Ajouter un commentaire</button>

            <form class="formulaireAjout" action="index.php?ctrl=comment&action=addCommentByPhoto&id=<?=$photo->getId()?>" method="POST">
                <fieldset>
                    <legend>Ajouter un commentaire</legend>
        
                    <div>
                        <label for="comment" class="labelForm">commentaire</label>
                        <textarea type="text" name="comment" class="inputForm" id="comment" placeholder="Saisissez votre commentaire ici" rows="3" required></textarea>
                    </div>

                    <button type="submit" name="submit" class="boutonForm">Ajouter un commentaire</button>

                </fieldset>
            </form>
        </div>
    <?php }

?>



<?php 

    $title = "détail photo";
    $addComment = "public/js/addComment.js";
    $photoFullScreen = "public/js/photoFullScreen.js";

?>