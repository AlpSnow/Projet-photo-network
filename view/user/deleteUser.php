<?php

    $user = $result["data"]["user"];

?>

<h3 class="messageErreur"><?= App\Session::getFlash("error") ?></h3>
<h3 class="messageSucces"><?= App\Session::getFlash("success") ?></h3>


<p>
    Vous êtes sur le point de supprimer définitivement votre compte, il vous sera toujours possible de vous réeinscrir par la suite.
</p>
<p>
    Êtes-vous certains de vouloir supprimer votre profil ?
</p>
<p>
    ⚠️ En cas de suppression de votre profil, vos photos et vos commentaires resteront publics. Il vous appartient de les supprimer avant.
</p>

<a class="btn deleteProfilBtn" href="index.php?ctrl=security&action=deleteUser&id=<?= $user->getId()  ?>"> Supprimer définitivement votre profil ❌ </a>

<?php 

    $title = "supprimer compte";

?>