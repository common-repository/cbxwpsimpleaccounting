(function ($) {
	'use strict';

	$(document).ready(function () {

		// Initialize the jQuery File Upload widget:
		$('#fileupload').fileupload({
			// Uncomment the following to send cross-domain cookies:
			//xhrFields: {withCredentials: true},
			//acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
			acceptFileTypes: new RegExp(cbxwpsimpleaccounting_attachments.accept_file_types,'i'),
			maxFileSize:cbxwpsimpleaccounting_attachments.maxFileSize,
			url: cbxwpsimpleaccounting_attachments.ajaxurl,
			messages: cbxwpsimpleaccounting_attachments.messages,
			formData: {
				action  : "cbxwpsimpleaccounting_add_attachments",
				security: cbxwpsimpleaccounting_attachments.nonce,
				log_id: cbxwpsimpleaccounting_attachments.log_id
			},
			autoUpload: true
		});

		// Enable iframe cross-domain access via redirect option:
		/*$('#fileupload').fileupload(
			'option',
			'redirect',
			window.location.href.replace(
				/\/[^\/]*$/,
				'/cors/result.html?%s'
			)
		);*/


		// Load existing files:
		$('#fileupload').addClass('fileupload-processing');
		$.ajax({
			//type: 'post',
			// Uncomment the following to send cross-domain cookies:
			//xhrFields: {withCredentials: true},
			url: cbxwpsimpleaccounting_attachments.ajaxurl,
			data: 'action=cbxwpsimpleaccounting_list_attachments&log_id='+cbxwpsimpleaccounting_attachments.log_id+'&security='+cbxwpsimpleaccounting_attachments.nonce,
			dataType: 'json',
			context : $('#fileupload')[0]
		}).always(function () {
			$(this).removeClass('fileupload-processing');
		}).done(function (result) {

			/*$.each( result.files, function( key, value ) {

				value.url = value.url+'&action=cbxwpsimpleaccounting_download_attachments&log_id='+cbxwpsimpleaccounting_attachments.log_id+'&security='+cbxwpsimpleaccounting_attachments.nonce;
				value.deleteUrl = value.deleteUrl+'&action=cbxwpsimpleaccounting_delete_attachments&log_id='+cbxwpsimpleaccounting_attachments.log_id+'&security='+cbxwpsimpleaccounting_attachments.nonce;

				result.files[key] = value;
			});*/

			$(this).fileupload('option', 'done')
				.call(this, $.Event('done'), {result: result});
		});

	}); //end DOM ready

})( jQuery );