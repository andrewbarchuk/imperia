import Glide from '@glidejs/glide';
import Isotope from 'isotope-layout';
import * as basicScroll from 'basicscroll';
import imagesLoaded from 'imagesloaded';
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

const animation = {
	/**
	 * Animation ande effects
	 */
	init() {
		// menu toggle
		const menu_button = document.querySelector('.site__header-menu-button');
		const menu_box = document.querySelector('.site__header-menu');

		menu_button.addEventListener('click', function (event) {
			menu_button.classList.toggle('active');
			menu_box.classList.toggle('active');
		});

		if (window.matchMedia('(min-width: 992px)').matches) {
			// create and duplicate text
			document.querySelectorAll('.back-text').forEach((elem, i) => {
				const text_in = elem.innerText;
				const text_span_create = document.createElement('span');
				const text_span = elem.appendChild(text_span_create);
				text_span.textContent = text_in;
				setTimeout(() => text_span_create.classList.add('animate'), i * 500);
			});

			// parallax
			let parallax_sections = document.querySelectorAll(
				'.back-text span, .history__portfolio-box'
			);
			for (let parallax_section of parallax_sections) {
				let _from = parallax_section.getAttribute('data-from') || '0%';
				let _to = parallax_section.getAttribute('data-to') || '-30%';
				let instance = basicScroll.create({
					elem: parallax_section,
					from: 'top-top',
					to: 'bottom-bottom',
					direct: true,
					props: {
						'--ty': {
							from: _from,
							to: _to,
						},
					},
				});
				instance.start();
			}
		}
	},
};

const smooth_scroll = {
	/**
	 * Smooth scroll to anchor & header fix
	 */
	init() {
		// for header
		const el = document.querySelector('.site__header');
		const observer = new IntersectionObserver(
			([e]) => e.target.classList.toggle('active', e.intersectionRatio < 1),
			{ threshold: [1] }
		);

		observer.observe(el);

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

const isotope = {
	/**
	 * Isotope for portfolio
	 */
	init() {
		const elem = document.querySelector('.home-portfolio__tags');
		if (elem) {
			var grid = document.querySelector('.home-portfolio__list');
			var iso;
			imagesLoaded(grid, function () {
				iso = new Isotope(grid, {
					itemSelector: '.portfolio__item',
					percentPosition: true,
					masonry: {
						columnWidth: '.grid-sizer',
					},
				});
			});

			// check filter & active
			const tags = document.querySelectorAll('.home-portfolio__tags button');
			tags.forEach((elem, i) => {
				elem.addEventListener('click', function (elems, i) {
					var filterValue = elems.target.getAttribute('data-filter');
					iso.arrange({ filter: filterValue });
				});
			});

			for (var i = 0; i < tags.length; i++) {
				tags[i].addEventListener('click', tagsClick);
			}

			function tagsClick(event) {
				var button = event.target;
				button.parentNode.querySelector('.active').classList.remove('active');
				button.classList.add('active');
			}
		}
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
	animation.init();
	smooth_scroll.init();
	isotope.init();
	glight.init();
});
