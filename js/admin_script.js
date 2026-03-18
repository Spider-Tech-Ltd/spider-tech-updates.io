const menuIcon = document.querySelector('.menu-icon');
const adminSidebar = document.querySelector('.admin-sidebar');

menuIcon.addEventListener('click', ()=>{
    adminSidebar.classList.toggle('active');

});



/*let slideIndex = 0;
showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  slides[slideIndex-1].style.display = "block";
  setTimeout(showSlides, 800); // Change image every 1 seconds
}*/

document.querySelectorAll('.show-about .about .box .details').
forEach(content =>{
        if(content.innerHTML.length > 100) content.innerHTML = content.innerHTML.slice(0,100);
    });

