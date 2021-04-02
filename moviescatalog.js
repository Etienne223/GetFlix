// getting arrays (on file generalsettings.php) with movies genres and rowcount
console.log(moviesGenres)   
console.log(countRows)  

for (let i = 0; i < moviesGenres.length; i++) {
    let scrollPerClick
    let scrollAmount = 0 

    // get elements (carouselbox will be scrolled with arrows)
    let carouselbox = document.getElementsByClassName('carouselbox')[i]
    let leftArrows = document.getElementsByClassName('left-arrow')[i]
    let rightArrows = document.getElementsByClassName('right-arrow')[i]

    leftArrows.style.visibility = "hidden"
    rightArrows.style.visibility = "hidden"


    // SHOW / HIDE ARROWS ON HOVER          
        carouselbox.addEventListener("mouseover", () => {
            leftArrows.style.visibility = "visible"
            rightArrows.style.visibility = "visible"
            
            leftArrows.addEventListener("mouseover", () => {
                leftArrows.style.visibility = "visible"
            })

            rightArrows.addEventListener("mouseover", () => {
                rightArrows.style.visibility = "visible"
            })
        })

        carouselbox.addEventListener("mouseout", () => {
            leftArrows.style.visibility = "hidden"
            rightArrows.style.visibility = "hidden"     
        })


    // CLICK ARROW BUTTONS
        // get buttons left and right buttons and create its function to scroll
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

        function move() {
            scrollPerClick = document.getElementsByClassName('movies-box')[i].clientWidth + 20;
        }
        move()
}

// SHOW HOVER HIDDEN ELEMENT
for (let i = 0; i < countRows; i++) {
    let hoverdetail = document.getElementsByClassName('hover-detail')[i]
    hoverdetail.style.visibility = "hidden"

    let moviesbox = document.getElementsByClassName('movies-box')[i]
    moviesbox.addEventListener("mouseover", () => {
        hoverdetail.style.visibility = "visible"
    })

    moviesbox.addEventListener("mouseout", () => {
        hoverdetail.style.visibility = "hidden"
    })
}