<?php
if ( ! defined( 'WPINC' ) ) {
    die;
}
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <div id="cbxaccountingloading" style="display:none"></div>
    <h1 class="wp-heading-inline wp-heading-inline-lognotfound"><?php esc_html_e( 'CBX Accounting: Log not found', 'cbxwpsimpleaccounting' ); ?></h1>
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <!-- main content -->
            <div id="post-body-content">
                <div id="cbxaccounting_addexpinc" class="meta-box-sortables ui-sortable">
                    <div class="postbox">

                        <h3><span><?php esc_html_e( 'Error loading log', 'cbxwpsimpleaccounting' ); ?></span></h3>
                        <div class="inside">
                            <div id="cbxwpsimpleaccounting">
                                <div class="alert alert-warning" role="alert">
									<h4><?php esc_html_e('Possible Reasons:', 'cbxwpsimpleaccounting'); ?></h4>
									<ul>
										<li><?php esc_html_e( 'The log was not found.', 'cbxwpsimpleaccounting' ); ?></li>
										<li><?php esc_html_e( 'You are not allowed to edit.', 'cbxwpsimpleaccounting' ); ?></li>
										<li><?php esc_html_e( 'Log is restricted and not allowed to edit.', 'cbxwpsimpleaccounting' ); ?></li>
									</ul>
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
            include( 'sidebar.php' );

            ?>
        </div>
        <div class="clear"></div>
    </div>
</div>