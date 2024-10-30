<?php
	/**
	 * Provide a dashboard view for the all the addons of this plugin
	 *
	 *
	 * @link       https://codeboxr.com
	 * @since      1.0.0
	 *
	 * @package    Cbxwpsimpleaccounting
	 * @subpackage Cbxwpsimpleaccounting/admin/partials
	 */
	if ( ! defined( 'WPINC' ) )
	{
		die;
	}
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php

	//check statement addon activation status
	$cbxwpsimpleaccountingstatement = $this->get_plugin_status( 'cbxwpsimpleaccountingstatement/cbxwpsimpleaccountingstatement.php' );

	//check vendor and client addon activation status
	$cbxwpsimpleaccountingvc = $this->get_plugin_status( 'cbxwpsimpleaccountingvc/cbxwpsimpleaccountingvc.php' );

	//check woocommerce addon activation status
	$cbxwpsimpleaccountingwoo = $this->get_plugin_status( 'cbxwpsimpleaccountingwoo/cbxwpsimpleaccountingwoo.php' );

	//check woocommerce addon activation status
	$cbxwpsimpleaccountingfrontend = $this->get_plugin_status( 'cbxwpsimpleaccountingfrontend/cbxwpsimpleaccountingfrontend.php' );
?>
<div class="wrap">
    <h1 class="wp-heading-inline wp-heading-inline-addon"><?php esc_html_e( 'CBX Accounting: Free & Pro Add-ons', 'cbxwpsimpleaccounting' ); ?></h1>
    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-2">
            <!-- main content -->
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <div class="postbox">
                        <div class="inside">
							<?php
								$log_addon_thumb        = $cbxaccount_admin_url . 'assets/images/addon-log.png';
								$income_statement_thumb = $cbxaccount_admin_url . 'assets/images/addon-statement.png';
								$vendor_thumb           = $cbxaccount_admin_url . 'assets/images/addon-vendor-client.png';
								$woo_thumb              = $cbxaccount_admin_url . 'assets/images/woocommerce-plugin.png';
								$frontend_thumb         = $cbxaccount_admin_url . 'assets/images/addon-frontend.png';
								$idea_thumb = $cbxaccount_admin_url . 'assets/images/idea.png';
							?>
                            <div class="cbxwpaccounting_addon">
                                <a href="https://codeboxr.com/product/vendor-and-client-addon-for-cbx-accounting/?utm_source=cbxwpsimpleaccounting&utm_medium=website&utm_campaign=cbxwpsimpleaccounting&utm_term=cbxwpsimpleaccounting"
                                   target="_blank"><img src="<?php echo esc_url($vendor_thumb); ?>"
                                                        alt="Vendors and Client addon for CBX Accounting"></a>
                                <p class="cbxwpaccounting_addonstatus"><a
                                            href="https://codeboxr.com/product/vendor-and-client-addon-for-cbx-accounting/?utm_source=cbxwpsimpleaccounting&utm_medium=website&utm_campaign=cbxwpsimpleaccounting&utm_term=cbxwpsimpleaccounting"
                                            class="<?php echo $cbxwpsimpleaccountingvc['btnclass'] ?>"><?php echo $cbxwpsimpleaccountingvc['msg']; ?></a>
                                </p>
                            </div>
                            <div class="cbxwpaccounting_addon">
                                <a href="https://codeboxr.com/product/log-manager-addon-for-cbx-accounting/?utm_source=cbxwpsimpleaccounting&utm_medium=website&utm_campaign=cbxwpsimpleaccounting&utm_term=cbxwpsimpleaccounting"
                                   target="_blank"><img src="<?php echo esc_url($log_addon_thumb); ?>" alt="Log addon for CBX Accounting" /></a>
                                <p class="cbxwpaccounting_addonstatus" style="text-align: center;">
									<a href="#" class="button button-secondary" disabled=""><?php esc_html_e('Merged with Core', 'cbxwpsimpleaccounting'); ?></a>
                                </p>
                            </div>
                            <div class="cbxwpaccounting_addon">
                                <a href="https://codeboxr.com/product/statement-addon-for-cbx-accounting/?utm_source=cbxwpsimpleaccounting&utm_medium=website&utm_campaign=cbxwpsimpleaccounting&utm_term=cbxwpsimpleaccounting"
                                   target="_blank"><img src="<?php echo esc_url($income_statement_thumb); ?>"
                                                        alt="Statement addon for CBX Accounting"></a>
                                <p class="cbxwpaccounting_addonstatus"><a
                                            href="https://codeboxr.com/product/statement-addon-for-cbx-accounting/?utm_source=cbxwpsimpleaccounting&utm_medium=website&utm_campaign=cbxwpsimpleaccounting&utm_term=cbxwpsimpleaccounting"
                                            class="<?php echo $cbxwpsimpleaccountingstatement['btnclass'] ?>"><?php echo $cbxwpsimpleaccountingstatement['msg']; ?></a>
                                </p>
                            </div>

                            <div class="cbxwpaccounting_addon">
                                <a href="https://codeboxr.com/product/woocommerce-addon-for-cbx-accounting/?utm_source=cbxwpsimpleaccounting&utm_medium=website&utm_campaign=cbxwpsimpleaccounting&utm_term=cbxwpsimpleaccounting"
                                   target="_blank"><img src="<?php echo esc_url($woo_thumb); ?>" alt="Woocommerce Addon for CBX Accounting"></a>
                                <p class="cbxwpaccounting_addonstatus"><a
                                            href="https://codeboxr.com/product/woocommerce-addon-for-cbx-accounting/?utm_source=cbxwpsimpleaccounting&utm_medium=website&utm_campaign=cbxwpsimpleaccounting&utm_term=cbxwpsimpleaccounting"
                                            class="<?php echo $cbxwpsimpleaccountingwoo['btnclass'] ?>"><?php echo $cbxwpsimpleaccountingwoo['msg']; ?></a>
                                </p>
                            </div>
                            <div class="cbxwpaccounting_addon">
                                <a href="https://codeboxr.com/product/frontend-addon-for-cbx-accounting/?utm_source=cbxwpsimpleaccounting&utm_medium=website&utm_campaign=cbxwpsimpleaccounting&utm_term=cbxwpsimpleaccounting"
                                   target="_blank"><img src="<?php echo esc_url($frontend_thumb); ?>" alt="Frontend Addon for CBX Accounting"></a>
                                <p class="cbxwpaccounting_addonstatus"><a
                                            href="https://codeboxr.com/product/frontend-addon-for-cbx-accounting/?utm_source=cbxwpsimpleaccounting&utm_medium=website&utm_campaign=cbxwpsimpleaccounting&utm_term=cbxwpsimpleaccounting"
                                            class="<?php echo $cbxwpsimpleaccountingfrontend['btnclass'] ?>"><?php echo $cbxwpsimpleaccountingfrontend['msg']; ?></a>
                                </p>
                            </div>
                            <div class="cbxwpaccounting_addon">
                                <a href="https://codeboxr.com/contact-us/?utm_source=cbxwpsimpleaccounting&utm_medium=website&utm_campaign=cbxwpsimpleaccounting&utm_term=cbxwpsimpleaccounting"
                                   target="_blank"><img src="<?php echo esc_url($idea_thumb); ?>" alt="income-statement"></a>
                            </div>
                            <div class="cbxclearfix"></div>
                        </div> <!-- .inside -->
                    </div> <!-- .postbox -->
                </div> <!-- .meta-box-sortables .ui-sortable -->
            </div> <!-- post-body-content -->
			<?php
				include( 'sidebar.php' );
			?>
        </div> <!-- #post-body .metabox-holder .columns-2 -->
		<div class="clear"></div>
    </div> <!-- #poststuff -->
</div><!-- .wrap -->