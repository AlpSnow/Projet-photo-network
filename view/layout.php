<!DOCTYPE html>
<html lang="en">

<?php
    use App\Session;
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content=<?= Session::getTokenCSRF() ?> >
    <!-- Uniquement pour le slider : -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="public/css/reset.css">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/media-queries.css">
    <!-- Icone favoris : -->
    <link rel="shortcut icon" href="#" />
    <title><?= $title ?></title>
</head>

<body>
    <!-- https://genesis-technology.fr/un-footer-en-bas-de-page-grace-au-flex-et-au-grid/#:~:text=La%20valeur%201fr%20(fr%20pour,footer%20sera%20toujours%20en%20bas.-->
    <div class="flexItem">

        <header>

            <nav>

                <a href="index.php?ctrl=home&action=index" target="_blank" class="navigationIcone" aria-label="visiter la page" aria-current="page">
                    <figure>
                        <img src="public/image/logos/travel-photo-logo3.png" alt="logo voyage photo">
                    </figure>
                    <strong>Travel Photo World</strong>
                </a>

                <div class="navigationPrincipale">
                    <button class="hamburger" type="button" aria-label="activer ou désactiver la navigation" aria-expanded="false">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>

                    <div class="navigationAffichage">
                        <a href="index.php?ctrl=home&action=index" aria-current="page">Accueil</a>
                        <a href="index.php?ctrl=photo&action=index">Recherche</a>
                        <?php if(isset($_SESSION['user'])) { ?>
                            <a href="index.php?ctrl=photo&action=remoteAddPhoto">Ajouter une photo</a>

                            <?php if($_SESSION['user']->hasRole('ROLE_ADMIN')) {  ?>
                                <a href="index.php?ctrl=security&action=index">Gestion</a>
                            <?php } ?>

                            <a class="marginRight" href="index.php?ctrl=security&action=seeUserById&id=<?= $_SESSION['user']->getId() ?>">Accéder au profil</a>
                        <?php } ?>
                        <img class="imageColor" src="public/image/logos/trimColor.png" alt="couleurs">
                        <div class="buttonColor">
                            <button class="couleurBase liensAccueil" aria-selected="true">couleurs de base</button>
                            <button class="couleurSecondaire liensAccueil" aria-selected="false">couleurs secondaires</button>
                            <button class="couleurDaltonien liensAccueil" aria-selected="false">couleurs daltonien</button>
                        </div>
                    </div>
                </div>
        

                <div class="navigationAuthentification">

                    <?php if(!isset($_SESSION["user"])) { ?>

                        <a href="index.php?ctrl=security&action=registerForm" class="utilisateurIcone" aria-label="page de connexion">
                            <img src="public/image/profiles/default-picture.svg" alt="icône utilisateur">
                        </a>

                        <div class="adhesion">
                            <a href="index.php?ctrl=security&action=registerForm" class="liensAccueil liensTaille"> s'identifier </a>
                            <a href="index.php?ctrl=security&action=registerForm" class="liensAccueil liensTaille"> s'inscrire </a>
                        </div>

                    <?php } else { ?>

                        <a href="index.php?ctrl=security&action=logout" class="utilisateurIcone" aria-label="page de déconnexion">
                            <img src="public/image/logos/logout.png" alt="icône deconnexion">
                        </a>

                        <div class="adhesion">
                            <a href="index.php?ctrl=security&action=logout" class="liensAccueil liensTaille2"> se deconnecter </a>
                        </div>

                    <?php } ?>
        
                </div>

            </nav>

        </header>
        

        <main id="photo">
            <?= $page ?>
        </main>

    </div>


    <footer>

        <p>Inscrivez-vous à la newsletter pour recevoir l'actualité du site en continu !</p>
        <form action="">
            <input type="email" class="emailnl" name="emailnl" placeholder="adresse e-mail">
            <button type="submit" name="submit" class="boutonForm">s'abonner</button>
        </form>
        <small>© 2022 Max Wallis</small>
        <div class="cguMl">
            <div>
                <a href="">mentions légales</a>
            </div>
            <div>
                <a href="">conditions générales d'utilisation</a>
            </div>
            <div>
                <a href="">plan du site</a>
            </div>
        </div>
    </footer>


    <script src="public/js/script.js"></script>
    <?php 
        if(isset($loginScript)){ ?>
            <script src="<?=$loginScript?>"></script>
        <?php } 

        if(isset($addComment)){ ?>
            <script src="<?=$addComment?>"></script>
        <?php } 

        if(isset($slider)){ ?>
            <script src="<?=$slider?>"></script>
        <?php } 

        if(isset($photoFullScreen)){ ?>
            <script src="<?=$photoFullScreen?>"></script>
        <?php } 
        
        if(isset($recaptcha)){ ?>
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            <script>
                function onSubmit(token) {
                    document.getElementById("<?=$recaptcha?>").submit();
                }
            </script>

            <?php if(isset($recaptcha2)){ ?>
                <script>
                    function onSubmit2(token) {
                        document.getElementById("<?=$recaptcha2?>").submit();
                    }
                </script>

            <?php }
        } 
    ?> 
    
</body>

</html>