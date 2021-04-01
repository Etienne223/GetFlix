const splash = document.querySelector('.splash');

document.addEventListener('DOMContentLoaded', (e)=>{

    setTimeout(()=>{
        splash.classList.add('display-none');
    }, 5000);

})


 document.addEventListener("scroll", ()=> {
        if($(window).scrollTop() > 50) {
            $(".header").addClass("active");
        } else {
            //remove the background property so it comes transparent again (defined in your css)
           $(".header").removeClass("active");
        }
    });
