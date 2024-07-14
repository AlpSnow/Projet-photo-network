<h1>Bienvenue</h1>

<h3 class="messageErreur"><?= App\Session::getFlash("error") ?></h3>
<h3 class="messageSucces"><?= App\Session::getFlash("success") ?></h3>

<section class="connexionEtInscription">

    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form class="formConnect2" id="formConnect2" action="index.php?ctrl=security&action=register" method="post" enctype="multipart">
                <h2>Inscription</h2>

                <input type="text" name="pseudo" placeholder="Pseudonyme" required />
                <input type="email" name="email" placeholder="E-mail" required />
                <input type="password" name="password" placeholder="Mot de passe" required />
                <input type="password" name="confirmPassword" placeholder="Confirmer votre mot de passe" required />
                <button class="g-recaptcha"
                        data-sitekey="<?php echo SITE_KEY ?>" 
                        data-callback='onSubmit2' 
                        data-action='submit'>
                        S'inscrire
                </button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form class="formConnect" id="formConnect" action="index.php?ctrl=security&action=login" method="post" enctype="multipart">
                <h2>Bienvenue photographe voyageur, connectez-vous</h2>

                <?php
                    if(isset($_COOKIE["Email"])) {
                        echo "<input type='email' name='emailConnect' value='".$_COOKIE["Email"]."' required />";
                       
                    } else {
                        echo "<input type='email' name='emailConnect' placeholder='E-mail' required />";
                    }
                ?>
                <input type="password" name="passwordConnect" placeholder="Mot de passe" required />
                <div>
                    <input type="checkbox" name="memorize" value="1" id="memorize">
                    <label for="memorize">mémoriser l'adresse mail</label>
                </div>
                <a href="#">Mot de passe oublié ?</a>
                <button class="g-recaptcha"
                        data-sitekey="<?php echo SITE_KEY ?>" 
                        data-callback='onSubmit' 
                        data-action='submit'>
                        Se connecter
                </button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h2 class="titreSecondaire">Content de vous revoir !</h2>
                    <p>Pour rester en contact avec nous, veuillez vous connecter avec vos identifiants personnelles</p>
                    <button class="ghost" id="signIn">S'identifier</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h2 class="titreSecondaire">Bienvenue !</h2>
                    <p>Entrez vos données personnelles et commencez votre voyage avec nous</p>
                    <button class="ghost" id="signUp">Inscription</button>
                </div>
            </div>
        </div>
    </div>

</section>


<?php

    $title = "inscription/connexion";
    $loginScript = "public/js/loginScript.js";
    $recaptcha = "formConnect";
    $recaptcha2 = "formConnect2";

?>