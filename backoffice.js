/************** BACKOFFICE.PHP ***************/

// To add several films at the same time in the backoffice 
// by CLONING the form inputs on click of + button
let submitForm = document.getElementById("submit-form");
let parentNode = document.getElementById("parentNode");

document.getElementById("clone-form").addEventListener("click", function(){
    let newForm = document.getElementById("form-to-clone").cloneNode(true);
    parentNode.insertBefore(newForm, submitForm);
    /* let addFilmBtn = document.getElementById("addfilm-btn");
    addFilmBtn.type = "button"; */
});

/************************** */

document.getElementById("comments-tab").style.display = "none";
document.getElementById("users-tab").style.display = "none";

document.getElementById("movies-btn").addEventListener("click", function(){
    openTab("movies-tab");
});

document.getElementById("comments-btn").addEventListener("click", function(){
    openTab("comments-tab");
});

document.getElementById("users-btn").addEventListener("click", function(){
    openTab("users-tab");
});

function openTab(nameOfTab) {
    let tabContent = document.getElementsByClassName("tabcontent");
    for (let i= 0; i < tabContent.length; i++){
        tabContent[i].style.display = "none";
    }
    document.getElementById(nameOfTab).style.display ="block";
}

if (window.location.href.indexOf("#comments") > -1) {
    openTab("comments-tab");
}

if (window.location.href.indexOf("#movies") > -1) {
    openTab("movies-tab");
}

if (window.location.href.indexOf("#users") > -1) {
    openTab("users-tab");
}

// To make sure video uploaded if the right format
// Check on click of Include Button
document.getElementById("addfilm-btn").addEventListener("click", function(){
    let formParent = document.getElementById("parentNode").childNodes;
    let linkRegex = new RegExp("^https:\/\/www\.youtube\.com\/embed\/");
    let addFilmBtn = document.getElementById("addfilm-btn");
    let formMessage = document.getElementById("form-message");

// if only one form to add movies 
    if (formParent.length == 5){
        let firstClone = formParent[1].children[7].value;
        /* let movieLink = document.getElementById("movie-link"); */
    // if link format OK
        if (linkRegex.test(firstClone)){
            addFilmBtn.type = "submit";
    // message to display if NOT
        } else {
            formMessage.innerHTML = "The movie link must be as the following format https://www.youtube.com/embed/example."
        }
// if more than one form 
    } else if (formParent.length > 5) {
        let firstClone = formParent[1].children[7].value;
        for (let i=3; i<(formParent.length-2); i++){
            let nextClone = formParent[i].children[7].value;
            if (linkRegex.test(firstClone) && linkRegex.test(nextClone)){
                let addFilmBtn = document.getElementById("addfilm-btn");
                addFilmBtn.type = "submit";
            } else {
                formMessage.innerHTML = "The movie link must be as the following format https://www.youtube.com/embed/example."
            } 
        }
    } 
})


