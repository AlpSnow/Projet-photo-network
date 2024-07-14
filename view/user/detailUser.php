<?php

    $user = $result["data"]["user"];
    $followedUser = $result["data"]["followedUser"];
    $photos = $result["data"]["photos"];

    if((isset($_SESSION["user"]))){
        $followedUs = $result["data"]["followedUs"];
        $verification = false;
    }

    // foreach($followedUs as $peoplefollowByUs){
        
    //     if ($peoplefollowByUs->getId() == $user->getId()){
    //         var_dump("ggggggggggggggggggg");
    //     }
    // }

 
    
    // $followedUser->getUserTarget();

    // $ArrayUsFollowed = iterator_to_array($followedUs, true);
 

    // var_dump(in_array($user->getId(), $followedUs->getUserTarget()));

    


?>

<h3 class="messageErreur"><?= App\Session::getFlash("error") ?></h3>
<h3 class="messageSucces"><?= App\Session::getFlash("success") ?></h3>

<div class="contentUserDetail">

    <?php
        if(isset($_SESSION["user"]) && ($user->getId() == $_SESSION["user"]->getId())) {
            echo "<h3 class='titleH3'>Détail de votre profil</h3>";

        } else {
            echo "<h3 class='titleH3'>Détail de l'utilisateur : ".$user->getPseudonym()."</h3>";
        }
    ?>          



    <?php 
        // Si on est connecté et si l'utilisateur est différent de nous (on ne veut pas se suivre soit même) alors :
        if(isset($_SESSION["user"]) && ($user->getId() != $_SESSION["user"]->getId())) {  

            // Si nous suivons des personnes :
            if($followedUs != null){
                // Pour chaque personne que nous suivons :
                foreach($followedUs as $peoplefollowedByUs){
                        
                    // Si nous suivons déjà l'utilisateur :
                    if($peoplefollowedByUs->getId() == $user->getId()){

                        $verification = true;
                        echo "<p>Vous suivez cet utilisateur</p>";
                        echo "<a class='followedUser' href='index.php?ctrl=follow&action=stopFollowUser&id=".$user->getId()."'>arrêter de suivre l'utilisateur</a>";
                    }

                }
            }
            // Si nous ne suivons pas l'utilisateur :
            if ($verification != true){ ?>
                <a class="followedUser" href="index.php?ctrl=follow&action=followUser&id=<?=$user->getId()?>">suivre l'utilisateur</a>
            <?php }

        } 
    ?>
        

    <hr class="coupureLigneHr3">

    <div class="userDetail">

        <div class="userDetailFlex">
            <div>
                <p>Pseudonyme :</p>
                <?php 
                    if(isset($_SESSION["user"]) && ($user->getId() == $_SESSION["user"]->getId())) { ?>
                        <p>Adresse e-mail :</p>
                <?php } ?>
                <p>Date de création :</p>
                <p>statut du compte :</p>

            </div>

            <div class="userDetailMarginP">
                <p><?= $user->getPseudonym() ?></p>
                <?php 
                    if(isset($_SESSION["user"]) && ($user->getId() == $_SESSION["user"]->getId())) { ?>
                        <p><?= $user->getEmail() ?></p>
                <?php } ?>
                <p><?= $user->getSignupDate() ?></p>
                <p><?= $user->getStatus() ?></p>
            </div>
        </div>
        <figure>
            <?php
                if($user->getImage() != null){
                    echo "<img src='public/image/profiles/".$user->getImage()."' alt='image de l&apos;utilisateur ".$user->getPseudonym()."'>";
                } else {
                    echo "<img class='detailUserDefaultImg' src='public/image/profiles/default-picture.svg' alt='image de profil par défaut'>";
                }
            ?>
        </figure>

    </div>

    <hr class="coupureLigneHr3">
    <div class="followedList">
        <?php

            if ($followedUser == null){

                if(isset($_SESSION["user"]) && ($user->getId() == $_SESSION["user"]->getId())) {

                    echo "<p>Vous ne suivez personne pour l'instant</p>";

                } else {

                    echo "<p>Cet utilisateur ne suit personne pour l'instant</p>";
                }


            } else {

                if(isset($_SESSION["user"]) && ($user->getId() == $_SESSION["user"]->getId())) {

                    echo "<h4 class='titleH4 userH4'>Votre suivi</h4>";

                } else {
                    echo "<h4 class='titleH4 userH4'>Suivi de ".$user->getPseudonym()."</h4>";
                }

                
                foreach($followedUser as $peopleFollowedByUser){
        
                    echo 
                        "<div class='followedPeople'>
                            <img src='public/image/profiles/".(($peopleFollowedByUser->getImage() != null) ? $peopleFollowedByUser->getImage() : 'default-picture.svg')."' alt='image profil'>
                            <a href='index.php?ctrl=security&action=seeUserById&id=".$peopleFollowedByUser->getId()."'>".$peopleFollowedByUser->getPseudonym()."</a>
                        </div>";
                }

            }

        ?>
    </div>


    <hr class="coupureLigneHr3">

    <div class="photosUserList">
        <?php

            if ($photos == null){

                if(isset($_SESSION["user"]) && ($user->getId() == $_SESSION["user"]->getId())) {

                    echo "<p>Vous n'avez partagé aucune photo pour l'instant</p>";

                } else {

                    echo "<p>Cet utilisateur n'a partagé aucune photo pour l'instant</p>";
                }


            } else {

                if(isset($_SESSION["user"]) && ($user->getId() == $_SESSION["user"]->getId())) {

                    echo "<h4 class='titleH4 userH4'>Vos photos</h4>";

                } else {
                    echo "<h4 class='titleH4 userH4'>Photos de ".$user->getPseudonym()."</h4>";
                }

            
                echo "<div class='content'>";

                    foreach ($photos as $photo) { ?>
                        
                        <div class="photoFrame">

                            <a href="index.php?ctrl=photo&action=seePhotoByTowns&id=<?=$photo->getTown()->getId()?>"><p><?=$photo->getTown()->getName()?></p></a> 
                
                            <figure>
                                <a href="index.php?ctrl=photo&action=seePhotoById&id=<?= $photo->getId() ?>&page=1">
                                    <img src="public/image/photos/<?= $photo->getFileName() ?>" alt="photo">
                                </a>
                            </figure>
                                            
                            <p><?= $photo->getReleaseDate() ?></p>
                        </div>
                
                    <?php };

                echo "</div>";
                
            }

        ?>
    </div>


    <?php 
        if(isset($_SESSION["user"]) && ($user->getId() == $_SESSION["user"]->getId())) { ?>
            <hr class="coupureLigneHr1 hrParams">
            <div class="userParam">
                <h4 class="titleH4">Paramètres</h4>
                
                <div class="userParamLink1">
                    <a class="btn" href="index.php?ctrl=security&action=remoteUploadUser&id=<?= $user->getId()  ?>"> Modifier votre profil </a>
        
                    <a class="btn" href="index.php?ctrl=security&action=remoteModifyPassword&id=<?= $user->getId()  ?>"> Modifier votre mot de passe </a>
                </div>
                <div class="userParamLink2">
                    <a class="btn" href="index.php?ctrl=security&action=deleteCookies&id=<?= $user->getId()  ?>"> Effacer tous les cookies liés au site Photo-network ❌ </a>

                    <a class="btn" href="index.php?ctrl=security&action=remoteDeleteUser&id=<?= $user->getId()  ?>"> Supprimer votre profil ❌ </a>
                </div>
            </div>

    <?php } ?>


    

</div>

<?php 

    $title = "détail utilisateur";

?>