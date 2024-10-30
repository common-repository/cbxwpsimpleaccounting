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
	if (!defined('WPINC')) {
		die;
	}
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <div id="cbxaccountingloading" style="display:none"></div>
    <h1 class="wp-heading-inline wp-heading-inline-catview"><?php esc_html_e('CBX Accounting: View Category', 'cbxwpsimpleaccounting'); ?></h1>

    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-1">

            <!-- main content -->
            <div id="post-body-content">
                <div id="cbxaccounting_catmanager" class="meta-box-sortables ui-sortable">

                    <div class="postbox">
                        <h3><span><?php esc_html_e('View Category', 'cbxwpsimpleaccounting'); ?></span></h3>
                        <div class="inside">
							<?php
								$notice_text  = '';
								$noteice_type = 'info';
								if ($cat_found) {
								    if(isset($cat_data['protected']) && intval($cat_data['protected']) == 1){
										$notice_text  = esc_html__('This is a protected category, it means this category is created by 3rd party plugin for integration purpose.', 'cbxwpsimpleaccounting');
								    }
								} else {
									$noteice_type = 'error';
									$notice_text  = esc_html__('Sorry, Category not found or requested category doesn\'t exists!', 'cbxwpsimpleaccounting');
								}

							?>
							<?php if ($notice_text != ''): ?>
                                <div class="notice notice-<?php echo esc_html($noteice_type); ?> inline">
                                    <p><?php echo esc_html($notice_text); ?></p>
                                </div>
							<?php endif; ?>
                            <?php  if($cat_found): ?>
                                <table class="form-table">
                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label class="cbacnt-cat cbacnt-label"
                                                   for="cbacnt-cat-title">#<?php esc_html_e('ID', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td>
											<?php
												echo (isset($cat_data['id']) && intval($cat_data['id']) > 0)? intval($cat_data['id']) : '';
											?>

                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label class="cbacnt-cat cbacnt-label"
                                                   for="cbacnt-cat-title"><?php esc_html_e('Title', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td>
                                            <?php
                                            echo (isset($cat_data['title']) && $cat_data['title'] != '')? esc_html(stripcslashes($cat_data['title'])) : '';
                                            ?>
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label class="cbacnt-cat cbacnt-label"
                                                   for="cbacnt-cat-type"><?php esc_html_e('Type', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td>
                                            <?php echo (intval($cat_data['type']) == 1) ? esc_html__('Income', 'cbxwpsimpleaccounting') : esc_html__('Expense', 'cbxwpsimpleaccounting'); ?>
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label class="cbacnt-cat cbacnt-label"
                                                   for="cbacnt-cat-color"><?php esc_html_e('Color', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td>
											<?php
												$color =  (isset($cat_data['color']) && $cat_data['color'] != '')? $cat_data['color']: '';
                                                if($color != ''){
												    echo '<span style="background-color: '.$color.';  padding: 5px;">'.$color.'</span>';
                                                }
											?>

                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label class="cbacnt-cat cbacnt-label"
                                                   for="cbacnt-cat-type"><?php esc_html_e('Published', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td>
											<?php $status = intval($cat_data['publish']);

												$states_list = array(
													'0' => esc_html__('Yes', 'cbxwpsimpleaccounting'),
													'1' => esc_html__('No', 'cbxwpsimpleaccounting'),
												);


												echo isset($states_list[$status])? $states_list[$status]: esc_html__('N/A', 'cbxwpsimpleaccounting');
                                            ?>
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label class="cbacnt-cat cbacnt-label"
                                                   for="cbacnt-cat-type"><?php esc_html_e('Created By', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td>
                                            <?php echo  '<a target="_blank" href="'. get_edit_user_link($cat_data['add_by']).'">' . stripslashes(get_user_by('id', $cat_data['add_by'])->display_name) . '</a>'; ?>
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label class="cbacnt-cat cbacnt-label"
                                                   for="cbacnt-cat-type"><?php esc_html_e('Create Date', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td>
											<?php echo  $cat_data['add_date']; ?>
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label class="cbacnt-cat cbacnt-label"
                                                   for="cbacnt-cat-type"><?php esc_html_e('Modified By', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td>
											<?php if ($cat_data['mod_by']) {
												echo '<a href="' . get_edit_user_link($cat_data['mod_by']) . '">' . stripslashes(get_user_by('id', $cat_data['mod_by'])->display_name) . '</a>';
											}
											else{
												echo  esc_html__('N/A', 'cbxwpsimpleaccounting');
											}
											?>

                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label class="cbacnt-cat cbacnt-label"
                                                   for="cbacnt-cat-type"><?php esc_html_e('Modify Date', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td>
											<?php echo  ($cat_data['mod_date'] == '' || $cat_data['mod_date'] == null)? esc_html__('N/A', 'cbxwpsimpleaccounting') : $cat_data['mod_date']; ?>
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <th class="row-title" scope="row">
                                            <label class="cbacnt-cat cbacnt-label"
                                                   for="cbacnt-cat-note"><?php esc_html_e('Note', 'cbxwpsimpleaccounting'); ?></label>
                                        </th>
                                        <td>
                                            <p>
												<?php
													echo (isset($cat_data['note']) && $cat_data['note'] != '')? esc_html(stripcslashes($cat_data['note'])): ''
												?>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            <?php endif; ?>

                        </div> <!-- .inside -->
                    </div> <!-- .postbox -->

                </div> <!-- .meta-box-sortables .ui-sortable -->
            </div> <!-- post-body-content -->
			<?php
				//include('sidebar.php');
			?>
        </div> <!-- #post-body .metabox-holder .columns-2 -->
		<div class="clear"></div>
    </div> <!-- #poststuff -->
</div> <!-- .wrap -->