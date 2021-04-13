/************** BACKOFFICE.PHP ***************/

/*========================
    TABS IN BACKOFFICE 
==========================*/

// by default hide comments and users contents
document.getElementById("comments-tab").style.display = "none";
document.getElementById("users-tab").style.display = "none";

// function to manage what happens when click on tab button or refresh page
function openTab(nameOfTab) {
    let tabContent = document.getElementsByClassName("tabcontent");
    for (let i= 0; i < tabContent.length; i++){
        tabContent[i].style.display = "none";
    }
    document.getElementById(nameOfTab).style.display ="block";
}

/*====== MOVIE TAB ======*/
// when click on movie tab button
document.getElementById("movies-btn").addEventListener("click", function(){
    openTab("movies-tab");
});
// make sure it refreshes on movie tab
if (window.location.href.indexOf("#movies") > -1) {
    openTab("movies-tab");
}

/*====== COMMENTS TAB ======*/
// when click on comments tab button
document.getElementById("comments-btn").addEventListener("click", function(){
    openTab("comments-tab");
});
// make sure it refreshes on comments tab
if (window.location.href.indexOf("#comments") > -1) {
    openTab("comments-tab");
}

/*====== USERS TAB ======*/
// when click on users tab button
document.getElementById("users-btn").addEventListener("click", function(){
    openTab("users-tab");
});
// make sure it refreshes on users tab
if (window.location.href.indexOf("#users") > -1) {
    openTab("users-tab");
}

/*========================
CLONE FORMS IN MOVIES TAB
==========================*/

// To add several films at the same time in the backoffice 
// by CLONING the form inputs on click of + button
let submitForm = document.getElementById("submit-form");
let parentNode = document.getElementById("parentNode");

document.getElementById("clone-form").addEventListener("click", function(){
    let newForm = document.getElementById("form-to-clone").cloneNode(true);
    parentNode.insertBefore(newForm, submitForm);
});

/*==========================
CHECK FORMAT OF MOVIES ADDED
============================*/

// format of films required
let linkRegex = new RegExp("^https:\/\/www\.youtube\.com\/embed\/");

/*====== BACKOFFICE.PHP#MOVIES ======*/
// Check format on click of Include Button
let addFilmBtn = document.getElementById("addfilm-btn");

addFilmBtn.addEventListener("click", function(){
    let formParent = document.getElementById("parentNode").childNodes;
    let formMessage = document.getElementById("form-message");
// if only one form to add movies 
    if (formParent.length == 5){
        let firstClone = formParent[1].children[7].value;
    // if link format OK
        if (linkRegex.test(firstClone)){
            addFilmBtn.type = "submit";
    // message to display if NOT
        } else {
            formMessage.innerHTML = "The movie link must be as the following format https://www.youtube.com/embed/example.";
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
                formMessage.innerHTML = "The movie link must be as the following format https://www.youtube.com/embed/example.";
            } 
        }
    } 
})