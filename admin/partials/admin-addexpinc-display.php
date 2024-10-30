<?php
/**
 * Provide a dashboard view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://codeboxr.com
 * @since      1.0.0
 *
 * @package    Cbxwpsimpleaccounting
 * @subpackage Cbxwpsimpleaccounting/admin/partials
 */
if (!current_user_can('edit_cbxaccounting') || !defined('WPINC')) {
    die;
}

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <div id="cbxaccountingloading" style="display:none"></div>
    <h2><?php esc_html_e('CBX Accounting: Add Expense/Income', 'cbxwpsimpleaccounting'); ?></h2>
    <?php if (current_user_can('log_cbxaccounting')): ?>
        <p>
            <a href="<?php echo esc_url(admin_url('admin.php?page=cbxwpsimpleaccountinglog')); ?>"
               class="button button-primary"><?php esc_html_e('Go Back to Log Manager', 'cbxwpsimpleaccounting') ?></a>
        </p>
    <?php endif; ?>

    <?php

    $id = isset($_GET['id']) ? absint($_GET['id']) : 0;

    $col = 1;
    $show_file_manager = false;
    $attachment = intval($setting->get_option('enabled_attachment', 'cbxwpsimpleaccounting_attachments', 0));
    if ($attachment == 1 && $id > 0) {
        $col = 1;
        $show_file_manager = true;
    }
    ?>

    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-<?php echo intval($col); ?>">
            <!-- main content -->
            <div id="post-body-content">
                <div id="cbxaccounting_addexpinc" class="meta-box-sortables ui-sortable">
                    <div class="postbox">
                        <?php
                        if (sizeof($cat_results_list) == 0) {
                            echo '<div class="error"><p>' . sprintf(__('No category created yet, please <a href="%s">create</a> one !', 'cbxwpsimpleaccounting'), admin_url('admin.php?page=cbxwpsimpleaccounting_cat')) . '</p></div>';
                        }
                        if (isset($single_incomeexpense) && sizeof($single_incomeexpense) > 0 && isset($single_incomeexpense['error']) && $single_incomeexpense['error'] == true) {
                            echo '<div class="error"><p>' . $single_incomeexpense['msg'] . '</p></div>';
                        }
                        ?>
                        <h3><span><?php esc_html_e('Add/Edit Expense/Income', 'cbxwpsimpleaccounting'); ?></span>
                        </h3>

                        <div class="inside">
                            <div id="cbxwpsimpleaccounting">
                                <div id="cbxaccounting_addexpinc_wrap">
                                    <?php if ($show_file_manager): ?>
                                        <ul id="cbxaccounting_addexpinc_nav" class="nav nav-tabs ">
                                            <li class="active"><a
                                                        href="#cbxaccounting_addexpinc_edit"><?php esc_html_e('Expense/Income Entry', 'cbxwpsimpleaccounting'); ?></a>
                                            </li>

                                            <li>
                                                <a href="#cbxaccounting_addexpinc_attachments"><?php esc_html_e('File Attachments', 'cbxwpsimpleaccounting'); ?></a>
                                            </li>

                                        </ul>
                                    <?php endif; ?>
                                    <?php if (!$show_file_manager): ?>
                                        <h3>
                                            <?php esc_html_e('Expense/Income Entry', 'cbxwpsimpleaccounting'); ?>
                                        </h3>
                                    <?php endif; ?>
                                    <div id="cbxaccounting_addexpinc_tabs">
                                        <div id="cbxaccounting_addexpinc_edit"
                                             class="cbxaccounting_addexpinc_tab  active">
                                            <form id="cbacnt-expinc-form" class="form-horizontal" action=""
                                                  method="post"
                                                  name="cbacnt-expinc-form">

                                                <div class="cbacnt-msg-box below-h2 ">
                                                    <p class="cbacnt-msg-text">
                                                        <?php
                                                        $validation_errors = array();
                                                        if (array_key_exists('cbx_exp_inc_response', $_SESSION) && sizeof($_SESSION['cbx_exp_inc_response']) > 0) {
                                                            $validation_errors = $_SESSION['cbx_exp_inc_response'];
                                                            unset($_SESSION['cbx_exp_inc_response']);
                                                        }

                                                        if (sizeof($validation_errors) > 0) {
                                                            foreach ($validation_errors as $validation_error) {
                                                                echo '<div class="alert alert-info" role="alert"><p>' . $validation_error['msg'] . '</p></div>';
                                                            }
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                                <input name="cbacnt-exinc-id" id="cbacnt-exinc-id" type="hidden"
                                                       value="<?php echo isset($single_incomeexpense['id']) ? absint($single_incomeexpense['id']) : 0; ?>"/>
                                                <?php wp_nonce_field('add_new_expinc', 'new_expinc_verifier'); ?>

                                                <div>
                                                    <?php
                                                    do_action('cbxwpsimpleaccounting_form_start', $single_incomeexpense);
                                                    ?>
                                                    <div class="row form-group">
                                                        <label for="cbacnt-exinc-title"
                                                               class="col-sm-2 control-label"><?php esc_html_e('Title', 'cbxwpsimpleaccounting'); ?></label>
                                                        <div class="col-sm-10 error_container">
                                                            <input name="cbacnt-exinc-title" id="cbacnt-exinc-title"
                                                                   type="text"
                                                                   value="<?php echo isset($single_incomeexpense['title']) ? stripslashes(esc_attr($single_incomeexpense['title'])) : ''; ?>"
                                                                   class="form-control" data-rule-required="true"
                                                                   data-rule-minlength="5" data-rule-maxlength="200"
                                                                   autofocus
                                                                   placeholder="<?php esc_html_e('Title', 'cbxwpsimpleaccounting'); ?>"/>
                                                        </div>
                                                    </div>

                                                    <div class="row form-group">
                                                        <label for="cbacnt-exinc-amount"
                                                               class="col-sm-2 control-label"><?php esc_html_e('Amount', 'cbxwpsimpleaccounting'); ?>
                                                            (<?php echo $this->settings_api->get_option('cbxwpsimpleaccounting_currency', 'cbxwpsimpleaccounting_basics', 'USD'); ?>
                                                            )</label>
                                                        <div class="col-sm-10 error_container">
                                                            <input name="cbacnt-exinc-amount" id="cbacnt-exinc-amount"
                                                                   value="<?php echo isset($single_incomeexpense['amount']) ? abs(floatval($single_incomeexpense['amount'])) : ''; ?>"
                                                                   class="form-control" type="text"
                                                                   data-rule-required="true" data-rule-number="true"
                                                                   placeholder="<?php esc_html_e('Amount', 'cbxwpsimpleaccounting'); ?>"/>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="cbacnt-exinc-source-amount"><?php esc_html_e('Source Amount', 'cbxwpsimpleaccounting'); ?></label>
                                                        <div class="col-sm-10">
                                                            <div class="row form-group">
                                                                <div class=" col-sm-3 error_container">
                                                                    <input name="cbacnt-exinc-source-amount"
                                                                           id="cbacnt-exinc-source-amount" type="text"
                                                                           data-rule-number="true"
                                                                           value="<?php echo isset($single_incomeexpense['source_amount']) ? abs(floatval($single_incomeexpense['source_amount'])) : ''; ?>"
                                                                           class="form-control"
                                                                           placeholder="<?php esc_html_e('Source Amount', 'cbxwpsimpleaccounting'); ?>"
                                                                           tyle="width:110px; margin-right:10px;"/>
                                                                </div>
                                                                <div class="col-sm-9 error_container">
                                                                    <select name="cbacnt-exinc-currency"
                                                                            id="cbacnt-exinc-currency"
                                                                            class="form-control selecttwo-select">
                                                                        <option
                                                                                value="none"><?php esc_html_e('Select Currency', 'cbxwpsimpleaccounting'); ?></option>
                                                                        <?php foreach ($this->get_cbxwpsimpleaccounting_currencies() as $currencyoption => $currencyvalue) {
                                                                            ?>
                                                                            <option
                                                                                    value="<?php echo $currencyoption; ?>" <?php echo isset($single_incomeexpense['source_currency']) ? (($single_incomeexpense['source_currency'] == $currencyoption) ? ' selected="selected" ' : '') : '  '; ?> > <?php
                                                                                echo $currencyoption;

                                                                                echo $this->get_cbxwpsimpleaccounting_currency_symbol($currencyoption);
                                                                                ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="cbacnt-exinc-type"
                                                               class="col-sm-2 control-label"><?php esc_html_e('Type', 'cbxwpsimpleaccounting'); ?></label>
                                                        <div class="col-sm-10 error_container">
                                                            <label for="cbacnt-exinc-type-1" class="radio-inline">
                                                                <input type="radio" class="cbacnt-exinc-type"
                                                                       id="cbacnt-exinc-type-1"
                                                                       name="cbacnt-exinc-type" value="1"
                                                                       required <?php echo isset($single_incomeexpense['type']) ? checked($single_incomeexpense['type'], 1, false) : ' checked="checked" '; ?> /><?php esc_html_e('Income', 'cbxwpsimpleaccounting'); ?>
                                                            </label>

                                                            <label for="cbacnt-exinc-type-2" class="radio-inline">
                                                                <input type="radio" class="cbacnt-exinc-type"
                                                                       id="cbacnt-exinc-type-2"
                                                                       name="cbacnt-exinc-type" value="2"
                                                                       required <?php echo isset($single_incomeexpense['type']) ? checked($single_incomeexpense['type'], 2, false) : ''; ?> /><?php esc_html_e('Expense', 'cbxwpsimpleaccounting'); ?>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label"><?php esc_html_e('Category', 'cbxwpsimpleaccounting'); ?></label>
                                                        <div class="col-sm-10 error_container">
                                                            <ul id="cbacnt-expinc-cat-list"
                                                                class="cbacnt-cat-list cat-checklist category-checklist"
                                                                data-catlist='<?php echo json_encode($cat_results_list); ?>'>
                                                                <?php foreach ($cat_results_list as $list): ?>
                                                                    <?php if (absint($list['type']) == 1): ?>
                                                                        <li style="color:<?php echo stripslashes(esc_attr($list['color'])); ?>;"
                                                                            class="cbacnt-cat-exinc cbacnt-cat-inc cbacnt-cat-type-<?php echo $list['type']; ?> <?php echo isset($single_incomeexpense['type']) ? (($single_incomeexpense['type'] == 1) ? '' : 'hidden') : '' ?>">
                                                                            <label class="selectit category-multi-selectbox">
                                                                                <input data-value="<?php echo $list['id']; ?>"
                                                                                       value="<?php echo $list['id']; ?>"
                                                                                       type="checkbox" <?php echo (isset($single_incomeexpense['type']) && ($single_incomeexpense['type'] == 1) && in_array($list['id'], $single_incomeexpense['cat_list'])) ? ' checked="checked" ' : ((isset($single_incomeexpense['type']) && !in_array($list['id'], $single_incomeexpense['cat_list']) && count($single_incomeexpense['cat_list']) > 0) ? ' disabled' : ''); ?>
                                                                                       name="cbacnt-expinc-cat[<?php echo $list['type']; ?>][<?php echo $list['id']; ?>]"
                                                                                       id="cbacnt-expinc-cat-<?php echo $list['id']; ?>"
                                                                                       class="cbacnt-cat-exinciteminput single-checkbox"
                                                                                       required> <?php echo stripslashes(esc_attr($list['title'])); ?>
                                                                            </label>
                                                                        </li>
                                                                    <?php elseif (absint($list['type']) == 2): ?>
                                                                        <li style="color:<?php echo stripslashes(esc_attr($list['color'])); ?>"
                                                                            class="cbacnt-cat-exinc cbacnt-cat-exp cbacnt-cat-type-<?php echo $list['type']; ?> <?php echo isset($single_incomeexpense['type']) ? (($single_incomeexpense['type'] == 2) ? '' : 'hidden') : 'hidden' ?>">
                                                                            <label class="selectit category-multi-selectbox">
                                                                                <input data-value="<?php echo $list['id']; ?>"
                                                                                       value="<?php echo $list['id']; ?>"
                                                                                       type="checkbox" <?php echo (isset($single_incomeexpense['type']) && ($single_incomeexpense['type'] == 2) && in_array($list['id'], $single_incomeexpense['cat_list'])) ? ' checked="checked " ' : ((isset($single_incomeexpense['type']) && !in_array($list['id'], $single_incomeexpense['cat_list']) && count($single_incomeexpense['cat_list']) > 0) ? ' disabled' : ''); ?>
                                                                                       name="cbacnt-expinc-cat[<?php echo $list['type']; ?>][<?php echo $list['id']; ?>]"
                                                                                       id="cbacnt-expinc-cat-<?php echo $list['id']; ?>"
                                                                                       class="cbacnt-cat-exinciteminput single-checkbox"
                                                                                       required> <?php echo stripslashes(esc_attr($list['title'])); ?>
                                                                            </label>
                                                                        </li>
                                                                    <?php
                                                                    endif;
                                                                    ?>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="cbacnt-exinc-note"
                                                               class="col-sm-2 control-label"><?php esc_html_e('Note', 'cbxwpsimpleaccounting'); ?></label>
                                                        <div class="col-sm-10 error_container">
                                                <textarea id="cbacnt-exinc-note" name="cbacnt-exinc-note"
                                                          class="form-control"
                                                          cols="50"
                                                          rows="6" data-rule-minlength="10" data-rule-maxlength="2000"
                                                          placeholder="<?php esc_html_e('Note', 'cbxwpsimpleaccounting'); ?>"><?php echo isset($single_incomeexpense['note']) ? $single_incomeexpense['note'] : ''; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="cbacnt-exinc-acc"
                                                               class="col-sm-2 control-label"><?php esc_html_e('Account', 'cbxwpsimpleaccounting'); ?></label>
                                                        <div class="col-sm-10 error_container">
                                                            <select name="cbacnt-exinc-acc" id="cbacnt-exinc-acc"
                                                                    class="form-control selecttwo-select">
                                                                <option value><?php esc_html_e('Select Bank Account', 'cbxwpsimpleaccounting') ?></option>

                                                                <?php foreach ($all_acc_list as $acc) { ?>

                                                                    <option value= <?php echo $acc->id; ?> <?php echo isset($single_incomeexpense['account']) ? (($single_incomeexpense['account'] == $acc->id) ? ' selected="selected" ' : '') : ''; ?>><?php echo $acc->title; ?></option>

                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="cbacnt-exinc-invoice"
                                                               class="col-sm-2 control-label"><?php esc_html_e('Invoice No.', 'cbxwpsimpleaccounting'); ?></label>
                                                        <div class="col-sm-10 error_container">
                                                            <input name="cbacnt-exinc-invoice" id="cbacnt-exinc-invoice"
                                                                   type="text"
                                                                   class="form-control"
                                                                   value="<?php echo isset($single_incomeexpense['invoice']) ? stripslashes(esc_attr($single_incomeexpense['invoice'])) : ''; ?>"
                                                                   placeholder="<?php esc_html_e('Invoice No.', 'cbxwpsimpleaccounting'); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="cbacnt-exinc-include-tax"
                                                               class="col-sm-2 control-label"><?php esc_html_e('Add Tax:', 'cbxwpsimpleaccounting'); ?></label>
                                                        <div class="col-sm-10 error_container">
                                                            <input type="checkbox" name="cbacnt-exinc-include-tax"
                                                                   id="cbacnt-exinc-include-tax" class=""
                                                                   value="1" <?php echo (isset($single_incomeexpense['istaxincluded']) && $single_incomeexpense['istaxincluded'] == 1) ? 'checked' : ''; ?>/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="cbacnt-exinc-tax"
                                                               class="col-sm-2 control-label"><?php esc_html_e('Vat(%)', 'cbxwpsimpleaccounting'); ?></label>
                                                        <div class="col-sm-10 error_container">
                                                            <input name="cbacnt-exinc-tax" id="cbacnt-exinc-tax"
                                                                   class="form-control" type="text"
                                                                   value="<?php echo isset($single_incomeexpense['tax']) ? floatval($single_incomeexpense['tax']) : $this->settings_api->get_option('cbxwpsimpleaccounting_sales_tax', 'cbxwpsimpleaccounting_tax', '0'); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="cbacnt-exinc-add-date"
                                                               class="col-sm-2 control-label"><?php esc_html_e('Added Date', 'cbxwpsimpleaccounting'); ?></label>
                                                        <div class="col-sm-10 error_container">
                                                            <input autocomplete="new-password" type="text"
                                                                   id="cbacnt-exinc-add-date"
                                                                   name="cbacnt-exinc-add-date" class="form-control"
                                                                   value="<?php echo isset($single_incomeexpense['add_date']) ? $single_incomeexpense['add_date'] : ''; ?>"
                                                                   placeholder="<?php esc_html_e('Added Date', 'cbxwpsimpleaccounting'); ?>"/>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    do_action('cbxwpsimpleaccounting_form_end', $single_incomeexpense);
                                                    ?>

                                                    <div class="form-group">
                                                        <div class="col-sm-2"></div>
                                                        <div class="col-sm-10">
                                                            <input type="hidden"
                                                                   name="cbxwpsimpleaccounting_expinc_addedit"
                                                                   value="1"/>
                                                            <input id="cbacnt-new-exinc" class="btn btn-primary"
                                                                   type="submit"
                                                                   name="cbacnt-new-exinc"
                                                                   data-add-value="<?php esc_html_e('Add new expense/income', 'cbxwpsimpleaccounting'); ?>"
                                                                   data-update-value="<?php esc_html_e('Update expense/income', 'cbxwpsimpleaccounting'); ?>"
                                                                   value="<?php echo isset($single_incomeexpense['id']) ? esc_html__('Update expense/income', 'cbxwpsimpleaccounting') : esc_html__('Add new expense/income', 'cbxwpsimpleaccounting'); ?>"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <?php if ($show_file_manager): ?>
                                            <div id="cbxaccounting_addexpinc_attachments"
                                                 class="cbxaccounting_addexpinc_tab">
                                                <?php
                                                include('admin-addexpinc-attachments.php');
                                                ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <!-- .inside -->
                    </div>
                    <!-- .postbox -->
                </div>
                <!-- .meta-box-sortables .ui-sortable -->
            </div>
            <!-- post-body-content -->
            <?php
            //include( 'sidebar.php' );
            //if($show_file_manager){
            //include( 'admin-addexpinc-attachments.php' );
            //}
            ?>
        </div>
        <div class="clear"></div>
    </div>
</div>