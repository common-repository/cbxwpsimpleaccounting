<?php

/**
 * Fired during plugin uninstall
 *
 * @link       https://codeboxr.com
 * @since      1.0.0
 *
 * @package    Cbxwpsimpleaccounting
 * @subpackage Cbxwpsimpleaccounting/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Cbxwpsimpleaccounting
 * @subpackage Cbxwpsimpleaccounting/includes
 * @author     Codeboxr <info@codeboxr.com>
 */
class Cbxwpsimpleaccounting_Uninstall {

	/**
	 * remove all created database and option value
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function uninstall() {
		global $wpdb;

		$settings = new CBXWPSimpleaccounting_Settings_API();

		$delete_global_config = $settings->get_option('delete_global_config', 'cbxwpsimpleaccounting_tools', 'no');

		if ($delete_global_config == 'yes') {
			$option_prefix = 'cbxwpsimpleaccounting_';

			//delete plugin global options


			$accounting_option_values = CBXWpsimpleaccountingHelper::getAllOptionNames();

			foreach ($accounting_option_values as $accounting_option_value ){
				$option_name = $accounting_option_value['option_name'];
				delete_option($option_name);
			}

			//delete tables created by this plugin
			$table_names = CBXWpsimpleaccountingHelper::getAllDBTablesList();

			$sql = "DROP TABLE IF EXISTS " . implode(', ', array_values($table_names));
			$query_result = $wpdb->query($sql);

			do_action('cbxwpsimpleaccounting_plugin_deactivation', $table_names, $option_prefix);

		}
	}//end method uninstall
}//end class Cbxwpsimpleaccounting_Uninstall