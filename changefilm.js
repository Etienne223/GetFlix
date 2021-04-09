/*====== CHANGEFILM.PHP#MOVIES ======*/

/*============================
CHECK FORMAT OF MOVIES UPDATED
==============================*/


let updateMessage = document.getElementById("update-message");
let movieLinkUpdate = document.getElementById("movie-link-update").value;
let linkRegex = new RegExp("^https:\/\/www\.youtube\.com\/embed\/");
let changeFilmBtn = document.getElementById("change-movie");


/* movieLinkUpdate.addEventListener("input", function(){ */
    
changeFilmBtn.addEventListener("click", function(){
    
    if (linkRegex.test(movieLinkUpdate)){
        changeFilmBtn.type = "submit";
    } else {
        updateMessage.innerHTML = "The movie link must be as the following format https://www.youtube.com/embed/example.";
    } 
})
/* }) */
