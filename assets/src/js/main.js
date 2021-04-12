import GLightbox from 'glightbox';
import Splide from '@splidejs/splide';

const splide_settings = {
	/**
	 * Splide all settings
	 */

	init() {
		// check splide
		const splider = document.querySelector( '.splide' );
		if ( splider ) {
			const secondarySlider = new Splide( '#gallery__dots', {
				fixedWidth: 100,
				height: 60,
				gap: 10,
				cover: true,
				isNavigation: true,
				pagination: false,
				focus: 'center',
				breakpoints: {
					600: {
						fixedWidth: 66,
						height: 40,
					},
				},
			} ).mount();

			const primarySlider = new Splide( '#gallery__cover', {
				type: 'fade',
				heightRatio: 0.5,
				pagination: false,
				arrows: false,
				cover: true,
				lazyLoad: true,
			} ); // do not call mount() here.

			primarySlider.sync( secondarySlider ).mount();
		}
	},
};

const smooth_scroll = {
	/**
	 * Smooth scroll to anchor
	 */
	init() {
		// add anchors
		document.querySelectorAll( 'a[href^="#"]' ).forEach( ( event ) => {
			event.onclick = function( e ) {
				e.preventDefault();
				const hash = this.getAttribute( 'href' ),
					target = document.querySelector( hash ),
					headerOffset = 0,
					elementPosition = target.offsetTop,
					offsetPosition = elementPosition + headerOffset;

				window.scrollTo( {
					top: offsetPosition,
					behavior: 'smooth',
				} );
			};
		} );
	},
};

const glight = {
	/**
	 * Glight gallery
	 */
	init() {
		const lightbox = GLightbox( {
			touchNavigation: true,
			loop: false,
			autoplayVideos: true,
		} );
	},
};

const ieverly_property = {
	/**
	 * Filter and Load more
	 */
	filter() {
		/**
		 * Price replace
		 */
		function price_replace() {
			document.querySelectorAll( '.price-replace' ).forEach( ( event ) => {
				const price = event.textContent;
				event.textContent = price.replace( /(\d)(?=(\d\d\d)+(?!\d))/g, '$1,' );
			} );
		}

		const price_replace_init = document.querySelector( '.price-replace' );
		if ( price_replace_init ) {
			price_replace();
		}

		// check filter
		const property__filter = document.querySelector( '#property__filter' );
		if ( property__filter ) {
			// show loading section
			function property__loading() {
				const property__loading_box = document.querySelector( '.property__loading' );
				property__loading_box.classList.toggle( 'active' );
			}

			/**
			 * Load more
			 */
			const loadmore__button = document.querySelector( '#property__loadmore' );
			function property__loadmore() {
				const data = new FormData();
				data.append( 'action', 'loadmorebutton' );
				data.append( 'query', posts );
				data.append( 'page', current_page );

				fetch( ajaxurl, {
					method: 'POST',
					body: data,
				} )
					.then( ( response ) => response.text() ) // parse response as JSON (can be res.text() for plain response)
					.then( ( response ) => {
						if ( response ) {
							document.querySelector( '#property__items' ).innerHTML += response; // append items
							current_page++; // add current page
							price_replace(); // price replace
							loadmore__button.innerHTML = loadmore__text; // reset loadmore button text
							loadmore__button.classList.remove( 'active' );

							// url replace
							const cur_url = document.URL;
							if ( cur_url.indexOf( '?' ) > -1 ) {
								var cur_url_filter = cur_url.replace( /property\S*\?/g, 'property/page/' + current_page + '/?' );
							} else {
								var cur_url_filter = cur_url.replace( /property\S*/, 'property/page/' + current_page + '/' );
							}
							history.pushState( null, null, cur_url_filter );

							property__loading(); // loading animation
							// remove button if last page
							if ( current_page == max_page ) {
								document.querySelector( '#property__loadmore' ).style.display = 'none';
							}
						} else {
							document.querySelector( '#property__loadmore' ).style.display = 'none';
						}
					} )
					.catch( ( error ) => {
						console.log( error );
					} );
				return false;
			}

			if ( loadmore__button ) {
				var loadmore__text = loadmore__button.innerHTML,
					loadmore__loading = loadmore__button.dataset.loading;

				// click loadmore
				loadmore__button.addEventListener( 'click', () => {
					loadmore__button.innerHTML = loadmore__loading;
					loadmore__button.classList.add( 'active' );
					property__loading();
					property__loadmore();
				} );
			}

			// disable loadmore button
			if ( current_page == max_page ) {
				document.querySelector( '#property__loadmore' ).style.display = 'none';
			}

			/**
			 * Filter
			 */
			function property__response() {
				const form = document.querySelector( '#property__filter' ),
					data = new FormData( form ),
					url_list = new URLSearchParams( data ).toString();

				fetch( ajaxurl, {
					method: 'POST',
					body: data,
				} )
					.then( ( response ) => response.json() ) // parse response as JSON (can be res.text() for plain response)
					.then( ( response ) => {
						current_page = 1;
						posts = response.posts;
						max_page = response.max_page;
						document.querySelector( '#property__found-posts' ).innerHTML = response.found_posts; // change count in listing found
						document.querySelector( '#property__items' ).innerHTML = response.content; // append
						price_replace(); // price replace

						// url replace
						const cur_url = document.URL,
							url_list_filter = '?' + url_list.replace( /&action=property__filter\S*/gi, '' );

						if ( cur_url.indexOf( 'page' ) > -1 ) {
							var cur_url_filter = cur_url.replace( /property\/page\/*\S/g, 'property/' + url_list_filter );
						} else {
							var cur_url_filter = url_list_filter;
						}
						history.pushState( null, null, cur_url_filter );

						property__loading(); // loading animation
						if ( response.max_page < 2 ) {
							document.querySelector( '#property__loadmore' ).style.display = 'none';
						} else {
							document.querySelector( '#property__loadmore' ).style.display = '';
						}
					} )
					.catch( ( error ) => {
						console.log( error );
					} );

				return false;
			}

			const button__search = document.querySelector( '.button__search' );

			// click button
			button__search.addEventListener( 'click', () => {
				property__loading();
				property__response();
				button__search.classList.remove( 'light' );
			} );

			// change sort
			document.querySelector( '.property__sort-items' ).addEventListener( 'change', () => {
				property__loading();
				property__response();
				button__search.classList.remove( 'light' );
			} );

			// add button shadow
			document.querySelector( '.filter__list' ).addEventListener( 'change', () => {
				button__search.classList.add( 'light' );
			} );

			// reset
			document.querySelector( '.button__reset' ).addEventListener( 'click', () => {
				document.querySelector( '#property__filter' ).reset();
				property__loading();
				property__response();
				button__search.classList.remove( 'light' );
			} );
		}
	},
};

document.addEventListener( 'DOMContentLoaded', () => {
	smooth_scroll.init();
	glight.init();
	ieverly_property.filter();
	splide_settings.init();
} );
