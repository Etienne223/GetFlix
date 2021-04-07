/************** BACKOFFICE.PHP ***************/

// To add several films at the same time in the backoffice 
// by CLONING the form inputs on click of + button
let submitForm = document.getElementById("submit-form");

document.getElementById("clone-form").addEventListener("click", function(){
    let newForm = document.getElementById("form-to-clone").cloneNode(true);
    document.getElementById("parentNode").insertBefore(newForm, submitForm);
});