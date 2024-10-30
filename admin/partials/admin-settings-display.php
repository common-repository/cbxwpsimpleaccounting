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
    <h1 class="wp-heading-inline wp-heading-inline-settings"><?php esc_html_e('CBX Accounting: Setting', 'cbxwpsimpleaccounting'); ?></h1>
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <!-- main content -->
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <div class="postbox">
                        <div class="inside">
                            <?php
                                $this->settings_api->show_navigation();
                                $this->settings_api->show_forms();
                            ?>
                        </div> <!-- .inside -->
                    </div> <!-- .postbox -->
                </div> <!-- .meta-box-sortables .ui-sortable -->
            </div> <!-- post-body-content -->
            <?php
                include('sidebar.php');
            ?>

        </div> <!-- #post-body .metabox-holder .columns-2 -->
		<div class="clear clearfix"></div>
    </div> <!-- #poststuff -->
</div> <!-- .wrap -->