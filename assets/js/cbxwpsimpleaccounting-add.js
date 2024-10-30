function cbx_goToByScroll(id) {
    // Remove "link" from the ID
    id = id.replace("link", "");
    // Scroll
    jQuery('html,body').animate({
            scrollTop: jQuery("#" + id).offset().top
        },
        'slow');
}

/**
 * https://raw.githubusercontent.com/kvz/phpjs/master/functions/strings/get_html_translation_table.js
 *
 * @param table
 * @param quote_style
 * @returns {{}}
 */
function cbxaccounting_get_html_translation_table(table, quote_style) {

    var entities = {},
        hash_map = {},
        decimal;
    var constMappingTable = {},
        constMappingQuoteStyle = {};
    var useTable = {},
        useQuoteStyle = {};

    // Translate arguments
    constMappingTable[0] = 'HTML_SPECIALCHARS';
    constMappingTable[1] = 'HTML_ENTITIES';
    constMappingQuoteStyle[0] = 'ENT_NOQUOTES';
    constMappingQuoteStyle[2] = 'ENT_COMPAT';
    constMappingQuoteStyle[3] = 'ENT_QUOTES';

    useTable = !isNaN(table) ? constMappingTable[table] : table ? table.toUpperCase() : 'HTML_SPECIALCHARS';
    useQuoteStyle = !isNaN(quote_style) ? constMappingQuoteStyle[quote_style] : quote_style ? quote_style.toUpperCase() :
                                                                                'ENT_COMPAT';

    if (useTable !== 'HTML_SPECIALCHARS' && useTable !== 'HTML_ENTITIES') {
        throw new Error('Table: ' + useTable + ' not supported');
        // return false;
    }

    entities['38'] = '&amp;';
    if (useTable === 'HTML_ENTITIES') {
        entities['160'] = '&nbsp;';
        entities['161'] = '&iexcl;';
        entities['162'] = '&cent;';
        entities['163'] = '&pound;';
        entities['164'] = '&curren;';
        entities['165'] = '&yen;';
        entities['166'] = '&brvbar;';
        entities['167'] = '&sect;';
        entities['168'] = '&uml;';
        entities['169'] = '&copy;';
        entities['170'] = '&ordf;';
        entities['171'] = '&laquo;';
        entities['172'] = '&not;';
        entities['173'] = '&shy;';
        entities['174'] = '&reg;';
        entities['175'] = '&macr;';
        entities['176'] = '&deg;';
        entities['177'] = '&plusmn;';
        entities['178'] = '&sup2;';
        entities['179'] = '&sup3;';
        entities['180'] = '&acute;';
        entities['181'] = '&micro;';
        entities['182'] = '&para;';
        entities['183'] = '&middot;';
        entities['184'] = '&cedil;';
        entities['185'] = '&sup1;';
        entities['186'] = '&ordm;';
        entities['187'] = '&raquo;';
        entities['188'] = '&frac14;';
        entities['189'] = '&frac12;';
        entities['190'] = '&frac34;';
        entities['191'] = '&iquest;';
        entities['192'] = '&Agrave;';
        entities['193'] = '&Aacute;';
        entities['194'] = '&Acirc;';
        entities['195'] = '&Atilde;';
        entities['196'] = '&Auml;';
        entities['197'] = '&Aring;';
        entities['198'] = '&AElig;';
        entities['199'] = '&Ccedil;';
        entities['200'] = '&Egrave;';
        entities['201'] = '&Eacute;';
        entities['202'] = '&Ecirc;';
        entities['203'] = '&Euml;';
        entities['204'] = '&Igrave;';
        entities['205'] = '&Iacute;';
        entities['206'] = '&Icirc;';
        entities['207'] = '&Iuml;';
        entities['208'] = '&ETH;';
        entities['209'] = '&Ntilde;';
        entities['210'] = '&Ograve;';
        entities['211'] = '&Oacute;';
        entities['212'] = '&Ocirc;';
        entities['213'] = '&Otilde;';
        entities['214'] = '&Ouml;';
        entities['215'] = '&times;';
        entities['216'] = '&Oslash;';
        entities['217'] = '&Ugrave;';
        entities['218'] = '&Uacute;';
        entities['219'] = '&Ucirc;';
        entities['220'] = '&Uuml;';
        entities['221'] = '&Yacute;';
        entities['222'] = '&THORN;';
        entities['223'] = '&szlig;';
        entities['224'] = '&agrave;';
        entities['225'] = '&aacute;';
        entities['226'] = '&acirc;';
        entities['227'] = '&atilde;';
        entities['228'] = '&auml;';
        entities['229'] = '&aring;';
        entities['230'] = '&aelig;';
        entities['231'] = '&ccedil;';
        entities['232'] = '&egrave;';
        entities['233'] = '&eacute;';
        entities['234'] = '&ecirc;';
        entities['235'] = '&euml;';
        entities['236'] = '&igrave;';
        entities['237'] = '&iacute;';
        entities['238'] = '&icirc;';
        entities['239'] = '&iuml;';
        entities['240'] = '&eth;';
        entities['241'] = '&ntilde;';
        entities['242'] = '&ograve;';
        entities['243'] = '&oacute;';
        entities['244'] = '&ocirc;';
        entities['245'] = '&otilde;';
        entities['246'] = '&ouml;';
        entities['247'] = '&divide;';
        entities['248'] = '&oslash;';
        entities['249'] = '&ugrave;';
        entities['250'] = '&uacute;';
        entities['251'] = '&ucirc;';
        entities['252'] = '&uuml;';
        entities['253'] = '&yacute;';
        entities['254'] = '&thorn;';
        entities['255'] = '&yuml;';
    }

    if (useQuoteStyle !== 'ENT_NOQUOTES') {
        entities['34'] = '&quot;';
    }
    if (useQuoteStyle === 'ENT_QUOTES') {
        entities['39'] = '&#39;';
    }
    entities['60'] = '&lt;';
    entities['62'] = '&gt;';

    // ascii decimals to real symbols
    for (decimal in entities) {
        if (entities.hasOwnProperty(decimal)) {
            hash_map[String.fromCharCode(decimal)] = entities[decimal];
        }
    }

    return hash_map;
}

/**
 * Javascript compatible html_entity_decode function
 * https://raw.githubusercontent.com/kvz/phpjs/master/functions/strings/html_entity_decode.js
 *
 * @param string
 * @param quote_style
 * @returns {*}
 */
function cbxaccounting_html_entity_decode(string, quote_style) {

    var hash_map = {},
        symbol = '',
        tmp_str = '',
        entity = '';

    tmp_str = string.toString();

    if (false === (hash_map = cbxaccounting_get_html_translation_table('HTML_ENTITIES', quote_style))) {
        return false;
    }
    delete(hash_map['&']);
    hash_map['&'] = '&amp;';

    for (symbol in hash_map) {
        entity = hash_map[symbol];
        tmp_str = tmp_str.split(entity)
            .join(symbol);
    }
    tmp_str = tmp_str.split('&#039;')
        .join("'");

    return tmp_str;
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


    jQuery(document).ready(function ($) {

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

        //apply jquery chosen
       /* $(".chosen-select").chosen({
			width: 'auto'
        });*/

	    $(".selecttwo-select").select2({
		    placeholder: cbxwpsimpleaccounting.please_select,
		    allowClear: false
	    });

        //apply flatpickr javascript
        $("#cbacnt-exinc-add-date").flatpickr({
			disableMobile: true,
            maxDate: new Date(),
            enableTime: true,
            dateFormat: 'Y-m-d H:i:s'
        });


        $('.cbacnt-exinc-type').on('change', function () {

            $('#cbacnt-expinc-cat-list').find('.cbacnt-cat-exp, .cbacnt-cat-inc').toggleClass('hidden');
            $('#cbacnt-expinc-cat-list').find('input.cbacnt-cat-exinciteminput:checked').prop('checked', false);
            $('#cbacnt-expinc-cat-list').find('input.cbacnt-cat-exinciteminput:not(:checked)').prop('disabled', false);
        });

		$("input.cbacnt-cat-exinciteminput:checkbox").on('click', function (event) {
            var limit = 1;
            var n = $("input.cbacnt-cat-exinciteminput:checked").length;

            if (n == limit) {
                $('input.cbacnt-cat-exinciteminput:not(:checked)').prop('disabled', true);
            }
            else {
                $('input.cbacnt-cat-exinciteminput:not(:checked)').prop('disabled', false);
            }
        });

		var $formvalidator = $('#cbacnt-expinc-form').validate({
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

		$('#cbacnt-expinc-form').submit(function (e) {
			var $form = $(this);

			if ($formvalidator.valid()) {
				$form.find('#cbacnt-new-exinc').prop("disabled", true);
			}
		});

        /*
        var all_cat_list = $.parseJSON(cbxwpsimpleaccounting.cat_results_list);

        //load any income or expense for edit via ajax
        $('#cbacnt-expinc-form1').on('click', '.cbacnt-edit-exinc', function (event) {

            event.preventDefault();

            var $form = $('#cbacnt-expinc-form');

            var data = {};
            data['action'] = 'load_expinc';
            data['id'] = parseInt($(this).data('id'));
            data['nonce'] = cbxwpsimpleaccounting.nonce;

            $('#cbxaccountingloading').show();
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajaxurl,
                data: data,
                beforeSend: function () {

                },
                success: function (response) {
                    if (response.error) {
                        $('#cbxaccountingloading').hide();
                        $form.find('.cbacnt-msg-text').text(response.msg);
                        $form.find('.cbacnt-msg-box').addClass('error').removeClass('updated hidden').show();
                        cbx_goToByScroll('cbxaccounting_addexpinc');
                    } else {
                        $('#cbxaccountingloading').hide();
                        $form.find('.cbacnt-msg-text').html(response.msg);
                        $form.find('#cbacnt-exinc-id').val(response.form_value.id);
                        $form.find('#cbacnt-exinc-title').val(cbxaccounting_html_entity_decode(response.form_value.title));
                        $form.find('#cbacnt-exinc-amount').val(response.form_value.amount);
                        $form.find('#cbacnt-exinc-source-amount').val(response.form_value.source_amount);
                        $form.find('#cbacnt-exinc-currency').val(response.form_value.source_currency).trigger("chosen:updated");
                        $form.find('#cbacnt-exinc-type').val(response.form_value.type);
                        $form.find('#cbacnt-exinc-note').val(cbxaccounting_html_entity_decode(response.form_value.note));
                        $form.find('.cbacnt-cat-exinc').addClass('hidden');
                        $form.find('.cbacnt-cat-type-' + response.form_value.type).removeClass('hidden');
                        $form.find('#cbacnt-new-exinc').val($form.find('#cbacnt-new-exinc').data('update-value'));
                        $form.find('#cbacnt-new-exinc').prop('disabled', false);

                        $form.find('#cbacnt-exinc-invoice').val(response.form_value.invoice);
                        $form.find('#cbacnt-exinc-acc').val(response.form_value.account).trigger("chosen:updated");


                        //need to put js hook here
                        //
                        wp.cbxwpsajshooks.doAction('cbxwpsimpleaccounting_incexp_edit_data', $form, response);

                        $(this).parents('.cbacnt-msg-box').fadeOut();
                        cbx_goToByScroll('cbxaccounting_addexpinc');
                    }
                }
            });
        });


        //if click on add new item
        $('#cbacnt-expinc-form1').on('click', '.cbacnt-new-exinc', function (event) {


            var $form = $('#cbacnt-expinc-form');

            $('#cbxaccountingloading').show();
            $form.find('#cbacnt-exinc-id').val('0');
            $form.find('#cbacnt-exinc-title').val('');
            $form.find('#cbacnt-exinc-amount').val('');

            $form.find('#cbacnt-exinc-source-amount').val('');
            $form.find('#cbacnt-exinc-note').val('');

            $form.find('#cbacnt-exinc-currency').val('none').trigger("chosen:updated");
            $form.find('input[name=cbacnt-exinc-type][value=' + 1 + ']').prop('checked', true);
            $form.find('#cbacnt-exinc-invoice').val('');
            $form.find('#cbacnt-exinc-tax').val('');

            $form.find('#cbacnt-exinc-invoice').val('');
            $form.find('#cbacnt-exinc-acc').val('').trigger("chosen:updated");


            //reset cats
            $('#cbacnt-expinc-cat-list li').each(function (index, element) {
                var elem = $(element);
                if (elem.hasClass('cbacnt-cat-type-1'))
                    elem.removeClass('hidden');
                if (elem.hasClass('cbacnt-cat-type-2'))
                    elem.addClass('hidden');

                elem.find('input.cbacnt-cat-exinciteminput:checkbox').prop('checked', false);
                elem.find('input.cbacnt-cat-exinciteminput:checkbox').prop('disabled', false);

            });

            //js hook here
            wp.cbxwpsajshooks.doAction('cbxwpsimpleaccounting_incexp_new_reset', $form);

            $form.find('.sales-tax').removeClass('hidden');
            $form.find('#cbacnt-new-exinc').val($form.find('#cbacnt-new-exinc').data('add-value'));
            $form.find('#cbacnt-new-exinc').prop('disabled', false);


            $(this).parents('.cbacnt-msg-box').fadeOut();
            $('#cbxaccountingloading').hide();
        });

        //main add or edit (submit) function
		$('#cbacnt-expinc-form1').on('submit', function (e) {
            e.preventDefault();

			var $form = $(this);

			$('#cbxaccountingloading').show();
            $('#cbacnt-new-exinc').prop('disabled', true);

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajaxurl,
                data: serializeObject($form, 'add_new_expinc'),
                beforeSend: function () {

                },
                success: function (response) {
                    console.log(response);

                    if (response.error) {
                        $('#cbxaccountingloading').hide();
                        $form.find('.cbacnt-msg-text').text(response.msg);
                        $form.find('.cbacnt-msg-box').addClass('error').removeClass('updated hidden').show();
                        $.each(response.field, function (index, value) {
                            $form.find('label[for="' + value + '"]').addClass('cbacnt-error');
                            $form.find('#' + value).addClass('cbacnt-error').removeClass('cbacnt-updated');
                        });
                    } else {
                        $('#cbxaccountingloading').hide();

                        //remove any error class from form
                        $form.find('.cbacnt-error').removeClass('cbacnt-error');

                        $form.find('.cbacnt-msg-text').html(response.msg);
                        $form.find('.cbacnt-msg-box').addClass('updated').removeClass('error hidden').show();

                        $form.find('#cbacnt-exinc-id').val(response.form_value.id);
                        $form.find('#cbacnt-exinc-title').val(cbxaccounting_html_entity_decode(response.form_value.title));
                        $form.find('#cbacnt-exinc-amount').val(response.form_value.amount);
                        $form.find('#cbacnt-exinc-source-amount').val(response.form_value.source_amount);
                        $form.find('#cbacnt-exinc-currency').val(response.form_value.source_currency).trigger("chosen:updated");
                        $form.find('#cbacnt-exinc-type').val(response.form_value.type);
                        $form.find('#cbacnt-exinc-note').val(cbxaccounting_html_entity_decode(response.form_value.note));
                        $form.find('.cbacnt-cat-exinc').addClass('hidden');
                        $form.find('.cbacnt-cat-type-' + response.form_value.type).removeClass('hidden');
                        $form.find('#cbacnt-new-exinc').val($form.find('#cbacnt-new-exinc').data('update-value'));

                        $form.find('#cbacnt-exinc-acc').val(response.form_value.account).trigger("chosen:updated");
                        $form.find('#cbacnt-exinc-invoice').val(response.form_value.invoice);

                        wp.cbxwpsajshooks.doAction('cbxwpsimpleaccounting_incexp_post_data', $form, response);

                        $.each(response.form_value.cat_list, function (i, v) {
                            $form.find('#cbacnt-expinc-cat-' + v).prop('checked', true);
                            $form.find('#cbacnt-expinc-cat-' + v).prop('disabled', false);
                        });

                        $('input.cbacnt-cat-exinciteminput[type="checkbox"]:not(:checked)').prop('disabled', true);

                    }
                    $('#cbacnt-new-exinc').prop('disabled', false);
                },
                error: function (e) {
                    $('#cbacnt-new-exinc').prop('disabled', false);
                }
            });//end ajax calling for expense/income
        });//end expense/income form submission
        */

		var cbxaccounting_addexpinc_tab = '';

		//log edit with attachment related
		$('#cbxaccounting_addexpinc_nav').on('click', 'a', function (e) {
			e.preventDefault();

			var $this = $(this);
			var $this_id = $this.attr('href');
			var $nav_parent = $this.closest('#cbxaccounting_addexpinc_nav');
			var $parent = $nav_parent.closest('#cbxaccounting_addexpinc_wrap');
			var $tab = $parent.find('#cbxaccounting_addexpinc_tabs');

			$nav_parent.find('li').removeClass('active');
			$tab.find('.cbxaccounting_addexpinc_tab').removeClass('active');



			$this.closest('li').addClass('active');
			$tab.find($this_id).addClass('active');

			if (typeof (localStorage) != 'undefined') {
				//set
				localStorage.setItem("cbxaccounting_addexpinc_tab", $this_id);
			}

		});


		if (typeof (localStorage) != 'undefined') {
			//get
			cbxaccounting_addexpinc_tab = localStorage.getItem("cbxaccounting_addexpinc_tab");
		}

		if (window.location.hash) {
			cbxaccounting_addexpinc_tab = window.location.hash;
			if (typeof(localStorage) != 'undefined') {
				localStorage.setItem("cbxaccounting_addexpinc_tab", cbxaccounting_addexpinc_tab);
			}
		}

		if (cbxaccounting_addexpinc_tab != '' && $(cbxaccounting_addexpinc_tab).length) {
			$('#cbxaccounting_addexpinc_nav a[href^="'+cbxaccounting_addexpinc_tab+'"]').trigger('click');
		}

    }); //end DOM ready

})(jQuery);
