// Count how many caracters in comment text
document.getElementById("comment_text").addEventListener("input", function(){
    let textAreaCheck = document.getElementById("comment_text");
    textAreaCheck.maxLength = 500;
    for (let i=0; i<=500; i++) {
        if (textAreaCheck.value.length == i) {
            document.getElementById("count").innerHTML = `${i}/500`;
                /* if (textAreaCheck.value.length >= 950 && textAreaCheck.value.length <= 500) {
                    document.getElementById("count").style.color ="red";
                } else {
                    document.getElementById("count").style.color = "initial";
                } */
            }
        };
});

