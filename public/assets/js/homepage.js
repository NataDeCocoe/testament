const images = [
    '/assets/images/book.jpg',
    '/assets/images/book2.jpg',
    '/assets/images/book3.jpg'
];

let currentIndex = 0;
const container = document.getElementById('caro');

container.style.backgroundImage = `url(${images[currentIndex]})`;

function transitionToNextImage() {

    container.classList.add('fade-out');

    setTimeout(() => {
        // Change image
        currentIndex = (currentIndex + 1) % images.length;
        container.style.backgroundImage = `url(${images[currentIndex]})`;

        // Start fade in
        container.classList.remove('fade-out');
    }, 1000);
}

setInterval(transitionToNextImage, 4000);


// window.addEventListener('resize', () => {
//     const width = window.innerWidth;
//     const sidebar = document.querySelector('.side');
//
//     if (width <= 768) {
//         sidebar.classList.remove('.sb-collapse');
//         sidebar.style.display = 'none';
//     }
// });
// window.dispatchEvent(new Event('resize'));

//PROFILE
const fileInput = document.getElementById('fileInput');
const profilePic = document.getElementById('profilePic');

fileInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            profilePic.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});