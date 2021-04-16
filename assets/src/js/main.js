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

const menu_button = {
	/**
	 * Toggle menu
	 */
	init() {
		// Menu toggle button
		function navigation_togge() {
			const siteNavigation = document.querySelector( '.site__header-nav-box' ),
				button = document.querySelector( '.site__header-menu-button' ),
				menu = siteNavigation.getElementsByTagName( 'ul' )[ 0 ];

			if ( ! menu.classList.contains( 'nav-menu' ) ) {
				menu.classList.add( 'nav-menu' );
			}

			function toggled_menu() {
				siteNavigation.classList.toggle( 'active' );
				const overflow = document.querySelector( 'body' );

				if ( button.getAttribute( 'aria-expanded' ) === 'true' ) {
					button.setAttribute( 'aria-expanded', 'false' );
					overflow.style.removeProperty( 'overflow' );
				} else {
					button.setAttribute( 'aria-expanded', 'true' );
					overflow.style.overflow = 'hidden';
				}
			}

			// Toggle the .toggled class and the aria-expanded value each time the button is clicked.
			button.addEventListener( 'click', function() {
				toggled_menu();
			} );

			// Toogle when click # tag
			document.querySelectorAll( '.site__header-nav-box a[href^="#"]' ).forEach( ( event ) => {
				event.addEventListener( 'click', function() {
					siteNavigation.classList.remove( 'active' );
					button.setAttribute( 'aria-expanded', 'false' );
					document.querySelector( 'body' ).style.removeProperty( 'overflow' );
				} );
			} );
		}
		navigation_togge();
	},
};

const ieverly_property = {
	/**
	 * Filter and Load more
	 */
	filter() {
		/**
		 * Price replace
		 *
		 * @param {price_replace_init} price_replace_init
		 */
		function price_replace( price_replace_init ) {
			const price_replace_box = document.querySelectorAll( price_replace_init );
			if ( price_replace_box ) {
				price_replace_box.forEach( ( event ) => {
					const price = event.textContent;
					event.textContent = price.replace( /(\d)(?=(\d\d\d)+(?!\d))/g, '$1,' );
				} );
			} else {
				console.log( 'check price replace function and class' );
			}
		}

		price_replace( '.price-replace' );

		/*global posts, current_page, max_page, ajaxurl*/

		/**
		 * Property
		 */
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
			const loadmore__button = document.querySelector( '#property__loadmore' ),
				loadmore__text = loadmore__button.innerHTML;

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
							price_replace( '.price-replace' ); // price replace
							loadmore__button.innerHTML = loadmore__text; // reset loadmore button text
							loadmore__button.classList.remove( 'active' );

							// url replace
							const cur_url = document.URL;
							let cur_url_filter;
							if ( cur_url.indexOf( '?' ) > -1 ) {
								cur_url_filter = cur_url.replace( /\/property\S*\?/g, '/property/page/' + current_page + '/?' );
							} else {
								cur_url_filter = cur_url.replace( /\/property\S*/, '/property/page/' + current_page + '/' );
							}
							history.pushState( null, null, cur_url_filter );

							console.log( 'success load more' );

							property__loading(); // loading animation
							// remove button if last page
							if ( current_page == max_page ) {
								loadmore__button.style.display = 'none';
							}
						} else {
							loadmore__button.style.display = 'none';
						}
					} )
					.catch( ( error ) => {
						console.log( error );
					} );
				return false;
			}

			if ( loadmore__button ) {
				const loadmore__loading = loadmore__button.dataset.loading;
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
				loadmore__button.style.display = 'none';
			}

			/**
			 * Filter
			 */
			function property__response() {
				const data = new FormData( property__filter ),
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
						price_replace( '.price-replace' ); // price replace

						// url replace
						const cur_url = document.URL,
							url_list_filter = '?' + url_list.replace( /&action=property__filter\S*/gi, '' );
						let cur_url_filter;
						if ( cur_url.indexOf( 'page' ) > -1 ) {
							cur_url_filter = cur_url.replace( /\/property\/page\/*\S/g, '/property/' + url_list_filter );
						} else {
							cur_url_filter = url_list_filter;
						}
						history.pushState( null, null, cur_url_filter );

						console.log( 'success filter' );

						property__loading(); // loading animation
						if ( response.max_page < 2 ) {
							loadmore__button.style.display = 'none';
						} else {
							loadmore__button.style.display = '';
						}
					} )
					.catch( ( error ) => {
						console.log( error );
					} );

				return false;
			}

			const button__search = document.querySelector( '.button__search' );
			// click search button
			button__search.addEventListener( 'click', () => {
				if ( window.matchMedia( '(max-width: 992px)' ).matches ) {
					filter_show();
					window.scrollTo( {
						top: 0,
						behavior: 'smooth',
					} );
				}
				property__loading();
				property__response();
				button__search.classList.remove( 'light' );
			} );

			// change sort and count on page
			document.querySelector( '.property__sort-items' ).addEventListener( 'change', () => {
				property__loading();
				property__response();
				button__search.classList.remove( 'light' );
			} );

			// add button shadow
			document.querySelector( '.filter__list' ).addEventListener( 'change', () => {
				button__search.classList.add( 'light' );
			} );

			/**
			 * Clear form
			 *
			 * @param {clear_form_init} clear_form_init
			 */
			function clear_form( clear_form_init ) {
				console.log( 'clear filter' );
				const elements = clear_form_init.elements;
				clear_form_init.reset();
				for ( let i = 0; i < elements.length; i++ ) {
					const field_type = elements[ i ].type.toLowerCase();
					switch ( field_type ) {
						case 'text':
						case 'password':
						case 'textarea':
						case 'number':
							elements[ i ].value = '';
							break;
						case 'radio':
						case 'checkbox':
							if ( elements[ i ].checked ) {
								elements[ i ].checked = false;
							}
							break;
						case 'select-one':
						case 'select-multi':
							elements[ i ].selectedIndex = 0;
							break;
						default:
							break;
					}
				}
			}

			// reset
			document.querySelector( '.button__reset' ).addEventListener( 'click', () => {
				clear_form( property__filter );
				if ( window.matchMedia( '(min-width: 992px)' ).matches ) {
					property__loading();
					property__response();
				}
				button__search.classList.remove( 'light' );
			} );

			// show filter if home page
			function filter_show() {
				if ( window.matchMedia( '(max-width: 992px)' ).matches ) {
					const filter_list = document.querySelector( '.filter__list' ),
						overflow = document.querySelector( 'body' ),
						button = document.querySelector( '.button__show-filter' ),
						button_text = button.dataset.text,
						button_close_text = button.dataset.hide;

					filter_list.classList.toggle( 'active' );

					if ( filter_list.classList.contains( 'active' ) ) {
						button.innerHTML = button_close_text;
						overflow.style.overflow = 'hidden';
					} else {
						button.innerHTML = button_text;
						overflow.style.removeProperty( 'overflow' );
					}
				}
			}

			// click show filter
			document.querySelector( '.button__show-filter' ).addEventListener( 'click', () => {
				filter_show();
			} );
		}
	},
};

document.addEventListener( 'DOMContentLoaded', () => {
	smooth_scroll.init();
	menu_button.init();
	ieverly_property.filter();
	splide_settings.init();
} );
