function in_array(el, arr) {
	for (var i in arr) {
		if (arr[i] == el) return true;
	}
	return false;
}

jQuery(function ($) {
	// on upload button click
	$('body').on('click', '.up-upl', function (e) {
		e.preventDefault();

		var button = $(this),
			custom_uploader = wp
				.media({
					title: 'Insert image',
					library: {
						// uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
						type: 'image',
					},
					button: {
						text: 'Use this image', // button label text
					},
					multiple: false,
				})
				.on('select', function () {
					// it also has "open" and "close" events
					var attachment = custom_uploader
						.state()
						.get('selection')
						.first()
						.toJSON();
					button
						.html('<img src="' + attachment.url + '">')
						.next()
						.val(attachment.id)
						.next()
						.show();
				})
				.open();
	});

	// on remove button click
	$('body').on('click', '.up-rmv', function (e) {
		e.preventDefault();

		var button = $(this);
		button.prev().val(''); // emptying the hidden field
		button.prev().prev().html('Upload image');
		button.hide();
	});

	/*
	 * attach file
	 */
	$('body').on('click', '.file_button', function (e) {
		e.preventDefault();

		const button = $(this),
			custom_uploader = wp
				.media({
					title: 'Select file',
					library: {
						// uncomment the next line if you want to attach image to the current post
						// uploadedTo : wp.media.view.settings.post.id,
						type: [
							'application/pdf',
							'image',
							'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
							'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
							'application/vnd.openxmlformats-officedocument.presentationml.presentation',
						],
					},
					button: {
						text: 'Use this file', // button label text
					},
					multiple: false, // for multiple image selection set to true
				})
				.on('select', function () {
					// it also has "open" and "close" events
					const attachment = custom_uploader
						.state()
						.get('selection')
						.first()
						.toJSON();
					$('.in_file').val(attachment.url);
				})
				.open();
	});

	/*
	 * Sortable images
	 */
	$('ul.gallery_mtb').sortable({
		items: 'li',
		cursor: '-webkit-grabbing' /* mouse cursor */,
		scrollSensitivity: 40,
		/*
        You can set your custom CSS styles while this element is dragging
        start:function(event,ui){
            ui.item.css({'background-color':'grey'});
        },
        */
		stop: function (event, ui) {
			ui.item.removeAttr('style');

			var sort = new Array() /* array of image IDs */,
				gallery = $(this); /* ul.gallery_mtb */

			/* each time after dragging we resort our array */
			gallery.find('li').each(function (index) {
				sort.push($(this).attr('data-id'));
			});
			/* add the array value to the hidden input field */
			gallery.parent().next().val(sort.join());
			/* console.log(sort); */
		},
	});

	/*
	 * Multiple images uploader
	 */
	$('.upload_gallery_button').click(function (e) {
		/* on button click*/ e.preventDefault();

		var button = $(this),
			hiddenfield = button.prev(),
			hiddenfieldvalue = hiddenfield
				.val()
				.split(',') /* the array of added image IDs */,
			custom_uploader = wp
				.media({
					title: 'Insert images' /* popup title */,
					library: { type: 'image' },
					button: { text: 'Use these images' } /* "Insert" button text */,
					multiple: true,
				})
				.on('select', function () {
					var attachments = custom_uploader
							.state()
							.get('selection')
							.map(function (a) {
								a.toJSON();
								return a;
							}),
						thesamepicture = false,
						i;

					/* loop through all the images */
					for (i = 0; i < attachments.length; ++i) {
						/* if you don't want the same images to be added multiple time */
						if (!in_array(attachments[i].id, hiddenfieldvalue)) {
							/* add HTML element with an image */
							$('ul.gallery_mtb').append(
								'<li data-id="' +
									attachments[i].id +
									'"><img style="max-width: 600px" src="' +
									attachments[i].attributes.url +
									')"><a href="#" class="gallery_remove">×</a></li>'
							);
							/* add an image ID to the array of all images */
							hiddenfieldvalue.push(attachments[i].id);
						} else {
							thesamepicture = true;
						}
					}
					/* refresh sortable */
					$('ul.gallery_mtb').sortable('refresh');
					/* add the IDs to the hidden field value */
					hiddenfield.val(hiddenfieldvalue.join());
					/* you can print a message for users if you want to let you know about the same images */
					if (thesamepicture == true) alert('The same images are not allowed.');
				})
				.open();
	});

	/*
	 * Remove certain images
	 */
	$('body').on('click', '.gallery_remove', function () {
		var id = $(this).parent().attr('data-id'),
			gallery = $(this).parent().parent(),
			hiddenfield = gallery.parent().next(),
			hiddenfieldvalue = hiddenfield.val().split(','),
			i = hiddenfieldvalue.indexOf(id);

		$(this).parent().remove();

		/* remove certain array element */
		if (i != -1) {
			hiddenfieldvalue.splice(i, 1);
		}

		/* add the IDs to the hidden field value */
		hiddenfield.val(hiddenfieldvalue.join());

		/* refresh sortable */
		gallery.sortable('refresh');

		return false;
	});

	/*
	 * Selected item
	 */
	$('body').on('mousedown', 'ul.gallery_mtb li', function () {
		var el = $(this);
		el.parent().find('li').removeClass('active');
		el.addClass('active');
	});
});
