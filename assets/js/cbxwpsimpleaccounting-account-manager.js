function cbx_goToByScroll(id) {
    // Remove "link" from the ID
    id = id.replace("link", "");
    // Scroll
    jQuery('html,body').animate({
        scrollTop: jQuery("#" + id).offset().top},
    'slow');
}

(function($) {
    'use strict';
    var serializeObject = function($form, wp_action_name) {
        var o = {};
        o['action'] = wp_action_name;
        var a = $form.serializeArray();
        $.each(a, function() {
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

    $(document).ready(function($) {

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
/*
        $(".chosen-select").chosen({

        });*/

	    $(".selecttwo-select").select2({
		    placeholder: cbxwpsimpleaccounting.please_select,
		    allowClear: false
	    });


        //listing existing accounts

        var $all_acc_list = $.parseJSON(cbxwpsimpleaccounting.acc_results_list);

        var $accselection =  'all';

        //show hide extra fields for bank or cash based on account type
		$('.cbacnt-acc-type').on('change', function (e) {
            var $this = $(this);

            if ( $this.val() == 'bank') {
                $(".cbxacc_bankdetails").show();
            } else {
                $(".cbxacc_bankdetails").hide();
            }
        });

		//change on account type
		$('.cbacnt-acc-type-bottom').on('change', function() {

			var $accselection = $(this).val();

			if ($accselection == 'cash') {
				$('.cbacnt-acc-type-bank').addClass('hidden');
				$('.cbacnt-acc-type-cash').removeClass('hidden');
			}
			else if($accselection == 'bank') {
				$('.cbacnt-acc-type-cash').addClass('hidden');
				$('.cbacnt-acc-type-bank').removeClass('hidden');
			}
			else {
				$('.cbacnt-acc-type-cash').removeClass('hidden');
				$('.cbacnt-acc-type-bank').removeClass('hidden');
			}

		});


		var $formvalidator = $('#cbacnt-account-form').validate({
			errorPlacement: function (error, element) {
				error.appendTo(element.parents('.error_container'));
			},
			errorElement  : 'p',
			errorClass: 'error cbxwpsimpleaccounting_fielderror'
		});

		$('#cbacnt-account-form').submit(function (e) {
			var $form = $(this);

			if ($formvalidator.valid()) {
				$form.find('#cbacnt-new-acc').prop("disabled", true);
			}
		});

        /*
        //create new account
        $('#cbacnt-account-form1').submit(function(evnt) {
            evnt.preventDefault();
            var $form = $(this);
            $('#cbxaccountingloading').show();
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajaxurl,
                data: serializeObject($form, 'add_new_manager_acc'),
                success: function(response) {
                    //clear all error and update field
                    $('#cbxaccountingloading').hide();
                    $form.find('.cbacnt-acc').removeClass('cbacnt-error');
                    $form.find('#cbacnt-edit-manage-acc-cancel').attr('disabled', 'disabled');

                    if (response.error) {
                        $form.find('.cbacnt-msg-text').text(response.msg);
                        $form.find('.cbacnt-msg-box').addClass('error').removeClass('updated hidden').show();
                        $.each(response.field, function(index, value) {
                            $form.find('label[for="' + value + '"], #' + value).addClass('cbacnt-error');
                        });
                    } else {


                        $all_acc_list[response.form_value.id] = response.form_value;

                        $form.find('.cbacnt-msg-text').html(response.msg);
                        $form.find('.cbacnt-msg-box').addClass('updated').removeClass('error hidden').show();

                        //reset form is new item inserted
                        if (response.form_value.status == 'new') {
                            $form[0].reset();
                        }

                        var $accselection = response.form_value.type;

                        $('#cbacnt-expinc-acc-list').html('');

                        $.each( $all_acc_list, function( index, acc ){
                            if($.isEmptyObject(acc)) return;

                            if(acc.type == 'cash'){
                                 $('#cbacnt-expinc-acc-list').append('<li class="cbacnt-acc-exinc cbacnt-acc-inc cbacnt-acc-type-cash ' + (($accselection == 'bank') ? 'hidden' : '') + '">' + acc.title.replace(/\\/g, '') + ' <a data-accid="' + acc.id + '" class="cbacnt-edit-cbxacc" href="#">' + cbxwpsimpleaccounting.edit + '</a></li>');
                            }
                            else{
                                 $('#cbacnt-expinc-acc-list').append('<li class="cbacnt-acc-exinc cbacnt-acc-inc cbacnt-acc-type-bank ' + (($accselection == 'cash') ? 'hidden' : '') + '">' + acc.title.replace(/\\/g, '') + ' <a data-accid="' + acc.id + '" class="cbacnt-edit-cbxacc" href="#">' + cbxwpsimpleaccounting.edit + '</a></li>');
                            }
                        });

                    }
                }
            });//end ajax calling for category
        });//end category form submission

        //if click on edit account
        $('#cbacnt-account-form1').on('click', '.cbacnt-new-acc, #cbacnt-edit-acc-cancel', function(event) {
            event.preventDefault();
            var $form = $(this).parents('#cbacnt-account-form');
            $form.find('#cbacnt-edit-acc-cancel').attr('disabled', 'disabled');
            $form.find('#cbacnt-acc-id').val('0');
            $form.find('#cbacnt-new-acc').val($form.find('#cbacnt-new-acc').data('add-value'));
            $("input[name=cbacnt-acc-type-bottom][value=cash]").prop('checked', true);
            $('.cbxacc_bankdetails').hide();

            $form[0].reset();
            $form.find('.cbacnt-msg-box').fadeOut();
        });

        //if click on edit account from account listing
        $('#cbxaccounting_accmanager1').on('click', '.cbacnt-edit-cbxacc', function(event) {
            event.preventDefault();
            var $form = $('#cbacnt-account-form');

            var data = {};
            data['action'] = 'load_account';
            data['accid'] = parseInt($(this).data('accid'));
            data['nonce']  = cbxwpsimpleaccounting.nonce
            $('#cbxaccountingloading').show();

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajaxurl,
                data: data,
                success: function(response) {
                    if (response.error) {
                        $('#cbxaccountingloading').hide();
                        $form.find('.cbacnt-msg-text').text(response.msg);
                        $form.find('.cbacnt-msg-box').addClass('error').removeClass('updated hidden').show();
                        cbx_goToByScroll('cbxaccounting_catmanager');
                    } else {
                        $('#cbxaccountingloading').hide();
                        $form.find('.cbacnt-msg-text').html(response.msg);
                        $form.find('#cbacnt-acc-id').val(response.form_value.id);
                        $form.find('#cbacnt-acc-title').val(response.form_value.title);
                        if (response.form_value.type == 'cash') {
                            $('.cbxacc_bankdetails').hide();
                            //$('#cbacnt-acc-type').val(response.form_value.type).trigger('chosen:updated');
                            $form.find("input[name=cbacnt-acc-type][value=" + response.form_value.type + "]").prop('checked', true);
                        } else {
                            $('.cbxacc_bankdetails').show();
                            //$('#cbacnt-acc-type').val(response.form_value.type).trigger('chosen:updated');
                            $form.find("input[name=cbacnt-acc-type][value=" + response.form_value.type + "]").prop('checked', true);
                            $form.find('#cbacnt-acc-acc-no').val(response.form_value.acc_no);
                            $form.find('#cbacnt-acc-acc-name').val(response.form_value.acc_name);
                            $form.find('#cbacnt-acc-bank-name').val(response.form_value.bank_name);
                            $form.find('#cbacnt-acc-branch-name').val(response.form_value.branch_name);
                        }
                        $form.find('#cbacnt-new-acc').val($form.find('#cbacnt-new-acc').data('update-value'));
                        $form.find('#cbacnt-edit-acc-cancel').removeAttr('disabled');
                        cbx_goToByScroll('cbxaccounting_accmanager');
                    }
                }
            });//end ajax calling for category
        });
        */



    }); //end DOM ready

})(jQuery);
