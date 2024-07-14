const button = document.querySelector(".buttonAddComment")
const form = document.querySelector(".formulaireAjout")


button.addEventListener("click", function() {
   
    button.classList.add("disappear")
    form.classList.add("appear")

})