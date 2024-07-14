<?php

    $towns = $result["data"]["towns"];
    
?>


<h1>world travel photography</h1>


<!-- <header class="titreResponsiveNavigation">
    <figure>
        <img src="public/image/voyage-monde.jpg" alt="voyage monde exploration">
    </figure>

    <h2>photographie de voyage du<strong>&nbsp;monde </strong></h2>

</header> -->
<section class="titreResponsiveNavigation headerPagePrincipal">
    <div class="imagePrincipale">
    <!-- https://www.pexels.com/fr-fr/photo/maison-en-beton-blanc-pres-du-plan-d-eau-sous-ciel-nuageux-blanc-et-bleu-1285625/ -->
        <!-- <h2>Bienvenue</h2> -->
        <h3 class="titrePrincipal">photographie de voyage du<strong>&nbsp;monde</strong></h3>

        <span>Venez partager vos plus <strong>&nbsp;belles photos</strong>&nbsp;de visites de <em>&nbsp;villes</em></span>

        <h3>Vous êtes photgraphes et voulez partager vos clichés</h3>
        <span>Ou vous êtes amoureux des villes et désirez les découvrir de chez vous </span>
        
        <?php 
            if(!isset($_SESSION["user"])) { ?>
                <a href="index.php?ctrl=security&action=registerForm" class="liensAccueil"> s'inscrire </a>
        <?php } ?>

    </div>
</section>



<section>
            
    <h3 class="titleH3">A propos de nous</h3>

    <hr class="coupureLigneHr2">

    <article class="premierArticle">

        <h4 class="titleH4">Qui sommes-nous & Que faisons-nous ?</h4>

        <p class="sizeP">
            TRAVEL PHOTOGRAPHY a pour but de vous armer des connaissances et de l'inspiration dont vous avez besoin pour voyager davantage et capturer votre voyage en cours de route.
        </p>
        <p class="sizeP">
            Si vous avez déjà défilé sans réfléchir sur Instagram et que vous êtes tombé sur une image de voyage qui fait que votre pouce s'arrête pendant que vous fixez votre téléphone avec admiration en souhaitant pouvoir produire des photos comme celle-là, 
            alors vous êtes au bon endroit.
        </p>

    </article>


            <!-- <article class="deuxiemeArticle">
                <h3 class="titreArticleElan"> <strong>Les bienfaits </strong>que procurent <strong>la photographie</strong> dans votre vie</h3>
                https://annejutras.com/21-bienfaits-que-procure-la-photographie/ 
                <hr>
                <p>
                    Si vous êtes un passionné de photo, vous savez déjà intuitivement que cette discipline vous fait du bien, vous procure de la satisfaction et vous pousse à observer le monde avec un regard neuf. En revanche, si vous laissez votre appareil photo prendre la poussière dans un coin, la liste ci-dessous va peut-être vous inciter à vous y (re)mettre
                </p>
                <ul>
                    <li><strong>Insuffle un sentiment de plaisir</strong> Le plaisir est l’un des premiers bienfaits que procure la photographie. Tout le processus relié à l’activité, la prise de vue, le contact avec notre environnement, le visionnement des images et le partage contribuent à notre bien-être.</li>
                    <li><strong>Permet de focaliser sur le moment présent</strong> La photographie de par son processus d’analyse et de contact visuel avec le sujet, nous amène à être présent dans l’ici et maintenant. Toutes nos pensées sont focalisées sur ce qui se passe à l’instant précis.</li>
                    <li><strong>Favorise la pleine conscience</strong> Dans un monde sans cesse à la course, la photographie nous invite à ralentir et à ressentir ce qui se passe non seulement à l’extérieur, mais aussi s’ouvrir à ce qui se passe en nous. Et à vivre pleinement le moment qui nous est accordé.</li>
                    <li><strong>Ouvre les yeux sur le quotidien</strong>Votre environnement vous parait banal? Adonnez-vous à la photographie pendant quelques jours. Portez attention aux menus détails, vous verrez votre regard s’épanouir, votre perception se modifier. Ne soyez pas surpris si l’ordinaire devient tout à coup… extraordinaire.</li>
                    <li><strong>Favorise la découverte de son environnement</strong>Regarder à travers un objectif incite à voir le monde d’un autre œil, à l’affut de lieux ou de gens à photographier.</li>
                    <li><strong>Chasse les soucis quotidiens</strong>Les problèmes quotidiens, sans qu’ils soient monstrueux, bousillent parfois le moral. Une façon simple et efficace de réduire ce stress est d’effectuer une sortie photo d’une quinzaine de minutes. Votre attention sera dirigée ailleurs, et très vite vous oublierez vos préoccupations. Vous serez le premier à vouloir prolonger votre activité.</li>
                    <li><strong>Procure une grande détente</strong>Après avoir fait une série d’images, pour le plaisir (et non pour réussir la photo trophée du jour), votre niveau de stress diminue et peu à peu un bien-être s’installe. Les tensions sont relâchées, et votre corps ressentira une détente salutaire.</li>
                    <li><strong>Cultive votre sens de la beauté</strong>Au fil de vos sorties photo, vous observez votre environnement d’un autre œil, votre regard s’aiguise. Vous portez attention et apprenez à mieux voir, à apprécier aussi. Or, ce qui au premier abord vous apparaissait intéressant devient tout à coup digne d’intérêt.</li>
                    <li><strong>Éveille la curiosité</strong>Vous aurez envie d’explorer des lieux ou des sujets moins connus. Votre soif d’apprendre vous poussera à parcourir différentes avenues, à visiter des régions encore inconnues, afin d’élargir votre expérience.</li>
                    <li><strong>Sollicite la créativité</strong>L’art photographique nous permet d’exprimer ce qu’on ressent dans le moment présent, autrement qu’avec des mots.</li>
                    <li><strong>Facilite l’interaction avec le monde extérieur</strong>Peu importe votre domaine de prédilection, que ce soit le portrait, la photo de rue, ou de nature, le contact que vous entretenez avec votre sujet contribue à faciliter la communication, favorisant l’échange avec le monde extérieur.</li>
                    <li><strong>Aiguise notre sens de l’observation</strong>Permet d’être à l’affut de détails qui autrement nous échapperaient. Nous devenons plus attentifs, nous analysons, scrutons, repérons et interprétons notre environnement afin de créer des images uniques.</li>
                </ul>
                <p>
                    En conclusion, c’est un pas vers l’accomplissement de soi, vers la liberté intérieur. Une occasion unique de faire savoir au monde entier qui vous êtes.

                    Saisissez votre appareil photo et inondez le monde de vos images photographiques, il y aura toujours de la place pour de nouvelles façons de voir le monde.
                </p>

            </article> -->
</section>

<hr class="coupureLigneHr2">





<section>

    <h3 class="titleH3">Voici une sélection des villes les plus populaires en ce moment</h3>

    <div class="basculerTout">

        <span class="bouton avant" data-mode="avant">
            <i class="fa-solid fa-angle-left"></i>
        </span>

            
        <?php 
            $i=0;
            $actualTown = $towns->current()->getName();
            foreach ($towns as $town) { 
                $i++; ?>
                
                <div class="basculer <?php if($i == 1){ echo 'active';}?>">
                    <div class="images">
                        <a href="index.php?ctrl=photo&action=seePhotoByTowns&id=<?= $town->getId() ?>">
                            <img src="public/image/towns/<?=$town->getImage()?>" alt="<?=$town->getName()?>">
                        </a>
                    </div>
                </div>

            <?php } 
        ?>


        <span class="bouton apres" data-mode="apres">
            <i class="fa-solid fa-angle-right"></i>
        </span>
             
    </div>

    <div class="result"><?=$actualTown?></div>

</section>

<hr class="coupureLigneHr2">

<h3 class="titleH3">ainsi que des exemples de photos de nos utilisateurs</h3>

<figure class="galerieImage">
    <div class="galerieImagediv1">
        <img class="city1" src="public/image/gallery/new-york1.jpg" alt="photo">
        <img class="city2" src="public/image/gallery/new-york2.jpg" alt="photo">
        <img class="city3" src="public/image/gallery/new-york3.jpg" alt="photo">
        <img class="city4" src="public/image/gallery/new-york4.jpg" alt="photo">
    </div>

    <div class="galerieImagediv2">
        <img class="city5" src="public/image/gallery/tokyo.jpg" alt="photo">
        <img class="city6" src="public/image/gallery/londres1.jpg" alt="photo">
        <img class="city7" src="public/image/gallery/londres2.jpg" alt="photo">
        <img class="city8" src="public/image/gallery/paris.jpg" alt="photo">
    </div>

</figure>

<img class="imageAccueilBas" src="public/image/background.jpg" alt="photo">


<?php
    unset($actualTown);
    $title = "accueil";
    $slider = "public/js/slider.js";

?>

