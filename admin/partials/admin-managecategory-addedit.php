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
    <h1 class="wp-heading-inline wp-heading-inline-catedit"><?php esc_html_e('CBX Accounting: add/Edit Category', 'cbxwpsimpleaccounting'); ?></h1>
    <p>
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=cbxwpsimpleaccounting_cat' ) ); ?>"
           class="button button-primary" role="button"><?php esc_html_e( 'Go Back to Category Manager', 'cbxwpsimpleaccounting' ) ?></a>
	    <?php echo '<a class="button" href="'.admin_url('admin.php?page=cbxwpsimpleaccounting_cat&view=addedit').'">'.esc_attr__('Add New Category', 'cbxwpsimpleaccounting').'</a>'; ?>
    </p>

	<?php


	if(isset($_SESSION['cbxwpsimpleaccounting_cat_addedit_error'])){
		$validation = $_SESSION['cbxwpsimpleaccounting_cat_addedit_error'];


		$error_class = (isset($validation['error']) && intval($validation['error']) == 1) ? 'notice notice-error': 'notice notice-success';

		if(isset($validation['msg'])){
			echo '<div class="'.esc_attr($error_class).'"><p>'.$validation['msg'].'</p></div>';
		}

		unset($_SESSION['cbxwpsimpleaccounting_cat_addedit_error']);
	}




	?>
    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-1">

            <!-- main content -->
            <div id="post-body-content">
                <div id="cbxaccounting_catmanager" class="meta-box-sortables ui-sortable">

                    <div class="postbox">
                        <h3><span><?php esc_html_e('Add/Edit Category', 'cbxwpsimpleaccounting'); ?></span></h3>
                        <div class="inside">
                            <div id="cbxwpsimpleaccounting">
                                <form id="cbacnt-cat-form" class="form-horizontal" action="index.php" method="post">
                                    <!--<div class="cbacnt-msg-box below-h2 hidden"><p class="cbacnt-msg-text"></p></div>-->
                                    <input name="id" id="catid" type="hidden" value="<?php echo isset($cat_data['id']) ? absint($cat_data['id']) : 0; ?>" />
									<?php wp_nonce_field('add_new_expinc_cat', 'new_cat_verifier'); ?>

                                    <div class="form-group">
                                        <label for="cattitle" class="col-sm-2 control-label"><?php esc_html_e('Title', 'cbxwpsimpleaccounting'); ?></label>
                                        <div class="col-sm-10 error_container">
                                            <input type="text" class="form-control" name="title" id="cattitle" placeholder="<?php esc_html_e('Title', 'cbxwpsimpleaccounting'); ?>" value="<?php echo isset($cat_data['title']) ? stripslashes(esc_attr($cat_data['title'])) : ''; ?>" data-rule-required="true"  data-rule-minlength="5" data-rule-maxlength="200" autofocus />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"><?php esc_html_e('Category Type', 'cbxwpsimpleaccounting'); ?></label>
                                        <div class="col-sm-10 error_container">
                                            <label for="cattytpe-1" class="radio-inline"> <input type="radio" name="type" id="cattytpe-1"  value="1" required <?php echo isset($cat_data['type']) ? checked($cat_data['type'], 1, false) : ' checked="checked" '; ?>> <?php esc_html_e('Income', 'cbxwpsimpleaccounting'); ?> </label>
                                            <label for="cattytpe-2" class="radio-inline"> <input type="radio" name="type" id="cattytpe-2"  value="2" required <?php echo isset($cat_data['type']) ? checked($cat_data['type'], 2, false) : ' '; ?> > <?php esc_html_e('Expense', 'cbxwpsimpleaccounting'); ?> </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="catcolor" class="col-sm-2 control-label"><?php esc_html_e('Category Color', 'cbxwpsimpleaccounting'); ?></label>
                                        <div class="col-sm-10 error_container">
                                            <input  name="color" id="catcolor" type="text" value="<?php echo isset($cat_data['color']) ? $cat_data['color'] : '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT); ?>" class="conent-box-sizing catcolor-picker" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="catnote" class="col-sm-2 control-label"><?php esc_html_e('Category Note', 'cbxwpsimpleaccounting'); ?></label>
                                        <div class="col-sm-10 error_container">
                                            <textarea id="catnote" class="form-control" name="note" rows="3" cols="50" rows="6"   data-rule-minlength="10" data-rule-maxlength="2000"><?php echo isset($cat_data['note']) ? wp_unslash(esc_html($cat_data['note'])) : ''; ?></textarea></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-10">
                                            <input type="hidden" name="cbxwpsimpleaccounting_cat_addedit" value="1" />
                                            <button id="catsubmit" type="submit" class="btn btn-default btn-primary"><?php echo (isset($cat_data['id'])  && intval($cat_data['id']) > 0 )? esc_html__('Update category', 'cbxwpsimpleaccounting') : esc_html__('Add new category', 'cbxwpsimpleaccounting'); ?></button>
                                        </div>
                                    </div>
                                </form>
                                <div class="clearfix"></div>
                            </div>
                        </div> <!-- .inside -->
                    </div> <!-- .postbox -->

                </div> <!-- .meta-box-sortables .ui-sortable -->
            </div> <!-- post-body-content -->
            <?php
            //include('sidebar.php');
            ?>
        </div>
		<div class="clear clearfix"></div>
    </div> <!-- #poststuff -->
</div> <!-- .wrap -->