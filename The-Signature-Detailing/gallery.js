const images = [
	{ src: "./Images/porsche-1.jpg", alt: "Porsche 911" },
	{ src: "./Images/porsche-2.jpg", alt: "Porsche Cayenne" },
	{ src: "./Images/porsche-3.jpg", alt: "Porsche Macan" },
	{ src: "./Images/porsche-4.jpg", alt: "Porsche Panamera" },
	{ src: "./Images/porsche-5.jpg", alt: "Porsche Panamera" },
	{ src: "./Images/porsche-6.jpg", alt: "Porsche Panamera" },
	{ src: "./Images/porsche-7.jpg", alt: "Porsche Panamera" },
	{ src: "./Images/porsche-8.jpg", alt: "Porsche Panamera" },
	{ src: "./Images/porsche-9.jpg", alt: "Porsche Panamera" },
	{ src: "./Images/porsche-10.jpg", alt: "Porsche Panamera" },
	{ src: "./Images/bmw-1.jpg", alt: "BMW M3" },
	{ src: "./Images/bmw-2.jpg", alt: "BMW M4" },
	{ src: "./Images/bmw-3.jpg", alt: "BMW X5" },
	{ src: "./Images/bmw-4.jpg", alt: "BMW Z4" },
	{ src: "./Images/bmw-5.jpg", alt: "BMW X6" },
	{ src: "./Images/bmw-6.jpg", alt: "BMW X7" },
	{ src: "./Images/bmw-7.jpg", alt: "BMW X8" },
	{ src: "./Images/bmw-8.jpg", alt: "BMW X9" },
	{ src: "./Images/bmw-9.jpg", alt: "BMW X10" },
	{ src: "./Images/bmw-10.jpg", alt: "BMW X11" },
];

const gallery = document.getElementById('workGallery');
const showMoreBtn = document.getElementById('showMoreBtn');
let shown = 0;
const initial = 8;
const step = 4;

function renderGallery() {
	gallery.innerHTML = '';
	for (let i = 0; i < shown; i++) {
		if (images[i]) {
			const div = document.createElement('div');
			div.className = 'work-item';
			const img = document.createElement('img');
			img.src = images[i].src;
			img.alt = images[i].alt;
			div.appendChild(img);
			gallery.appendChild(div);
		}
	}
}

function showMore() {
	shown += step;
	if (shown >= images.length) {
		shown = images.length;
		showMoreBtn.style.display = 'none';
	}
	renderGallery();
}

function initGallery() {
	shown = initial;
	renderGallery();
	showMoreBtn.style.display = images.length > initial ? 'inline-block' : 'none';
	showMoreBtn.onclick = showMore;
}

document.addEventListener('DOMContentLoaded', initGallery);
