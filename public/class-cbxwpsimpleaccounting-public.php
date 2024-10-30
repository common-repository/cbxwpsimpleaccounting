<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://codeboxr.com
 * @since      1.0.0
 *
 * @package    CBXWPSimpleAccounting
 * @subpackage CBXWPSimpleAccounting/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    CBXWPSimpleAccounting
 * @subpackage CBXWPSimpleAccounting/public
 * @author     Codeboxr <info@codeboxr.com>
 */
class CBXWPSimpleAccounting_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $cbxwpsimpleaccounting    The ID of this plugin.
	 */
	private $cbxwpsimpleaccounting;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $cbxwpsimpleaccounting       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $cbxwpsimpleaccounting, $version ) {

		$this->cbxwpsimpleaccounting = $cbxwpsimpleaccounting;
		$this->version = $version;

	}//end method constructor

}//end class CBXWPSimpleAccounting_Public
