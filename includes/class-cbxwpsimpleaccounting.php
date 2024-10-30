<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       https://codeboxr.com
 * @since      1.0.0
 *
 * @package    CBXWPSimpleaccounting
 * @subpackage CBXWPSimpleaccounting/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    CBXWPSimpleaccounting
 * @subpackage CBXWPSimpleaccounting/includes
 * @author     Codeboxr <info@codeboxr.com>
 */
class CBXWPSimpleaccounting {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Cbxwpsimpleaccounting_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $cbxwpsimpleaccounting    The string used to uniquely identify this plugin.
     */
    protected $cbxwpsimpleaccounting;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the Dashboard and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {

        $this->cbxwpsimpleaccounting = CBXWPSIMPLEACCOUNTING_PLUGIN_NAME;
        $this->version               = CBXWPSIMPLEACCOUNTING_PLUGIN_VERSION;

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - CBXWPSimpleaccounting_Loader. Orchestrates the hooks of the plugin.
     * - CBXWPSimpleaccounting_i18n. Defines internationalization functionality.
     * - CBXWPSimpleaccounting_Admin. Defines all hooks for the dashboard.
     * - CBXWPSimpleaccounting_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-cbxwpsimpleaccounting-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-cbxwpsimpleaccounting-i18n.php';

        /**
         * The class responsible for defining settings functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-cbxwpsimpleaccounting-setting.php';


        /**
         * The class responsible for defining all actions that occur in the Dashboard.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-cbxwpsimpleaccounting-admin.php';



        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-cbxwpsimpleaccounting-public.php';



        $this->loader = new Cbxwpsimpleaccounting_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Cbxwpsimpleaccounting_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new Cbxwpsimpleaccounting_i18n();
        $plugin_i18n->set_domain($this->get_cbxwpsimpleaccounting());

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the dashboard functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {

        $plugin_admin = new CBXWPSimpleAccounting_Admin($this->get_cbxwpsimpleaccounting(), $this->get_version());



	    //$this->loader->add_action('template_redirect', $plugin_admin,'start_session', 1);
	    $this->loader->add_action('init', $plugin_admin,'start_session', 1);
	    $this->loader->add_action('wp_logout', $plugin_admin,'session_logout');

        //adding the setting action
        $this->loader->add_action('admin_init', $plugin_admin, 'setting_init');

	    //Add admin menu action hook
	    $this->loader->add_action('admin_menu', $plugin_admin, 'admin_menus');


	    //set screen option for result listing page
	    $this->loader->add_filter('set-screen-option', $plugin_admin, 'set_screen_option_cats', 10, 3 );
	    $this->loader->add_filter('set-screen-option', $plugin_admin, 'set_screen_option_accounts', 10, 3 );
	    $this->loader->add_filter('set-screen-option', $plugin_admin, 'set_screen_option_logs', 10, 3);


	    $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
	    $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');



	    //before the header load to check any request to execute or not!
	    if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'cbxwpsimpleaccounting_settings' && isset($_REQUEST['cbxwpsimpleaccounting_fullreset']) && $_REQUEST['cbxwpsimpleaccounting_fullreset'] == 1) {
		    $this->loader->add_action('admin_init', $plugin_admin, 'cbxwpsimpleaccounting_plugin_fullreset');
	    }

	   //accounts export request
	    if (isset($_REQUEST['cbxwpsimpleaccounting_accounts_export']) && isset($_REQUEST['format'])) {
			$this->loader->add_action('admin_init', $plugin_admin, 'cbxwpsimpleaccounting_accounts_export');
	    }

	    //log export request
	    if (isset($_REQUEST['cbxwpsimpleaccounting_log_export']) && isset($_REQUEST['format'])) {
		    $this->loader->add_action('admin_init', $plugin_admin, 'cbxwpsimpleaccounting_log_export');
	    }

        //for support link
        $this->loader->add_filter('plugin_row_meta', $plugin_admin, 'support_link', 10, 2);
        //for overview edit link permission filter
        $this->loader->add_filter('cbxwpsimpleaccounting_title_link', $plugin_admin, 'overview_title_link', 10, 2);


		$this->loader->add_filter('plugin_action_links_' . CBXWPSIMPLEACCOUNTING_BASE_NAME, $plugin_admin, 'add_plugin_admin_page');

		//load next prev year data
		$this->loader->add_action('wp_ajax_load_nextprev_year', $plugin_admin, 'load_nextprev_year');
		//load next prev month data
		$this->loader->add_action('wp_ajax_load_nextprev_month', $plugin_admin, 'load_nextprev_month');
		//add new expense or income
		//$this->loader->add_action('wp_ajax_add_new_expinc', $plugin_admin, 'add_new_expinc');
		//load/edit expense or income info by id
		//$this->loader->add_action('wp_ajax_load_expinc', $plugin_admin, 'load_expinc');

		//delete any expinc
		$this->loader->add_action('wp_ajax_delete_expinc', $plugin_admin, 'delete_expinc'); //from overview page
	    $this->loader->add_action('wp_ajax_delete_expinc_log', $plugin_admin, 'delete_expinc'); //from log manager page
	    $this->loader->add_action('cbxwpsimpleaccounting_log_delete_after', $plugin_admin, 'delete_expinc_attachments');

		$this->loader->add_action('admin_init', $plugin_admin, 'add_edit_expinc');
		$this->loader->add_action('admin_init', $plugin_admin, 'add_edit_category');
		$this->loader->add_action('admin_init', $plugin_admin, 'add_edit_account');

		//new account manager
		$this->loader->add_action('wp_ajax_add_new_manager_acc', $plugin_admin, 'add_new_manager_acc');

		//load/edit manager by id
		$this->loader->add_action('wp_ajax_load_account', $plugin_admin, 'load_account');

	    //load/edit manager by id
	    $this->loader->add_action('wp_ajax_default_category_create', $plugin_admin, 'ajax_default_category_create');

	    //filter for adding link in overview page
	    $this->loader->add_filter('cbxwpsimpleaccounting_catlog_link', $plugin_admin, 'cbxwpsimpleaccountinglog_cat_link', 10, 4);
	    $this->loader->add_filter('cbxwpsimpleaccounting_accountlog_link', $plugin_admin, 'cbxwpsimpleaccountinglog_account_link', 10, 3);

	    //attachment related hooks
	    $this->loader->add_action('wp_ajax_cbxwpsimpleaccounting_add_attachments', $plugin_admin, 'cbxwpsimpleaccounting_add_attachments'); //add files
	    $this->loader->add_action('wp_ajax_cbxwpsimpleaccounting_list_attachments', $plugin_admin, 'cbxwpsimpleaccounting_list_attachments'); //list files
	    $this->loader->add_action('wp_ajax_cbxwpsimpleaccounting_delete_attachments', $plugin_admin, 'cbxwpsimpleaccounting_delete_attachments'); //delete
	    $this->loader->add_action('wp_ajax_cbxwpsimpleaccounting_download_attachments', $plugin_admin, 'cbxwpsimpleaccounting_download_attachments'); //download


	    //update manager
	    $this->loader->add_action( 'upgrader_process_complete', $plugin_admin, 'plugin_upgrader_process_complete', 10, 2 );
	    $this->loader->add_action( 'admin_notices', $plugin_admin, 'plugin_activate_upgrade_notices' );

	    $this->loader->add_filter('pre_set_site_transient_update_plugins', $plugin_admin, 'pre_set_site_transient_update_plugins_frontend_addon');
	    $this->loader->add_filter('pre_set_site_transient_update_plugins', $plugin_admin, 'pre_set_site_transient_update_plugins_statement_addon');
	    $this->loader->add_filter('pre_set_site_transient_update_plugins', $plugin_admin, 'pre_set_site_transient_update_plugins_woo_addon');
	    $this->loader->add_action( 'in_plugin_update_message-' . 'cbxwpsimpleaccountingfrontend/cbxwpsimpleaccountingfrontend.php', $plugin_admin, 'plugin_update_message_pro_addons' );
	    $this->loader->add_action( 'in_plugin_update_message-' . 'cbxwpsimpleaccountingstatement/cbxwpsimpleaccountingstatement.php', $plugin_admin, 'plugin_update_message_pro_addons' );
	    $this->loader->add_action( 'in_plugin_update_message-' . 'cbxwpsimpleaccountingwoo/cbxwpsimpleaccountingwoo.php', $plugin_admin, 'plugin_update_message_pro_addons' );
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new Cbxwpsimpleaccounting_Public($this->get_cbxwpsimpleaccounting(), $this->get_version());

    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_cbxwpsimpleaccounting() {
        return $this->cbxwpsimpleaccounting;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Cbxwpsimpleaccounting_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

}//end class CBXWPSimpleaccounting
