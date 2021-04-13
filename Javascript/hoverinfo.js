/***********************************************************
SCRIPT USED FOR moviescatalog.php, search.php and mylist.php
************************************************************/

// getting arrays (on file generalsettings.php) with rowcount
console.log(countRows)  

for (let j = 0; j < countRows; j++) {
    // SHOW HOVER HIDDEN ELEMENT
    let hoverdetail = document.getElementsByClassName('hover-detail')[j];
    hoverdetail.style.opacity = "0";

    let moviesbox = document.getElementsByClassName('movies-box')[j];
    moviesbox.addEventListener("mouseover", () => {
        hoverdetail.style.opacity = "1";
    })

    moviesbox.addEventListener("mouseout", () => {
        hoverdetail.style.opacity = "0";
    })
}
