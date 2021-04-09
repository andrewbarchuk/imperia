import GLightbox from 'glightbox';
import Splide from '@splidejs/splide';

const splide_settings = {
	/**
	 * Splide all settings
	 */

	init() {
		new Splide( '.splide' ).mount();
	},
};

const smooth_scroll = {
	/**
	 * Smooth scroll to anchor
	 */
	init() {
		// add anchors
		document.querySelectorAll( 'a[href^="#"]' ).forEach( ( trigger ) => {
			trigger.onclick = function( e ) {
				e.preventDefault();
				const hash = this.getAttribute( 'href' );
				const target = document.querySelector( hash );
				const headerOffset = 0;
				const elementPosition = target.offsetTop;
				const offsetPosition = elementPosition + headerOffset;

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
		// show loading section
		function property__loading() {
			const property__loading = document.querySelector( '.property__loading' );
			property__loading.classList.toggle( 'active' );
		}

		// property ajax
		function property__response() {
			const form = document.querySelector( '#property__filter' ),
				data = new FormData( form ),
				url_list = new URLSearchParams( data ).toString(),
				url_list_filter = '?' + url_list.replace( /&action=property__filter\S*/gi, '' );

			fetch( ajaxurl, {
				method: 'POST',
				body: data,
			} )
				.then( ( response ) => response.json() ) // parse response as JSON (can be res.text() for plain response)
				.then( ( response ) => {
					current_page = 1;

					posts = response.posts;
					max_page = response.max_page;

					document.querySelector( '#property__found-posts' ).innerHTML = response.found_posts;

					document.querySelector( '#property__items' ).innerHTML = response.content;
					history.pushState( null, null, url_list_filter );
					property__loading();

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
		button__search.addEventListener( 'click', ( event ) => {
			property__loading();
			property__response();
			button__search.classList.remove( 'light' );
		} );

		// change sort
		document.querySelector( '.property__sort-items' ).addEventListener( 'change', ( event ) => {
			property__loading();
			property__response();
			button__search.classList.remove( 'light' );
		} );

		// add button shadow
		document.querySelector( '.filter__list' ).addEventListener( 'change', ( event ) => {
			button__search.classList.add( 'light' );
		} );

		// price replace
		document.querySelectorAll( '.price-replace' ).forEach( ( elem, i ) => {
			const price = elem.textContent;
			elem.textContent = price.replace( /(\d)(?=(\d\d\d)+(?!\d))/g, '$1,' );
		} );

		// reset
		document.querySelector( '.button__reset' ).addEventListener( 'click', ( event ) => {
			document.querySelector( '#property__filter' ).reset();
			property__loading();
			property__response();
			button__search.classList.remove( 'light' );
		} );

		/**
		 * Load more
		 */
		const loadmore__button = document.querySelector( '#property__loadmore' ),
			loadmore__text = loadmore__button.innerHTML,
			loadmore__loading = loadmore__button.dataset.loading;

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
						// add current page
						current_page++;
						// append items
						document.querySelector( '#property__items' ).innerHTML += response;
						// reset loadmore button text
						loadmore__button.innerHTML = loadmore__text;
						loadmore__button.classList.remove( 'active' );
						property__loading();
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
		}

		// click loadmore
		loadmore__button.addEventListener( 'click', ( event ) => {
			loadmore__button.innerHTML = loadmore__loading;
			loadmore__button.classList.add( 'active' );
			property__loading();
			property__loadmore();
		} );
	},
};

document.addEventListener( 'DOMContentLoaded', () => {
	smooth_scroll.init();
	glight.init();
	ieverly_property.filter();
	splide_settings.init();
} );
