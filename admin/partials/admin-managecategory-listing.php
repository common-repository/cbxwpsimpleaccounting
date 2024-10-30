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

	global $wpdb;
	$category_list = new CBXWpsimpleaccountingCatListTable($this->settings_api);


?>
    
<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <div id="cbxaccountingloading" style="display:none"></div>
    <h1 class="wp-heading-inline wp-heading-inline-catlist"><?php esc_html_e('CBX Accounting: Manage Category', 'cbxwpsimpleaccounting'); ?></h1>
    <p><?php echo '<a class="button button-primary" href="'.admin_url('admin.php?page=cbxwpsimpleaccounting_cat&view=addedit').'">'.esc_attr__('Add New Category', 'cbxwpsimpleaccounting').'</a>'; ?></p>

	<?php

		$category_list->prepare_items();

		if(isset($_SESSION['cbxwpsimpleaccounting_cats_bulkdelete'])){
			$validations = $_SESSION['cbxwpsimpleaccounting_cats_bulkdelete'];
			if(is_array($validations) && sizeof($validations) > 0){
				foreach ($validations as $validation){
					$error_class = (isset($validation['error']) && intval($validation['error']) == 1) ? 'notice notice-error': 'notice notice-success';

					if(isset($validation['msg'])){
						echo '<div class="'.esc_attr($error_class).'"><p>'.$validation['msg'].'</p></div>';
					}
				}
			}


			unset($_SESSION['cbxwpsimpleaccounting_cats_bulkdelete']);
		}
	?>
    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-1">

            <!-- main content -->
            <div id="post-body-content">
                <div id="cbxaccounting_catmanager" class="meta-box-sortables ui-sortable">

                    <div class="postbox">
                        <!--<h3><span><?php /*esc_html_e('Add/Edit Category', $this->cbxwpsimpleaccounting); */?></span></h3>-->
                        <div class="inside">
							<?php $category_list->views(); ?>
                            <form id="cbxwpsimpleaccounting_catlisting" method="post" class="form-inline">
                                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
								<?php $category_list->search_box(esc_html__('Search Category', 'cbxwpsimpleaccounting'), 'catsearch'); ?>
								<?php $category_list->display() ?>
                            </form>
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
