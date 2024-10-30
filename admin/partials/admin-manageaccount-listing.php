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
    $account_list = new CBXWpsimpleaccountingAccListTable($this->settings_api);

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <div id="cbxaccountingloading" style="display:none"></div>
    <h1 class="wp-heading-inline wp-heading-inline-account-list"><?php esc_html_e('CBX Accounting: Manage Bank Accounts', 'cbxwpsimpleaccounting'); ?></h1>
    <p><?php echo '<a class="button-primary" href="' . admin_url('admin.php?page=cbxwpsimpleaccounting_accmanager&view=addedit') . '">' . esc_attr__('Add New Account', 'cbxwpsimpleaccounting') . '</a>'; ?></p>

    <?php
        //$category_list->process_bulk_action();
        $account_list->prepare_items();

	    if(isset($_SESSION['cbxwpsimpleaccounting_accounts_bulkdelete'])){
		    $validations = $_SESSION['cbxwpsimpleaccounting_accounts_bulkdelete'];
		    if(is_array($validations) && sizeof($validations) > 0){
			    foreach ($validations as $validation){
				    $error_class = (isset($validation['error']) && intval($validation['error']) == 1) ? 'notice notice-error': 'notice notice-success';

				    if(isset($validation['msg'])){
					    echo '<div class="'.esc_attr($error_class).'"><p>'.$validation['msg'].'</p></div>';
				    }
			    }
		    }


		    unset($_SESSION['cbxwpsimpleaccounting_accounts_bulkdelete']);
	    }
    ?>
    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-1">

            <!-- main content -->
            <div id="post-body-content">
                <div id="cbxaccounting_accmanager" class="meta-box-sortables ui-sortable">

                    <div class="postbox">
                        <div class="inside">
                            <?php $account_list->views(); ?>
                            <form id="cbxwpsimpleaccounting_acclisting" method="post" class="form-inline">
                                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                                <?php $account_list->search_box(esc_html__('Search Account', 'cbxwpsimpleaccounting'), 'accsearch'); ?>
                                <?php $account_list->display() ?>
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
