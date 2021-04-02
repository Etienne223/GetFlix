// Disable Splash after 5s
const splash = document.querySelector('.splash');
document.addEventListener('DOMContentLoaded', (e)=>{

    setTimeout(()=>{
        splash.classList.add('display-none');
    }, 5000);

})

// Change background color according to the scroll position

window.addEventListener('scroll', ()=>{
    scrollPosition = window.scrollY;

    if (scrollPosition >= 50) {
        var element = document.querySelector('header');
        element.classList.add('active');
    } else {
        var elementHeader = document.querySelector('header');
        elementHeader.classList.remove('active');
    }
});

// Display menu or not according to his state

document.getElementById('burger').addEventListener("click", ()=>{
    if( document.getElementById("navLink").style.transform === "translateY(-400px)"){
    document.getElementById("navLink").style.transform = "translateY(0px)";
    document.querySelector('header').classList.add('active');
    } else {
        document.getElementById("navLink").style.transform = "translateY(-400px)";
        document.querySelector('header').classList.remove('active');
    }

})