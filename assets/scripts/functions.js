import Glide from '@glidejs/glide';
import GLightbox from 'glightbox';

const glide_settings = {
	/**
	 * Glide all settings
	 */

	init() {
		const elem = document.querySelector('.glide');
		if (elem) {
			// Component lenght
			const CustomLength = function (Glide, Components, Events) {
				return {
					mount() {
						Events.emit('slider.length', Components.Sizes.length);
					},
				};
			};

			// Glide settings
			const glide = new Glide('.glide', {
				type: 'carousel',
				gap: '0',
			});

			// Current slide
			const glide_curent = document.querySelector('#glide-current');
			glide.on(['build.after', 'run'], function () {
				glide_curent.innerHTML = glide.index + 1;
			});

			// Total slides
			const glide_total = document.querySelector('#glide-total');
			glide.on('slider.length', (length) => {
				glide_total.innerHTML = length;
			});

			// Glide mount
			glide.mount({
				CustomLength,
			});
		}
	},
};

const smooth_scroll = {
	/**
	 * Smooth scroll to anchor
	 */
	init() {
		// add anchors
		document.querySelectorAll('a[href^="#"]').forEach((trigger) => {
			trigger.onclick = function (e) {
				e.preventDefault();
				let hash = this.getAttribute('href');
				let target = document.querySelector(hash);
				let headerOffset = 0;
				let elementPosition = target.offsetTop;
				let offsetPosition = elementPosition + headerOffset;

				window.scrollTo({
					top: offsetPosition,
					behavior: 'smooth',
				});
			};
		});
	},
};

const glight = {
	/**
	 * Glight gallery
	 */
	init() {
		const lightbox = GLightbox({
			touchNavigation: true,
			loop: false,
			autoplayVideos: true,
		});
	},
};

document.addEventListener('DOMContentLoaded', () => {
	glide_settings.init();
	smooth_scroll.init();
	glight.init();
});
