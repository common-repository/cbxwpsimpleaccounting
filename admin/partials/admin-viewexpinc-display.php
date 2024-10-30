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
if (!current_user_can('log_cbxaccounting') || !defined('WPINC')) {
    die;
}

	$id = isset($_GET['id'])? absint($_GET['id']) : 0;

?>


<div class="wrap">
    <div id="cbxaccountingloading" style="display:none"></div>
    <h1 class="wp-heading-inline wp-heading-inline-logview"><?php esc_html_e('CBX Accounting: View Expense/Income', 'cbxwpsimpleaccounting'); ?></h1>
	<?php if ( current_user_can( 'log_cbxaccounting' ) || current_user_can('edit_cbxaccounting') ): ?>
		<p>
			<?php  if(current_user_can( 'log_cbxaccounting' )) :?>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=cbxwpsimpleaccountinglog' ) ); ?>"
			   class="button button-primary"><?php esc_html_e( 'Go Back to Log Manager', 'cbxwpsimpleaccounting' ) ?></a>
			<?php endif; ?>
			<?php  if(current_user_can( 'edit_cbxaccounting' )) :?>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=cbxwpsimpleaccounting_addexpinc&id='.$id ) ); ?>"
				   class="button button-primary"><?php esc_html_e( 'Edit Log', 'cbxwpsimpleaccounting' ) ?></a>
			<?php endif; ?>
		</p>
	<?php endif; ?>

	<?php


    $col = 1;
    $show_file_manager = false;
    $attachment = intval($setting->get_option('enabled_attachment', 'cbxwpsimpleaccounting_attachments', 0));
    if($attachment == 1 && $id > 0)	{
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
                        <h3><span><?php esc_html_e('View Expense/Income', 'cbxwpsimpleaccounting'); ?></span></h3>

                        <div class="inside">
                            <div id="cbacnt-expinc-form">
                                <div class="cbacnt-msg-box below-h2 hidden"><p class="cbacnt-msg-text"></p></div>
                                <table class="form-table form-table-compact">
									<?php
									do_action('cbxwpsimpleaccounting_view_form_start', $single_incomeexpense);
									?>
                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label
                                                for="cbacnt-exinc-title"><?php _e('Title', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td>
											<?php echo isset($single_incomeexpense['title']) ? stripslashes(esc_attr($single_incomeexpense['title'])) : ''; ?>
                                        </td>
                                    </tr>

                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label
                                                for="cbacnt-exinc-amount"><?php esc_html_e('Amount', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td>
											<?php echo isset($single_incomeexpense['amount']) ? abs(floatval($single_incomeexpense['amount'])) : ''; ?> <?php echo $this->settings_api->get_option('cbxwpsimpleaccounting_currency', 'cbxwpsimpleaccounting_basics', 'USD'); ?>
                                        </td>

                                    </tr>

                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label
                                                for="cbacnt-exinc-source-amount"><?php esc_html_e('Source Amount', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td>
                                            <?php

                                                if(isset($single_incomeexpense['source_amount']) ){
                                                    echo abs(floatval($single_incomeexpense['source_amount']));
													foreach ($this->get_cbxwpsimpleaccounting_currencies() as $currencyoption => $currencyvalue) {
														echo (isset($single_incomeexpense['source_currency']) && $single_incomeexpense['source_currency'] == $currencyoption) ? $currencyoption : '';
													}
											    }
											?>
                                        </td>

                                    </tr>

                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label
                                                for="cbacnt-exinc-type"><?php esc_html_e('Type', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td>
                                            <?php
                                                if(isset($single_incomeexpense['type']) && intval($single_incomeexpense['type']) == 1){
													esc_html_e('Income', 'cbxwpsimpleaccounting');
                                                }
                                                else{
													esc_html_e('Expense', 'cbxwpsimpleaccounting');
                                                }
                                            ?>
                                        </td>
                                    </tr>

                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label><?php esc_html_e('Category', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td>
                                            <?php

												foreach ($cat_results_list as $list){
												    if(is_array($single_incomeexpense['cat_list']) && sizeof($single_incomeexpense['cat_list']) > 0 && in_array($list['id'], $single_incomeexpense['cat_list'])){
														echo wp_unslash(esc_attr($list['title']));
														break;
													}
                                                }
                                            ?>
                                        </td>
                                    </tr>						
                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label
                                                for="cbacnt-exinc-note"><?php esc_html_e('Note', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td><?php echo isset($single_incomeexpense['note']) ? nl2br(wp_unslash($single_incomeexpense['note'])) : ''; ?></td>
                                    </tr>

                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label for="cbacnt-exinc-account"><?php esc_html_e('Account', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td>
                                            <?php foreach ($all_acc_list as $acc) {

                                                if(isset($single_incomeexpense['account']) && ($single_incomeexpense['account'] == $acc->id) ){
													echo $acc->title;
                                                }


                                             } ?>

                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label
                                                for="cbacnt-exinc-invoice"><?php esc_html_e('Invoice No.', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td>
											<?php echo isset($single_incomeexpense['invoice']) ? stripslashes(esc_attr($single_incomeexpense['invoice'])) : ''; ?>
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label for="cbacnt-exinc-tax-include"><?php esc_html_e('Add Tax:', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td>
											<?php
                                                if(isset($single_incomeexpense['istaxincluded']) && $single_incomeexpense['istaxincluded'] == 1) {
											        esc_html_e('Yes', 'cbxwpsimpleaccounting');
                                                }
                                            ?>
                                        </td>
                                    </tr>

                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label for="cbacnt-exinc-tax"><?php esc_html_e('Vat(%)', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td>
											<?php echo isset($single_incomeexpense['tax']) ? stripslashes(esc_attr($single_incomeexpense['tax'])) : $this->settings_api->get_option('cbxwpsimpleaccounting_sales_tax', 'cbxwpsimpleaccounting_tax', '0'); ?>

                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label for="cbacnt-exinc-date"><?php esc_html_e('Added Date', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td>
											<?php echo isset($single_incomeexpense['add_date']) ? $single_incomeexpense['add_date'] : '';?>
                                            
                                        </td>
                                    </tr>
                                    <?php
									do_action('cbxwpsimpleaccounting_view_form_end', $single_incomeexpense);
									?>
                                </table>

                            </div>

                        </div>
                        <!-- .inside -->
                    </div>
	                <?php

		                if($show_file_manager){
			                include( 'admin-viewexpinc-attachments.php' );
		                }
	                ?>
                    <!-- .postbox -->
                </div>
                <!-- .meta-box-sortables .ui-sortable -->
            </div>
            <!-- post-body-content -->

        </div>
		<div class="clear clearfix"></div>
    </div>
</div>

