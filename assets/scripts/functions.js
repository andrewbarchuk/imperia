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

const ieverly_property = {
	/**
	 * Filter
	 */
	filter() {
		function property__response() {
			const form = document.querySelector('#property__filter'),
				data = new FormData(form),
				url_list = new URLSearchParams(data).toString(),
				url_list_filter = '?' + url_list.replace(/&action=property__filter\S*/gi, ''),
				property__items = document.querySelector('#property__items');

			fetch(ajaxurl, {
				method: 'POST',
				body: data
			})
				.then(response => response.json()) // parse response as JSON (can be res.text() for plain response)
				.then(response => {

					current_page = 1;

					posts = response.posts;
					max_page = response.max_page;

					document.querySelector('#property__found-posts').innerHTML = response.found_posts;

					document.querySelector('#property__items').innerHTML = response.content;
					history.pushState(null, null, url_list_filter);
					property__items.classList.remove('active');

					if (response.max_page < 2) {
						document.querySelector('#property__loadmore').style.display = 'none';
					} else {
						document.querySelector('#property__loadmore').style.display = '';
					}
				})
				.catch(error => {
					console.log(error);
				});

			return false;
		}

		const button__search = document.querySelector('.button__search');
		button__search.addEventListener('click', (event) => {
			property__items.classList.add('active');
			property__response();
			button__search.classList.remove('light');
		});

		document.querySelector('#property__filter').addEventListener('change', (event) => {
			button__search.classList.add('light');
		});

		document.querySelectorAll('.price-replace').forEach((elem, i) => {
			const price = elem.textContent;
			elem.textContent = price.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
		});
	},

	/**
	 * Load more
	 */
	loadmore() {
		const loadmore__button = document.querySelector('#property__loadmore'),
			loadmore__text = loadmore__button.innerHTML,
			loadmore__loading = loadmore__button.dataset.loading;

		function property__loadmore() {
			const data = new FormData();
			data.append('action', 'loadmorebutton');
			data.append('query', posts);
			data.append('page', current_page);

			fetch(ajaxurl, {
				method: 'POST',
				body: data
			})
				.then(response => response.text()) // parse response as JSON (can be res.text() for plain response)
				.then(response => {
					if (response) {
						// add current page
						current_page++;
						// append items
						document.querySelector('#property__items').innerHTML += response;
						// reset loadmore button text
						loadmore__button.innerHTML = loadmore__text;
						loadmore__button.classList.remove('active');
						property__items.classList.remove('active');
						// remove button if last page
						if (current_page == max_page) document.querySelector('#property__loadmore').style.display = 'none';
					} else {
						document.querySelector('#property__loadmore').style.display = 'none';
					}
				})
				.catch(error => {
					console.log(error);
				});
		}

		// click loadmore
		loadmore__button.addEventListener('click', (event) => {
			loadmore__button.innerHTML = loadmore__loading;
			loadmore__button.classList.add('active');
			property__items.classList.add('active');
			property__loadmore();
		});

	},
};

document.addEventListener('DOMContentLoaded', () => {
	glide_settings.init();
	smooth_scroll.init();
	glight.init();
	ieverly_property.filter();
	ieverly_property.loadmore();
});
