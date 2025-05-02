window.onload = function (){
    id = document.getElementById("id").getAttribute("value");
    // let next = parseInt(id) + 1;
    // let prev = parseInt(id);
    // if (id > 1){
    //     prev -= 1;
    // }

    document.addEventListener("keyup", (key) => {
        if (key.code === "Space"){
            window.location.href = "/UNDERPLAY/Art/display";
        }
        if (key.code === "Enter"){
            window.location.href = "/UNDERPLAY/Art/add_bg/" + id;
        }
        if (key.code === "ArrowRight"){
            window.location.href = "/UNDERPLAY/Art/next/" + id;
        }
        if (key.code === "ArrowLeft"){
            window.location.href = "/UNDERPLAY/Art/prev/" + id;
        }
        // if (key.code === "KeyF"){
        //     let image = document.getElementById("image");
        //     console.log(image);
        //     console.log(image.style.backgroundSize);
        //     let bgstyle = image.style.backgroundSize;
        //     if (bgstyle == "auto"){
        //         bgstyle = "contain";
        //     } else {
        //         bgstyle = "auto";
        //     }
        // }
    });
}