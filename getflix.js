/************** FILMDESCRIPTION.PHP ***************/

// Display comments form on button 'Leave Comment' click 
document.getElementById("leavecomment-area").style.display = "none";
let hasBeenClicked = false;
document.getElementById("btn-leavecomment").addEventListener("click", function(){
    hasBeenClicked = !hasBeenClicked;
    if (hasBeenClicked){
        document.getElementById("leavecomment-area").style.display = "block";
    } else {
        document.getElementById("leavecomment-area").style.display = "none";
    }  
});

// Count how many caracters in comment text out of 500
document.getElementById("comment_text").addEventListener("input", function(){
    let textAreaCheck = document.getElementById("comment_text");
    textAreaCheck.maxLength = 500;
    for (let i=0; i<=500; i++) {
        if (textAreaCheck.value.length == i) {
            document.getElementById("count").innerHTML = `${i}/500`;
            }
        };
});

// Hide comments form on button 'Submit' comment click
document.getElementById("submit-comment").addEventListener("click", function(){
    document.getElementById("leavecomment-area").style.display = "none";
})

// Hide 'Modify' comment buttons when clicked on one
document.getElementsByClassName("modify-action").addEventListener("click", function(){
    let element = document.getElementsByClassName("modify-action");
    for (let i=0; i <= element.length; i++){
        element[i].style.display = "none";
    }
})

// To display button "See all comments" only when 5 or more
let numberOfComments = document.getElementsByClassName("comments").length;
if (numberOfComments < 5) {
    document.getElementById("btn-seeall").style.display = "none";
};