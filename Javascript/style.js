// Change background color according to the scroll position

window.addEventListener('scroll', ()=>{
    scrollPosition = window.scrollY;
    document.querySelector('nav').style.height ="75px";
    if (scrollPosition >= 50 && window.innerWidth < 1100) {
        var element = document.querySelector('header');
        var ul = document.getElementById('navLink');
        var ul2 = document.getElementById('profil');
        element.classList.add('active');
        ul.style.display ="none";
        ul2.style.display ="none";

    } else if (scrollPosition <= 50 && window.innerWidth < 1100) {
        var elementHeader = document.querySelector('header');
        var ul = document.getElementById('navLink');
        var ul2 = document.getElementById('profil');
        elementHeader.classList.remove('active'); 
        ul.style.display ="block";
        ul2.style.display ="block";
    } else if (scrollPosition >= 50 && window.innerWidth > 1100){
        var element = document.querySelector('header');
        var ul = document.getElementById('navLink');
        element.classList.add('active');
        ul.style.display ="block";
        
    } else {
        var elementHeader = document.querySelector('header');
        elementHeader.classList.remove('active');
        var ul = document.getElementById('navLink');
    }
});

window.addEventListener("resize", () =>{
    if (window.innerWidth > 1100){
        var ul = document.getElementById('navLink');
        ul.style.transform = "translateY(0px)";
        
    }

    else {
        var ul = document.getElementById('navLink');
        ul.style.transform = "translateY(-400px)";

    }
})

// Display menu or not according to his state

document.getElementById('burger').addEventListener("click", ()=>{
    if( document.getElementById("navLink").style.transform === "translateY(-400px)" && window.innerWidth < 1100 ){
    document.querySelector('body').classList.add('no-scroll');
    document.getElementById('navLink').style.display ="block";
    document.getElementById("navLink").style.transform = "translateY(0px)";
    document.querySelector('header').classList.add('active');
    } else {
        document.getElementById("navLink").style.transform = "translateY(-400px)" ;
        document.querySelector('body').classList.remove('no-scroll');
        document.querySelector('header').classList.remove('active');
    }

})

