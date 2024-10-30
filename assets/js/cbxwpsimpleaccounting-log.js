jQuery(document).ready(function ($) {


    $(".cbxlogdaterange").flatpickr({
        disableMobile: true,
        dateFormat: 'Y-m-d'
    });

    $("#cbxlogexpinc_type").on('change', function () {

        var optionValue = parseInt($(this).val());
        if (optionValue == 0)
            $('#cbxlogexpinc_category').val(0).prop('disabled', true);
        else if (optionValue == 1) {
            $('#cbxlogexpinc_category').prop('disabled', false);
            $('#cbxlogexpinc_category').find('option[data-type="1"]').removeClass('cbxlogexpinccathidden').prop('disabled', false);
            $('#cbxlogexpinc_category').find('option[data-type="2"]').addClass('cbxlogexpinccathidden').prop('disabled', true);

        } else if (optionValue == 2) {
            $('#cbxlogexpinc_category').prop('disabled', false);
            $('#cbxlogexpinc_category').find('option[data-type="2"]').removeClass('cbxlogexpinccathidden').prop('disabled', false);
            $('#cbxlogexpinc_category').find('option[data-type="1"]').addClass('cbxlogexpinccathidden').prop('disabled', true);
        }

    });

    //delete a log
    $(".cbxdelexpinc").on('click', function (e) {
        e.preventDefault();

        if (!confirm(cbxwpsimpleaccountinglog.permission)) {
            return false;
        }

        var $this = $(this);
        var $id = $this.attr('id');
        var $busy = parseInt($this.data('busy'));

        //ajax call for deleting expinc

        if ($busy == 0) {
            $this.data('busy', 1);
            $('#cbxaccountinglogloading').show();

            var data = {
                'action': 'delete_expinc_log',
                'id': $id,
                'security': cbxwpsimpleaccountinglog.nonce
            };

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajaxurl,
                data: data,
                success: function (response) {
                    if (!response.error) {

                        $this.closest("tr").remove();
                        $('#cbxwpsimpleaccountinglog_notice').show();
                        $('#cbxwpsimpleaccountinglog_notice').html('<p>' + response.msg + '</p>');
                    } else {

                        $this.data('busy', 0);

                        $('#cbxwpsimpleaccountinglog_notice').hide();
                        $('#cbxwpsimpleaccountinglog_notice').html('<p>' + response.msg + '</p>');
                    }
                }

            });//end ajax calling for category
        }


    });
    //end delete log

    //log export cols
    $('#cbxwpsimpleaccounting_log_export_cols_conf').on('click', function (e) {
        e.preventDefault();

        $('#cbxwpsimpleaccounting_log_export_cols_wrap').toggle();
    });

    var cbxwpsa_log_export_cols = cbxwpsimpleaccountinglog.cbxwpsimpleaccounting_log_export_cols;
    if (typeof (localStorage) != 'undefined') {
        if(localStorage.getItem("cbxwpsimpleaccounting_log_export_cols") !== null){
            var storage_data = JSON.parse(localStorage.getItem("cbxwpsimpleaccounting_log_export_cols"));
            if(storage_data.length != 0){
                cbxwpsa_log_export_cols  = storage_data;
            }

        }
        else{
            localStorage.setItem("cbxwpsimpleaccounting_log_export_cols", JSON.stringify(cbxwpsa_log_export_cols));
        }
    }



    $('.cbxwpsimpleaccounting_log_export_col').each(function (index, element) {
        var $element    = $(element);
        var $key        = $element.data('key');

        if (jQuery.inArray($key, cbxwpsa_log_export_cols) !== -1) {
            $element.prop("checked", true);
        } else {
            $element.prop("checked", false);
        }

    });



    $('.cbxwpsimpleaccounting_log_export_col').on('click', function (e) {
        var $element = $(this);

        var $key   = $element.data('key');
        var $index = jQuery.inArray($key, cbxwpsa_log_export_cols);

        if(typeof (localStorage) != 'undefined'){
            if(!$element.is(':checked')){
                if ($index !== -1) {
                    cbxwpsa_log_export_cols.splice($index, 1);
                    localStorage.setItem("cbxwpsimpleaccounting_log_export_cols", JSON.stringify(cbxwpsa_log_export_cols));
                }
            }
            else{
                if ($index === -1) {
                    cbxwpsa_log_export_cols.push($key);
                    localStorage.setItem("cbxwpsimpleaccounting_log_export_cols", JSON.stringify(cbxwpsa_log_export_cols));
                }
            }
        }
    });


});