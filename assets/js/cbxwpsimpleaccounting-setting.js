(function ($) {
	'use strict';

	$(document).ready(function ($) {

		var $validate_messages = cbxwpsimpleaccounting.validation_messages.jquery_validate_messages;

		$.extend($.validator.messages, {
			required   : $validate_messages.required,
			remote     : $validate_messages.remote,
			email      : $validate_messages.email,
			url        : $validate_messages.url,
			date       : $validate_messages.date,
			dateISO    : $validate_messages.dateISO,
			number     : $validate_messages.number,
			digits     : $validate_messages.digits,
			creditcard : $validate_messages.creditcard,
			equalTo    : $validate_messages.equalTo,
			extension  : $validate_messages.extension,
			maxlength  : $.validator.format($validate_messages.maxlength),
			minlength  : $.validator.format($validate_messages.minlength),
			rangelength: $.validator.format($validate_messages.rangelength),
			range      : $.validator.format($validate_messages.range),
			max        : $.validator.format($validate_messages.max),
			min        : $.validator.format($validate_messages.min),
		});

		//Initiate Color Picker
		var colorpicker_options = {
			//hide: false,
		};
		$('.wp-color-picker-field').wpColorPicker(colorpicker_options);

		// Switches option sections
		$('.cbxwpsimpleaccounting_group').hide();
		var activetab = '';
		if (typeof (localStorage) != 'undefined') {
			//get
			activetab = localStorage.getItem("cbxactactivetab");
		}


		//if url has section id as hash then set it as active or override the current local storage value
		if (window.location.hash) {
			activetab = window.location.hash;
			if (typeof(localStorage) != 'undefined') {
				localStorage.setItem("cbxactactivetab", activetab);
			}
		}


		//cbxwpsimpleaccounting_frontend

		if (activetab != '' && $(activetab).length) {
			$(activetab).fadeIn();

			var $scroll_to = $(activetab).offset().top - 150;

			$('html, body').animate({
				scrollTop: $scroll_to
			}, 1000);


		} else {
			$('.cbxwpsimpleaccounting_group:first').fadeIn();
		}
		$('.cbxwpsimpleaccounting_group .collapsed').each(function () {
			$(this).find('input:checked').parent().parent().parent().nextAll().each(
				function () {
					if ($(this).hasClass('last')) {
						$(this).removeClass('hidden');
						return false;
					}
					$(this).filter('.hidden').removeClass('hidden');
				});
		});

		if (activetab != '' && $(activetab + '-tab').length) {
			$(activetab + '-tab').addClass('nav-tab-active');
		}
		else {
			$('.nav-tab-wrapper a:first').addClass('nav-tab-active');
		}

		$('.nav-tab-wrapper a').on('click', function (evt) {
			$('.nav-tab-wrapper a').removeClass('nav-tab-active');
			$(this).addClass('nav-tab-active').blur();
			var clicked_group = $(this).attr('href');
			if (typeof (localStorage) != 'undefined') {
				//set
				localStorage.setItem("cbxactactivetab", $(this).attr('href'));
			}
			$('.cbxwpsimpleaccounting_group').hide();
			$(clicked_group).fadeIn();
			evt.preventDefault();
		});

		$('.wpsa-browse').on('click', function (event) {
			event.preventDefault();

			var self = $(this);

			// Create the media frame.
			var file_frame = wp.media.frames.file_frame = wp.media({
				title   : self.data('uploader_title'),
				button  : {
					text: self.data('uploader_button_text')
				},
				multiple: false
			});

			file_frame.on('select', function () {
				var attachment = file_frame.state().get('selection').first().toJSON();

				self.prev('.wpsa-url').val(attachment.url);
			});

			// Finally, open the modal
			file_frame.open();
		});

		//add chooser
		//$(".chosen-select").chosen({width: 'auto'});

		$(".selecttwo-select").select2({
			placeholder: cbxwpsimpleaccounting.please_select,
			allowClear: false
		});


		//make the subheading single row
		$('.setting_subheading').each(function (index, element) {
			var $element = $(element);
			var $element_parent = $element.parent('td');
			$element_parent.attr('colspan', 2);
			$element_parent.prev('th').remove();
		});

		//make the subheading single row
		$('.setting_heading').each(function (index, element) {
			var $element = $(element);
			var $element_parent = $element.parent('td');
			$element_parent.attr('colspan', 2);
			$element_parent.prev('th').remove();
		});

		$('.cbxwpsimpleaccounting_group').each(function (index, element) {
			var $element = $(element);
			var $form_table = $element.find('.form-table');
			$form_table.prev('h2').remove();
		});

		//extra functionality
		$('.default_category_create').on('click', function (e) {
			e.preventDefault();

			var $this = $(this);
			var $type = parseInt($this.data('type'));
			var $busy = parseInt($this.data('busy'));

			var data = {};
			data['action'] 	= 'default_category_create';
			data['type'] 	= $type;
			data['security']  	= cbxwpsimpleaccounting.nonce;

			if($busy == 0){
				$this.data('busy', 1);

				$.ajax({
					type: 'post',
					dataType: 'json',
					url: ajaxurl,
					data: data,
					success: function(response) {

						if (response.success == 1) {
							$this.data('busy', 0);
							alert(cbxwpsimpleaccounting.category_create_success);
							location.reload();

						} else {
							alert(cbxwpsimpleaccounting.category_create_failed);
							location.reload();
						}
					}
				});//end ajax calling for category
			}

		});

		$('#cbxwpsimpleaccounting_info_trig').on('click', function (e) {
			e.preventDefault();

			$('#cbxwpsimpleaccounting_resetinfo').toggle();

		});

		//sort photos
		var adjustment_photo;
		$(".multicheck_fields_sortable").sortable({
			vertical         : true,
			handle           : '.multicheck_field_handle',
			containerSelector: '.multicheck_fields',
			itemSelector     : '.multicheck_field',
			//placeholder      : '<p class="multicheck_field_placeholder"/>',
			placeholder      : 'multicheck_field_placeholder',
		});


		$('.cbxwpsimpleaccounting_group').on('click', '.checkbox', function() {
			var mainParent = $(this).closest('.checkbox-toggle-btn');
			if($(mainParent).find('input.checkbox').is(':checked')) {
				$(mainParent).addClass('active');
			} else {
				$(mainParent).removeClass('active');
			}

		});


	});

})(jQuery);