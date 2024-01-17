var backgroundColors = ["#581845", "#C70039", "#FFC300"];
var currentColorIndex = 0;

var backgroundImages = ["./img/bb1.jpg", "./img/bb2.jpg", "./img/bb3.jpg", "./img/tło.jpg", "./img/tło2.jpg"];
var currentImageIndex = 0;

function changeBackgroundColor() {

    document.body.style.backgroundColor = backgroundColors[currentColorIndex];

    currentColorIndex = (currentColorIndex + 1) % backgroundColors.length;
    
    document.body.style.backgroundImage = "none";
}

function changeBackgroundImage() {

    document.body.style.backgroundImage = "url('" + backgroundImages[currentImageIndex] + "')";

    currentImageIndex = (currentImageIndex + 1) % backgroundImages.length;
    
    document.body.style.backgroundColor = "";
}