 // CLICK ARROW BUTTONS
    // getting array (on file generalsettings.php) with movies genres --> let movieGenres
    console.log(moviesGenres)   

    for (let i = 0; i < moviesGenres.length; i++) {
        let scrollPerClick
        let scrollAmount = 0 

        // get "images-container" to be scrolled
        const carouselbox = document.getElementsByClassName('carouselbox')[i]
        console.log(carouselbox)

        // get buttons left and right buttons and create its function to slide
        let leftArrows = document.getElementsByClassName('left-arrow')[i]
        leftArrows.addEventListener("click", () => {
            carouselbox.scrollTo({
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
            if (scrollAmount <= carouselbox.scrollWidth - carouselbox.clientWidth) {
                carouselbox.scrollTo({
                top: 0,
                left: (scrollAmount += scrollPerClick),
                behavior: "smooth",
              });
            }
            console.log("Scroll Amount: ", scrollAmount);
        })

        // For showing dynamic contents only
        function showMoviesData() {
            scrollPerClick = document.getElementsByClassName('movies-box')[i].clientWidth + 20;
        }
        showMoviesData()

    }
 

