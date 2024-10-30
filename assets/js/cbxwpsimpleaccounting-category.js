function cbx_goToByScroll(id) {
    // Remove "link" from the ID
    id = id.replace("link", "");
    // Scroll
    jQuery('html,body').animate({
        scrollTop: jQuery("#" + id).offset().top},
    'slow');
}



(function ($) {
    'use strict';

    var serializeObject = function ($form, wp_action_name) {
        var o = {};
        o['action'] = wp_action_name;
        var a = $form.serializeArray();
        $.each(a, function () {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };


    $(document).ready(function ($) {

    	//console.log('hi there cat manager');

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

        //add color picker
        var colorpicker_options = {
             //hide: false
        };

        $('.catcolor-picker').wpColorPicker(colorpicker_options);

		var $formvalidator = $('#cbacnt-cat-form').validate({
			errorPlacement: function (error, element) {
				error.appendTo(element.parents('.error_container'));
			},
			errorElement  : 'p',
			errorClass: 'error cbxwpsimpleaccounting_fielderror'
            /*rules         : {
             field_id        : {
             required: true,
             }
             },
             messages      : {
             field_id        : {
             required: message_here
             }

             }*/
		});

		$('#cbacnt-cat-form').submit(function (e) {
			var $form = $(this);

			if ($formvalidator.valid()) {
				$form.find('#catsubmit').prop("disabled", true);
			}
		});


        /*//create new category
        $('#cbacnt-cat-form').submit(function (evnt) {
            evnt.preventDefault();
            var $form = $(this);

            $('#cbxaccountingloading').show();
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajaxurl,
                data: serializeObject($form, 'add_new_expinc_cat'),
                beforeSend: function() {

                },
                success: function (response) {

                    //clear all error and update field
                    $form.find('.cbacnt-cat').removeClass('cbacnt-error');
                    //$form.find('#cbacnt-edit-cat-cancel').attr('disabled', 'disabled');

                    if (response.error) {
                        $('#cbxaccountingloading').hide();
                        $form.find('.cbacnt-msg-text').text(response.msg);
                        $form.find('.cbacnt-msg-box').addClass('error').removeClass('updated hidden').show();
                        $.each(response.field, function (index, value) {
                            $form.find('label[for="' + value + '"], #' + value).addClass('cbacnt-error');
                        });
                    } else {
                        $('#cbxaccountingloading').hide();

                        //remove any error class from form
                        $form.find('.cbacnt-error').removeClass('cbacnt-error');

                        $form.find('.cbacnt-msg-text').html(response.msg);
                        $form.find('.cbacnt-msg-box').addClass('updated').removeClass('error hidden').show();

                        //reset form is new item inserted
                        if (response.form_value.status == 'new') {
                            $form[0].reset();
                        }
                    }
                }
            });//end ajax calling for category
        });//end category form submission*/


        //if click on 'Add New' button
       /* $('#cbacnt-cat-form').on('click', '.cbacnt-new-cat', function (event) {
            
            event.preventDefault();
            var $form = $(this).parents('#cbacnt-cat-form');

            //$form.find('#cbacnt-edit-cat-cancel').attr('disabled', 'disabled');
            $form.find('#cbacnt-cat-id').val('0');
            $form.find('#cbacnt-new-cat').val($form.find('#cbacnt-new-cat').data('add-value'));
            $form.find('input[name=cbacnt-cat-type][value=' + 1 + ']').prop('checked', true);
            $('input[name=cbacnt-exinc-type][value=' + 1 + ']').prop('checked', true);
            $form[0].reset();
            $form.find('.cbacnt-msg-box').fadeOut();
        });*/

        //if click on edit category from category listing
        /*$('#cbxaccounting_catmanager').on('click', '.cbacnt-edit-cat', function (event) {
            event.preventDefault();

            var $form = $('#cbacnt-cat-form');

            var data = {};
            data['action'] = 'load_expinc_cat';
            data['catid'] = parseInt($(this).data('catid'));
            data['nonce'] = cbxwpsimpleaccounting.nonce

            $('#cbxaccountingloading').show();
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajaxurl,
                data: data,
                success: function (response) {
                    $('#cbxaccountingloading').hide();
                    if (response.error) {
                        $form.find('.cbacnt-msg-text').text(response.msg);
                        $form.find('.cbacnt-msg-box').addClass('error').removeClass('updated hidden').show();
                        cbx_goToByScroll('cbxaccounting_catmanager');
                    } else {
                        $('#cbxaccountingloading').hide();
                        $form.find('.cbacnt-msg-text').html(response.msg);
                        $form.find('#cbacnt-cat-id').val(response.form_value.id);
                        $form.find('#cbacnt-cat-title').val(response.form_value.title);
                        $form.find("input[name=cbacnt-cat-type][value=" + response.form_value.type + "]").prop('checked', true);
                        $form.find('#cbacnt-cat-color').iris('color', response.form_value.color);//showing saved color
                        $form.find('#cbacnt-cat-note').val(response.form_value.note);
                        $form.find('#cbacnt-new-cat').val($form.find('#cbacnt-new-cat').data('update-value'));
                        //$form.find('#cbacnt-edit-cat-cancel').removeAttr('disabled');
                        cbx_goToByScroll('cbxaccounting_catmanager');
                    }
                }
            });//end ajax calling for category
        });*/

    }); //end DOM ready

})(jQuery);
