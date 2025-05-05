const images = [
    '/assets/images/book.jpg',
    '/assets/images/book2.jpg',
    '/assets/images/book3.jpg'
];

let currentIndex = 0;
const container = document.getElementById('caro');

function updateImage() {
    container.style.backgroundImage = `url(${images[currentIndex]})`;
}


setInterval(() => {
    currentIndex = (currentIndex + 1) % images.length;
    updateImage();
}, 5000);


updateImage();


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

