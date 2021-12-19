var nslide = 1;
slideshow(nslide);

function nextslide(n) {
  slideshow(nslide += n);
}

function currentSlide(n) {
  slideshow(nslide = n);
}

function slideshow(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {nslide = 1}    
  if (n < 1) {nslide = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[nslide-1].style.display = "block";  
  dots[nslide-1].className += " active";
} 
