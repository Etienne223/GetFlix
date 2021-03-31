// CLICK ARROW BUTTONS
    // getting array (on file generalsettings.php) with movies genres --> let movieGenres
    console.log(moviesGenres)
    showMoviesData();

    for (let i = 0; i < moviesGenres.length; i++) {
        let scrollPerClick
        let scrollAmount = 0 
        
        // get "images-container" to be scrolled
        const imagesContainers = document.getElementsByClassName('images-container')[i]
        console.log(imagesContainers)

        // get buttons left and right buttons and create its function to slide
        let leftArrows = document.getElementsByClassName('left-arrow')[i]
        leftArrows.addEventListener("click", () => {
            //alert('left')
            imagesContainers.scrollTo({
                top: 0,
                left: (scrollAmount -= scrollPerClick),
                behavior: "smooth",
            })

            if (scrollAmount < 0) {
                scrollAmount = 0
            }
            console.log("Scroll Amount Left: ", scrollAmount);
        }) 

        let rightArrows = document.getElementsByClassName('right-arrow')[i]
        rightArrows.addEventListener("click", () => {
            //alert('right')
            if (scrollAmount <= imagesContainers.scrollWidth - imagesContainers.clientWidth) {
                imagesContainers.scrollTo({
                  top: 0,
                  left: (scrollAmount += scrollPerClick),
                  behavior: "smooth",
                });
              }
              console.log("Scroll Amount Right: ", scrollAmount);
        }) 

       
        function showMoviesData() {
            scrollPerClick = document.querySelector('movies-box').clientWidth + 20
    
        }
    }

    






/* let movie = document.getElementById('oi');
movie.onmouseover = function (){
    document.getElementById('hi').innerHTML = "worked"
    document.getElementById('<?php echo $id; ?>').style.visibility = "visible"
}  */