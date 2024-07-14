//? Barre de navigation :

const boutonNav = document.querySelector(".hamburger");
const navigation = document.querySelector(".navigationAffichage");


boutonNav.addEventListener("click", function() {

    boutonNav.classList.toggle("ouvrir");

    let ariaBool = boutonNav.getAttribute("aria-expanded") === "false" ? "true" : "false";
    boutonNav.setAttribute("aria-expanded", ariaBool);

    navigation.classList.toggle("ouvrir");
})

new ResizeObserver(entries => {
    // console.log(entries)
    if(entries[0].contentRect.width <= 1275){
        navigation.style.transition = "transform 0.3s ease-out";
        navigation.style.zIndex = "10";
    } else {
        navigation.style.transition = "none";
    }
}).observe(document.body);


//? Afficher changement de couleurs :

const boutonCouleurs = document.querySelector(".imageColor")
const listeBoutons = document.querySelector(".buttonColor")

boutonCouleurs.addEventListener("click", function(){
    listeBoutons.classList.toggle("activeButton")
    boutonCouleurs.classList.toggle("activeOpacity")
})



//? Changement de couleurs :

const couleurBase = document.querySelector(".couleurBase")
const couleurSecondaire = document.querySelector(".couleurSecondaire")
const couleurDaltonien = document.querySelector(".couleurDaltonien")


couleurBase.addEventListener("click", function() {
   
    document.querySelector(':root').classList.remove("active")
    document.querySelector(':root').classList.remove("daltonien")

    couleurBase.setAttribute("aria-selected", "true");
    couleurSecondaire.setAttribute("aria-selected", "false");
    couleurDaltonien.setAttribute("aria-selected", "false");
   
    sessionStorage.removeItem('color');

})


couleurSecondaire.addEventListener("click", function() {
   
    document.querySelector(':root').classList.remove("daltonien")
    document.querySelector(':root').classList.add("active")
    

    // Autre manière de selectionner le :root :
    // document.documentElement.classList.add("active")

    // if ( document.querySelector(':root').classList.contains("active") ) {
        

    couleurBase.setAttribute("aria-selected", "false");
    couleurSecondaire.setAttribute("aria-selected", "true");
    couleurDaltonien.setAttribute("aria-selected", "false");

    sessionStorage["color"] = "0";

    
})

couleurDaltonien.addEventListener("click", function() {
   
    document.querySelector(':root').classList.remove("active")
    document.querySelector(':root').classList.add("daltonien")

    couleurBase.setAttribute("aria-selected", "false");
    couleurSecondaire.setAttribute("aria-selected", "false");
    couleurDaltonien.setAttribute("aria-selected", "true");
   
    sessionStorage["color"] = "1";

})




if (sessionStorage.getItem("color") == 0){

    document.querySelector(':root').classList.add("active")
    couleurBase.setAttribute("aria-selected", "false");
    couleurSecondaire.setAttribute("aria-selected", "true");
    couleurDaltonien.setAttribute("aria-selected", "false");

} else if (sessionStorage.getItem("color") == 1){

    document.querySelector(':root').classList.add("daltonien")
    couleurBase.setAttribute("aria-selected", "false");
    couleurSecondaire.setAttribute("aria-selected", "false");
    couleurDaltonien.setAttribute("aria-selected", "true");
}



//* Le stockage local :
// https://tutowebdesign.com/localstorage-javascript.php
// https://developer.mozilla.org/fr/docs/Web/API/Window/sessionStorage
