<?php

    $users = $result["data"]["users"];
    $admins = $result["data"]["admins"];

    // var_dump($admins);
    // die;

    // var_dump($_SESSION["user"]);
    // var_dump($_SESSION["user"]->getRoles());
    // var_dump($_SESSION["user"]->hasRole('ROLE_ADMIN'));
    // var_dump(app\Session::getUser()->hasRole('ROLE_ADMIN'));

?>

<h3 class="messageErreur"><?= App\Session::getFlash("error") ?></h3>
<h3 class="messageSucces"><?= App\Session::getFlash("success") ?></h3>


<h3>liste des administrateur</h3>


<table>
    <thead>
        <tr>
            <th>Pseudonyme</th>
            <th>E-mail</th>
            <th>Date de création</th>
            <th>Statut</th>
            <th>Role</th>
            <th>Bannir l'utilisateur</th>
            <th>Modifier role</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($admins as $admin) { 

            if($admin->hasRole('ROLE_ADMIN')){ ?>

                <tr>
                    <td> <a href="index.php?ctrl=security&action=seeUserById&id=<?= $admin->getId() ?>"> <?= $admin->getPseudonym() ?> </a> </td>
                    <td> <a href="index.php?ctrl=security&action=seeUserById&id=<?= $admin->getId() ?>"> <?= $admin->getEmail() ?> </a> </td>
                    <td> <?= $admin->getSignupDate() ?> </td>
                    <td> <?= $admin->getStatus() ?> </td>
                    <td> <?= ($admin->getRoles())[0] == "ROLE_ADMIN" ? "Administrateur" : "Utilisateur" ?> </td>
                    <td>
                        <?php if($admin->getStatus() == "actif") { ?>
                            <a href="index.php?ctrl=security&action=banUser&id=<?= $admin->getId() ?>"> 🚫 bannir l'utilisateur </a> 
                        <?php } else { ?>
                            <a href="index.php?ctrl=security&action=unbanUser&id=<?= $admin->getId() ?>"> ✔️ réintégrer l'utilisateur </a>    
                        <?php } ?>
                    </td>
                    <td>
                        <a href="index.php?ctrl=security&action=removeAdminStatus&id=<?= $admin->getId() ?>"> ✖️ Retirer le status administrateur </a>
                    </td>
                </tr>

            <?php }
        }; ?>

    </tbody>
</table>


<h3>liste des utilisateurs</h3>


<table>
    <thead>
        <tr>
            <th>Pseudonyme</th>
            <th>E-mail</th>
            <th>Date de création</th>
            <th>Statut</th>
            <!-- <th>Image</th> -->
            <th>Role</th>
            <th>Bannir l'utilisateur</th>
            <th>Modifier role</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($users as $user) { ?>

            <tr>
                <td> <a href="index.php?ctrl=security&action=seeUserById&id=<?= $user->getId() ?>"> <?= $user->getPseudonym() ?> </a> </td>
                <td> <a href="index.php?ctrl=security&action=seeUserById&id=<?= $user->getId() ?>"> <?= $user->getEmail() ?> </a> </td>
                <td> <?= $user->getSignupDate() ?> </td>
                <td> <?= $user->getStatus() ?> </td>
                <!-- <td> <?php // echo $user->getImage() ?> </td> -->
                <td> <?= ($user->getRoles())[0] == "ROLE_ADMIN" ? "Administrateur" : "Utilisateur" ?> </td>

                <td>
                    <?php if($user->getStatus() == "actif") { ?>
                        <a href="index.php?ctrl=security&action=banUser&id=<?= $user->getId() ?>"> 🚫 bannir l'utilisateur </a> 
                    <?php } else { ?>
                        <a href="index.php?ctrl=security&action=unbanUser&id=<?= $user->getId() ?>"> ✔️ réintégrer l'utilisateur </a>    
                    <?php } ?>
                </td>
                <td>
                    <?php if($user->getRoles()[0] == "ROLE_USER") { ?>
                        <a href="index.php?ctrl=security&action=addAdminStatus&id=<?= $user->getId() ?>"> 🔑 Ajouter le statut administrateur </a> 
                    <?php } else { ?>
                        <a href="index.php?ctrl=security&action=removeAdminStatus&id=<?= $user->getId() ?>"> ✖️ Retirer le status administrateur </a>    
                    <?php } ?>
                </td>
            </tr>
        <?php }; ?>
    </tbody>
</table>

    



<?php 

    $title = "liste utilisateurs";

?>