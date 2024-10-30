<?php
    /**
     * @link              https://codeboxr.com
     * @since             1.0.0
     * @package           Cbxwpsimpleaccounting
     *
     * @wordpress-plugin
     * Plugin Name:       CBX Accounting & Bookkeeping
     * Plugin URI:        https://codeboxr.com/product/cbx-accounting/
     * Description:       Accounting solution inside WordPress for SME businness
     * Version:           1.3.14
     * Author:            Codeboxr
     * Author URI:        https://codeboxr.com
     * License:           GPL-2.0+
     * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
     * Text Domain:       cbxwpsimpleaccounting
     * Domain Path:       /languages
     */

// If this file is called directly, abort.
    if (!defined('WPINC')) {
        die;
    }

    defined('CBXWPSIMPLEACCOUNTING_PLUGIN_NAME') or define('CBXWPSIMPLEACCOUNTING_PLUGIN_NAME', 'cbxwpsimpleaccounting');
    defined('CBXWPSIMPLEACCOUNTING_PLUGIN_VERSION') or define('CBXWPSIMPLEACCOUNTING_PLUGIN_VERSION', '1.3.14');
    defined('CBXWPSIMPLEACCOUNTING_BASE_NAME') or define('CBXWPSIMPLEACCOUNTING_BASE_NAME', plugin_basename(__FILE__));
    defined('CBXWPSIMPLEACCOUNTING_ROOT_PATH') or define('CBXWPSIMPLEACCOUNTING_ROOT_PATH', plugin_dir_path(__FILE__));
    defined('CBXWPSIMPLEACCOUNTING_ROOT_URL') or define('CBXWPSIMPLEACCOUNTING_ROOT_URL', plugin_dir_url(__FILE__));


	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-cbxwpsimpleaccounting-activator.php
	 */
	function activate_cbxwpsimpleaccounting()
	{
		require_once plugin_dir_path(__FILE__) . 'includes/class-cbxwpsimpleaccounting-activator.php';
		Cbxwpsimpleaccounting_Activator::activate();
	}


	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-cbxwpsimpleaccounting-uninstall.php
	 */
	function deactivate_cbxwpsimpleaccounting()
	{
		require_once plugin_dir_path(__FILE__) . 'includes/class-cbxwpsimpleaccounting-deactivator.php';
		Cbxwpsimpleaccounting_Deactivator::deactivate();
	}


	/**
	 * The code that runs during plugin uninstalling
	 * This action is documented in includes/class-cbxwpsimpleaccounting-deactivator.php
	 */
	function uninstall_cbxwpsimpleaccounting()
	{
		require_once plugin_dir_path(__FILE__) . 'includes/class-cbxwpsimpleaccounting-uninstall.php';
		Cbxwpsimpleaccounting_Uninstall::uninstall();
	}


	register_activation_hook(__FILE__, 'activate_cbxwpsimpleaccounting');
	register_deactivation_hook(__FILE__, 'deactivate_cbxwpsimpleaccounting');
	register_uninstall_hook(__FILE__, 'uninstall_cbxwpsimpleaccounting');


    require_once(plugin_dir_path(__FILE__) . 'includes/class-cbxwpsimpleaccounting-helper.php');

    /**
     * The core plugin class that is used to define internationalization,
     * dashboard-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path(__FILE__) . 'includes/class-cbxwpsimpleaccounting.php';

    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    1.0.0
     */
    function run_cbxwpsimpleaccounting()
    {

        $plugin = new Cbxwpsimpleaccounting();
        $plugin->run();


    }

    run_cbxwpsimpleaccounting();