for (let j = 0; j < countRows; j++) {
    dislikebtn = document.getElementById('dislikebtn')[j]
    dislikebtn.addEventListener("click", () => {
        alert('disliked')
    })
}