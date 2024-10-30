//console.log('accounting js loaded');
(function( $ ) {
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

    $(document).ready(function(){

        var all_cat_list    = $.parseJSON(cbxwpsimpleaccounting.cat_results_list);
        //console.log(all_cat_list)


        $( '#cbacnt-expinc-form').submit( function(evnt) {
            evnt.preventDefault();
            var $form = $( this );
            
            $( '.cbacnt-cat-exp.hidden, .cbacnt-cat-inc.hidden' ).find( 'input[type=checkbox]' ).prop( 'checked', false );
           
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajaxurl,
                data: serializeObject( $form, 'add_new_expinc' ),
                beforeSend: function() {
                    $form.find( 'input, select, textarea, button').prop( 'disabled', true );
                },
                success: function(response) {
                    if ( response.error ) {
                        $form.find( '.cbacnt-msg-text' ).text( response.msg );
                        $form.find( '.cbacnt-msg-box' ).addClass( 'error' ).removeClass( 'updated hidden' ).show();
                        $.each( response.field, function(index, value) {
                            $form.find( 'label[for="' + value + '"]' ).addClass( 'cbacnt-error' );
                            $form.find( '#' + value ).addClass( 'cbacnt-error' ).removeClass( 'cbacnt-updated' );
                        });
                    } else {
                        $form.find( '.cbacnt-msg-text' ).html( response.msg );
                        $form.find( '.cbacnt-msg-box' ).addClass( 'updated' ).removeClass( 'error hidden' ).show();
                        //reset form is new item inserted
                        if ( response.form_value.status == 'new' ) {
                            $( '.cbacnt-cat-exp, .cbacnt-cat-inc' ).toggleClass( 'hidden' );
                            $form[0].reset();
                        }

                        //console.log(response.form_value);

                        //if click on edit item
                        $form.find( '.cbacnt-edit-exinc' ).on( 'click', function () {
                            $form.find( '#cbacnt-exinc-id' ).val( response.form_value.id );
                            $form.find( '#cbacnt-exinc-title' ).val( response.form_value.title );
                            $form.find( '#cbacnt-exinc-amount' ).val( response.form_value.amount );
                            $form.find( '#cbacnt-exinc-type' ).val( response.form_value.type );
                            $form.find( '#cbacnt-exinc-note' ).val( response.form_value.note );
                            $form.find( '.cbacnt-cat-exinc' ).addClass( 'hidden' );
                            $form.find( '.cbacnt-cat-type-' + response.form_value.type ).removeClass( 'hidden' );
                            $form.find( '#cbacnt-new-exinc' ).val( $form.find( '#cbacnt-new-exinc').data( 'update-value' ) );
                            $.each( response.form_value.cat_list, function (i, v) {
                                //console.log( 'cbacnt-expinc-cat-' + v );
                                $form.find( '#cbacnt-expinc-cat-' + v ).prop( 'checked', true );
                            } );
                            $( this ).parents( '.cbacnt-msg-box' ).fadeOut();

                        });

                        //if click on add new item
                        $form.find( '.cbacnt-new-exinc' ).on( 'click', function () {
                            $form.find( '#cbacnt-exinc-id' ).val( '0' );
                            $form[0].reset();
                            $( '.cbacnt-cat-exp, .cbacnt-cat-inc' ).toggleClass( 'hidden' );
                            $form.find( '#cbacnt-new-exinc').val( $form.find( '#cbacnt-new-exinc').data( 'add-value' ) );
                            $( this ).parents( '.cbacnt-msg-box' ).fadeOut();
                        });
                    }
                    $form.find( 'input, select, textarea, button').prop( 'disabled', false );
                },
                error: function(e) {
                    $form.find( 'input, select, textarea, button').prop( 'disabled', false );
                    //console.log(e);
                }
            });//end ajax calling for expense/income
        });//end expense/income form submission

        $( '#cbacnt-cat-form').submit( function(evnt) {
            evnt.preventDefault();

            var $form = $( this );

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajaxurl,
                data: serializeObject( $form, 'add_new_expinc_cat' ),
                success: function(response) {
                    //clear all error and update field
                    $form.find( '.cbacnt-cat' ).removeClass( 'cbacnt-error' );
                    $form.find( '#cbacnt-edit-cat-cancel' ).attr( 'disabled', 'disabled' );
                    if ( response.error ) {
                        $form.find( '.cbacnt-msg-text' ).text( response.msg );
                        $form.find( '.cbacnt-msg-box' ).addClass( 'error' ).removeClass( 'updated hidden' ).show();
                        $.each( response.field, function (index, value) {
                            $form.find( 'label[for="' + value + '"], #' + value ).addClass( 'cbacnt-error' );
                        });
                    } else {

                        $form.find( '.cbacnt-msg-text').html( response.msg );

                        $form.find( '.cbacnt-msg-box' ).addClass( 'updated' ).removeClass( 'error hidden' ).show();

                        //reset form is new item inserted
                        if ( response.form_value.status == 'new' ) {
                            $form[0].reset();
                        }


                    }
                }
            });//end ajax calling for category
        });//end category form submission


        //if click on edit category
        $('#cbacnt-cat-form').on( 'click', '.cbacnt-new-cat, #cbacnt-edit-cat-cancel', function (event) {
            event.preventDefault();
            var $form = $(this).parents('#cbacnt-cat-form');

            $form.find( '#cbacnt-edit-cat-cancel').attr( 'disabled', 'disabled' );
            $form.find( '#cbacnt-cat-id').val( '0' );
            $form.find( '#cbacnt-new-cat').val( $form.find( '#cbacnt-new-cat').data( 'add-value' ) );
            $form[0].reset();

            $form.find( '.cbacnt-msg-box' ).fadeOut();
        });

        //if click on edit category
        $('#cbacnt-cat-form').on( 'click', '.cbacnt-edit-cat', function (event) {
            event.preventDefault();
            var $form = $(this).parents('#cbacnt-cat-form');

            var data = {};
            data['action'] = 'load_expinc_cat';
            data['catid']  = parseInt($(this).data('catid'));
            data['nonce']  = cbxwpsimpleaccounting.nonce


            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajaxurl,
                data:  data,
                success: function(response) {
                    //console.log(response)
                    //clear all error and update field
                    if ( response.error ) {
                        $form.find( '.cbacnt-msg-text' ).text( response.msg );
                        $form.find( '.cbacnt-msg-box' ).addClass( 'error' ).removeClass( 'updated hidden' ).show();                       
                    } else {

                        $form.find( '.cbacnt-msg-text').html( response.msg );

                        $form.find( '#cbacnt-cat-id' ).val( response.form_value.id );
                        $form.find( '#cbacnt-cat-title' ).val( response.form_value.title );
                        $form.find( '#cbacnt-cat-type' ).val( response.form_value.type );
                        $form.find( '#cbacnt-cat-note' ).val( response.form_value.note );
                        $form.find( '#cbacnt-new-cat' ).val( $form.find( '#cbacnt-new-cat').data( 'update-value' ) );
                        $form.find( '#cbacnt-edit-cat-cancel').removeAttr( 'disabled' );
                      
                    }
                }
            });//end ajax calling for category  
        });

        $( '#cbacnt-exinc-type').on( 'change', function() {
            $( '.cbacnt-cat-exp, .cbacnt-cat-inc' ).toggleClass( 'hidden' );
        });

    }); //end DOM ready

})( jQuery );
