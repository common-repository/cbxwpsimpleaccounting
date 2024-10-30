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
if (!current_user_can('manage_cbxaccounting') || !defined('WPINC')) {
    die;
}
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <div id="cbxaccountingloading" style="display:none"></div>
    <h1 class="wp-heading-inline wp-heading-inline-overview"><?php esc_html_e('CBX Accounting: Overview', 'cbxwpsimpleaccounting'); ?></h1>
	<div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <!-- main content -->
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <div class="postbox">
                        <h3><span><?php esc_html_e('Quick Summary of the Year : ', 'cbxwpsimpleaccounting'); ?><b class="cbxyear"></b></span></h3>
                        <hr />
                        <div class="inside">
                            <p class="accountingyear_traverse">
                                <a data-year="<?php esc_html_e(date("Y") - 1) ?>" data-busy="0"
                                   data-type="prev"
                                   class="button button-primary button-small btn btn-default btn-sm cbxaccounting_btn cbxaccounting_peryear "><?php esc_html_e("Prev", 'cbxwpsimpleaccounting') ?></a>
                                <a data-year="<?php esc_html_e(date("Y") + 1) ?>" data-busy="0"
                                   data-type="next"
                                   class="button button-primary button-small btn btn-default btn-sm cbx-next cbxaccounting_btn cbxaccounting_peryear hidden"><?php esc_html_e("Next", 'cbxwpsimpleaccounting'); ?></a>
                            </p>
                            <div id="cbxaccountchart" style="width: 100%; height: 500px;"></div>
                        </div> <!-- .inside -->
                    </div> <!-- .postbox -->
                    <div class="postbox">
                        <h3><span><?php esc_html_e('Quick Summary of the Month : ', 'cbxwpsimpleaccounting'); ?><b class="cbxmonthyear"></b></span></h3>
                        <hr />
                        <div class="inside">
                            <p class="accountingmonth_traverse">
                                <?php
                                $accounting_month = (int) date('m');
                                $accounting_year  = (int) date('Y');

                                if ($accounting_month == 12) {
                                    $accounting_prev_month = $accounting_month - 1;
                                    $accounting_next_month = 1;
                                    $accounting_prev_year  = $accounting_year;
                                    $accounting_next_year  = $accounting_year + 1;
                                }
                                elseif ($accounting_month == 1) {
                                    $accounting_prev_month = 12;
                                    $accounting_next_month = $accounting_month + 1;
                                    $accounting_prev_year  = $accounting_year - 1;
                                    $accounting_next_year  = $accounting_year;
                                }
                                else {
                                    $accounting_prev_month = $accounting_month - 1;
                                    $accounting_next_month = $accounting_month + 1;
                                    $accounting_prev_year  = $accounting_year;
                                    $accounting_next_year  = $accounting_year;
                                }

                                $accounting_display = ($accounting_next_month > $accounting_month) ? 'display:none;' : '';
                                ?>
                                <a data-year="<?php echo $accounting_prev_year; ?>"
                                   data-month="<?php echo $accounting_prev_month; ?>"
                                   data-busy="0"
                                   data-type="prev"
                                   class="button button-primary button-small btn btn-default btn-sm cbxaccounting_btn cbxaccounting_permonth"><?php esc_html_e("Prev", 'cbxwpsimpleaccounting') ?></a>
                                <a data-year="<?php echo $accounting_next_year; ?>"
                                   data-month="<?php echo $accounting_next_month; ?>"
                                   data-busy="0"
                                   data-target=""
                                   data-type="next"
                                   class="button button-primary button-small btn btn-default btn-sm  cbx-next cbxaccounting_btn cbxaccounting_permonth hidden"><?php esc_html_e("Next", 'cbxwpsimpleaccounting'); ?></a>

                            </p>
                            <div id="cbxaccountchartmonth" style="width: 100%; height: 500px;"></div>
                        </div> <!-- .inside -->
                    </div> <!-- .postbox -->
                    <div class="postbox">
                        <h3><span><?php esc_html_e('Pie Diagram of Latest Income and Expense by Category', 'cbxwpsimpleaccounting'); ?></span></h3>
                        <hr />
                        <div class="inside">
                            <div id="cbxaccinc" style="height: 300px;"></div>
                            <h3 style="padding-left: 25%;"><?php esc_html_e('Latest Income stats of this month', 'cbxwpsimpleaccounting'); ?></h3>

                            <div id="cbxaccexp" style="height: 300px;"></div>
                            <h3 style="padding-left: 25%;"><?php esc_html_e('Latest Expense stats of this month', 'cbxwpsimpleaccounting'); ?></h3>
                        </div> <!-- .inside -->
                    </div>  <!-- .postbox -->
                    <div class="postbox">
                        <h3><span><?php esc_html_e('Quick Summary(Including Tax)', 'cbxwpsimpleaccounting'); ?></span></h3>
                        <hr />
                        <div class="inside">
                            <table class="form-table">
                                <tr class="alternate">
                                    <th class="row-title"></th>
                                    <th class="row-title"><?php esc_attr_e( 'Income', 'cbxwpsimpleaccounting' ); ?></th>
                                    <th class="row-title"><?php esc_attr_e( 'Expense', 'cbxwpsimpleaccounting' ); ?></th>
                                    <th class="row-title"><?php esc_attr_e( 'Profit', 'cbxwpsimpleaccounting' ); ?></th>
                                <tr>
                                    <th class="row-title"><?php esc_attr_e( 'All Time Total', 'cbxwpsimpleaccounting' ); ?></th>
                                    <th><?php echo $total_quick->total_income; ?></th>
                                    <th><?php echo $total_quick->total_expense; ?></th>
                                    <th><?php echo $total_quick->profit; ?></th>
                                </tr>
                                <tr class="alternate">
                                    <th class="row-title"><?php esc_attr_e( 'This Year', 'cbxwpsimpleaccounting' ); ?></th>
                                    <th><?php echo $total_year_quick->total_income; ?></th>
                                    <th><?php echo $total_year_quick->total_expense; ?></th>
                                    <th><?php echo $total_year_quick->profit; ?></th>
                                </tr>
                                <tr>
                                    <th class="row-title"><?php esc_attr_e( 'This Month', 'cbxwpsimpleaccounting' ); ?></th>
                                    <th><?php echo $total_month_quick->total_income; ?></th>
                                    <th><?php echo $total_month_quick->total_expense; ?></th>
                                    <th><?php echo $total_month_quick->profit; ?></th>
                                </tr>

                            </table>
                        </div> <!-- .inside -->
                    </div> <!-- .postbox -->
                    <div class="postbox">
                        <h3><span><?php esc_html_e('Latest Income(Showing latest 20 entries)', 'cbxwpsimpleaccounting'); ?></span></h3>
                        <div class="inside">
                            <table class="widefat" width="100%">
                                <thead>
                                    <tr>
                                        <th class="row-title" width="14%" style="text-align: center;"><?php esc_attr_e('Title', 'cbxwpsimpleaccounting'); ?></th>
										<th width="14%" style="text-align: center;"><?php esc_attr_e('Category', 'cbxwpsimpleaccounting'); ?></th>
										<th width="14%" style="text-align: center;"><?php esc_attr_e('Account', 'cbxwpsimpleaccounting'); ?></th>
										<th width="5%" style="text-align: center;"><?php esc_attr_e('Invoice', 'cbxwpsimpleaccounting'); ?></th>
										<!--<th width="5%" style="text-align: center;"><?php /*esc_attr_e('Tax', 'cbxwpsimpleaccounting'); */?></th>-->
										<th width="10%" style="text-align: center;"><?php esc_attr_e('Amount', 'cbxwpsimpleaccounting'); ?></th>
										<th width="10%" style="text-align: center;"><?php esc_attr_e('Final Amount', 'cbxwpsimpleaccounting'); ?></th>
										<th width="14%" style="text-align: center;"><?php esc_attr_e('Date', 'cbxwpsimpleaccounting'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cbxsettings        = new CBXWPSimpleaccounting_Settings_API();
                                    $cbxacc_cat_color   = $cbxsettings->get_option('cbxacc_category_color', 'cbxwpsimpleaccounting_category', 'on');


                                    if (!empty($latest_income)) {
                                        foreach ($latest_income as $key => $income) {
                                            $class       = ($key % 2 == 0) ? 'alternate' : '';


	                                       /* $category_style = '';
	                                        if($cbxacc_cat_color == 'on'){
		                                        $category_style = ' style = "color: '.$income->catcolor.' !imporatnt;" ';
	                                        }*/

                                            ?>
                                            <tr class="<?php echo $class; ?>">
                                                <td class="row-title cbx_center" width="14%">
                                                    <strong><?php echo apply_filters('cbxwpsimpleaccounting_title_link', stripslashes(esc_attr(($income->title))), $income->id); ?></strong>
													<?php

														if (current_user_can('edit_cbxaccounting') && ((isset($income->protected) && intval($income->protected) == 0) || (isset($income->protected) && intval($income->protected) == 1 && $allow_protected_edit == 'on'))) {
															echo sprintf('<a href="%s" class="cbxeditexpinc" title="%s"></a>', get_admin_url() . 'admin.php?page=cbxwpsimpleaccounting_addexpinc&id=' . $income->id, esc_html__('Edit', 'cbxwpsimpleaccounting'));
														}

													/*if (current_user_can('edit_cbxaccounting') && ( isset($income->protected) && intval($income->protected) == 0 )){
														echo sprintf('<a href="%s" class="cbxeditexpinc" title="%s"></a>', get_admin_url() . 'admin.php?page=cbxwpsimpleaccounting_addexpinc&id=' . $income->id, esc_html__('Edit', 'cbxwpsimpleaccounting'));
													}*/


													if (current_user_can('delete_cbxaccounting')){
														echo sprintf('|<a data-busy="0" href="#" class = "cbxdelexpinc" id = "%d" title="%s"></a>', $income->id, esc_html__('Delete', 'cbxwpsimpleaccounting'));
													}

													?>
                                                </td>
                                                <td class="row-title cbx_center" width="14%">

                                                    <?php
                                                    $inc_catname = stripslashes(esc_attr($income->cattitle));
                                                    $expinc_type = '1';
                                                    echo apply_filters('cbxwpsimpleaccounting_catlog_link', $inc_catname, $expinc_type, $income->catid);
                                                    ?>
                                                </td>
												<td class="row-title cbx_center" width="14%">
													<?php
													$account_name =   ($income->accountname == '') ? esc_html__('N/A', 'cbxwpsimpleaccounting') : esc_html($income->accountname) ;
													echo apply_filters('cbxwpsimpleaccounting_accountlog_link', $account_name, $expinc_type, $income->account);
													?>
												</td>
												<td class="row-title cbx_center" width="5%"><?php echo $income->invoice; ?></td>
                                                <!--<td style="<?php /*echo esc_attr($color_style); */?>" class="row-title cbx_center" width="5%"><?php /*echo $income->tax; */?></td>-->
                                                <td class="row-title cbx_center" width="10%"><span class="cbxwpsimpleaccounting_type_1"><?php echo CBXWpsimpleaccountingHelper::format_value_quick($income->amount); ?></span></td>
                                                <td class="row-title cbx_center" width="10%"><span class="cbxwpsimpleaccounting_type_1"><?php echo ($income->tax != NULL && $income->istaxincluded == 1) ? CBXWpsimpleaccountingHelper::format_value_quick($income->amount + ($income->amount * $income->tax) / 100) : CBXWpsimpleaccountingHelper::format_value_quick($income->amount, $currency_number_decimal); ?></span></td>
                                                <td class="row-title cbx_center" width="14%">
													<?php
													/*if(intval($income->add_by) > 0){
														$add_by_user = get_user_by('id', $income->add_by);
														if($add_by_user !== false){
															echo wp_unslash($add_by_user->display_name).'('.$income->add_date.')';
														}
													}*/
													echo $income->add_date;

													?>
												</td>
                                            </tr>

                                            <?php
                                        }
                                    } else { ?>
                                        <tr>
                                            <td colspan="8" scope="row">
												<div class="notice notice-info inline"><p><?php esc_html_e('No data found', 'cbxwpsimpleaccounting'); ?></p></div>
											</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="row-title" width="14%" style="text-align: center;"><?php esc_attr_e('Title', 'cbxwpsimpleaccounting'); ?></th>
                                        <th width="14%" style="text-align: center;"><?php esc_attr_e('Category', 'cbxwpsimpleaccounting'); ?></th>
										<th width="14%" style="text-align: center;"><?php esc_attr_e('Account', 'cbxwpsimpleaccounting'); ?></th>
										<th width="5%" style="text-align: center;"><?php esc_attr_e('Invoice', 'cbxwpsimpleaccounting'); ?></th>
										<!--<th width="5%" style="text-align: center;"><?php /*esc_attr_e('Tax', 'cbxwpsimpleaccounting'); */?></th>-->
										<th width="10%" style="text-align: center;"><?php esc_attr_e('Amount', 'cbxwpsimpleaccounting'); ?></th>
										<th width="10%" style="text-align: center;"><?php esc_attr_e('Final Amount', 'cbxwpsimpleaccounting'); ?></th>
                                        <th width="14%" style="text-align: center;"><?php esc_attr_e('Date', 'cbxwpsimpleaccounting'); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div> <!-- .inside -->
                    </div> <!-- .postbox -->
                    <div class="postbox">
                        <h3><span><?php _e('Latest Expense(Showing latest 20 entries)', 'cbxwpsimpleaccounting'); ?></span></h3>
                        <div class="inside">
                            <table class="widefat">
                                <thead>
                                    <tr>
                                        <th class="row-title" width="14%" style="text-align: center;"><?php esc_attr_e('Title', 'cbxwpsimpleaccounting'); ?></th>
										<th width="14%" style="text-align: center;"><?php esc_attr_e('Category', 'cbxwpsimpleaccounting'); ?></th>
										<th width="14%" style="text-align: center;"><?php esc_attr_e('Account', 'cbxwpsimpleaccounting'); ?></th>
										<th width="5%" style="text-align: center;"><?php esc_attr_e('Invoice', 'cbxwpsimpleaccounting'); ?></th>
										<!--<th width="5%" style="text-align: center;"><?php /*esc_attr_e('Tax', 'cbxwpsimpleaccounting'); */?></th>-->
										<th width="10%" style="text-align: center;"><?php esc_attr_e('Amount', 'cbxwpsimpleaccounting'); ?></th>
										<th width="10%" style="text-align: center;"><?php esc_attr_e('Final Amount', 'cbxwpsimpleaccounting'); ?></th>
										<th width="14%" style="text-align: center;"><?php esc_attr_e('Date', 'cbxwpsimpleaccounting'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($latest_expense)) {
                                        foreach ($latest_expense as $key => $expense) {
                                            $class       = ($key % 2 == 0) ? 'alternate' : '';

                                            /*$category_style = '';
	                                        if($cbxacc_cat_color == 'on'){
		                                        $category_style = ' style = "color: '.$expense->catcolor.' !imporatnt;" ';
	                                        }*/
                                            ?>
                                            <tr class="<?php echo $class; ?>">
                                                <td  width="14%" class="row-title cbx_center">
                                                    <strong><?php echo apply_filters('cbxwpsimpleaccounting_title_link', stripslashes(esc_attr(($expense->title))), $expense->id); ?></strong>
													<?php

														if (current_user_can('edit_cbxaccounting') && ((isset($expense->protected) && intval($expense->protected) == 0) || (isset($expense->protected) && intval($expense->protected) == 1 && $allow_protected_edit == 'on'))) {
															echo sprintf('<a href="%s" class="cbxeditexpinc" title="%s"></a>', get_admin_url() . 'admin.php?page=cbxwpsimpleaccounting_addexpinc&id=' . $expense->id, esc_html__('Edit', 'cbxwpsimpleaccounting'));
														}

													/*if (current_user_can('edit_cbxaccounting') && ( isset($expense->protected) && intval($expense->protected) == 0 )){
														echo sprintf('<a href="%s" class="cbxeditexpinc" title="%s"></a>', get_admin_url() . 'admin.php?page=cbxwpsimpleaccounting_addexpinc&id=' . $expense->id, esc_html__('Edit', 'cbxwpsimpleaccounting'));
													}*/


													if (current_user_can('delete_cbxaccounting')){
														echo sprintf('|<a data-busy="0" href="#" class ="cbxdelexpinc" id = "%d" title="%s"></a>', $expense->id, esc_html__('Delete', 'cbxwpsimpleaccounting'));
													}

													?>
                                                </td>


                                                <td width="14%" class="row-title cbx_center">
                                                    <?php
                                                    $exp_catname = esc_attr(wp_unslash($expense->cattitle));
                                                    $expinc_type = '2';
                                                    echo apply_filters('cbxwpsimpleaccounting_catlog_link', $exp_catname, $expinc_type, $expense->catid);
                                                    ?>
                                                </td>
												<td width="14%" class="row-title cbx_center">
													<?php
													 $account_name  = ($expense->accountname == '') ? esc_html__('N/A', 'cbxwpsimpleaccounting') : esc_html($expense->accountname) ;
													 echo apply_filters('cbxwpsimpleaccounting_accountlog_link', $account_name, $expinc_type, $expense->account);
													?>
												</td>
												<td  class="row-title cbx_center" width="5%"><?php echo $expense->invoice; ?></td>
                                                <!--<td style="color:<?php /*echo ($cbxacc_cat_color == 'on') ? $expense->catcolor : ''; */?>"; class="row-title cbx_center" width="5%"><?php /*echo $expense->tax; */?></td>-->
                                                <td width="10%" class="row-title cbx_center"><span class="cbxwpsimpleaccounting_type_2"><?php echo CBXWpsimpleaccountingHelper::format_value_quick($expense->amount); ?></span></td>
                                                <td class="row-title cbx_center" width="10%"><span class="cbxwpsimpleaccounting_type_2"><?php echo ($expense->tax != NULL && $expense->istaxincluded == 1) ? CBXWpsimpleaccountingHelper::format_value_quick($expense->amount + ($expense->amount * $expense->tax) / 100) : CBXWpsimpleaccountingHelper::format_value_quick($expense->amount); ?></span></td>
                                                <td width="14%" class="row-title cbx_center">
													<?php
														/*if(intval($expense->add_by) > 0){
															$add_by_user = get_user_by('id', $expense->add_by);
															if($add_by_user !== false){
																echo wp_unslash($add_by_user->display_name).'('.$expense->add_date.')';
															}
														}*/

														echo $expense->add_date;

													?>
												</td>
                                            </tr>
                                            <?php
                                        }
                                    } else { ?>
                                        <tr>
                                            <td colspan="8" scope="row">
												<div class="notice notice-info inline"><p><?php esc_html_e('No data found', 'cbxwpsimpleaccounting'); ?></p></div>
											</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th width="14%" class="row-title" style="text-align: center;"><?php esc_attr_e('Title', 'cbxwpsimpleaccounting'); ?></th>
										<th width="14%" style="text-align: center;"><?php esc_attr_e('Category', 'cbxwpsimpleaccounting'); ?></th>
										<th width="14%" style="text-align: center;"><?php esc_attr_e('Account', 'cbxwpsimpleaccounting'); ?></th>
										<th width="5%" style="text-align: center;"><?php esc_attr_e('Invoice', 'cbxwpsimpleaccounting'); ?></th>
										<!--<th width="5%" style="text-align: center;"><?php /*esc_attr_e('Tax', 'cbxwpsimpleaccounting'); */?></th>-->
										<th width="10%" style="text-align: center;"><?php esc_attr_e('Amount', 'cbxwpsimpleaccounting'); ?></th>
										<th width="10%" style="text-align: center;"><?php esc_attr_e('Final Amount', 'cbxwpsimpleaccounting'); ?></th>
										<th width="14%" style="text-align: center;"><?php esc_attr_e('Date', 'cbxwpsimpleaccounting'); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div> <!-- .inside -->
                    </div> <!-- .postbox -->
                </div> <!-- .meta-box-sortables .ui-sortable -->
            </div> <!-- post-body-content -->
            <?php
            include('sidebar.php');
            ?>
        </div>
		<div class="clear clearfix"></div>
    </div>
</div>