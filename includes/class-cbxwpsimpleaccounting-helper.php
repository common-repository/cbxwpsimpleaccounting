<?php
if (!defined('WPINC')) {
    die;
}

/**
 * The file that defines the helper plugin class with mostly static methods
 *
 * A class definition that includes helper methods that used in both public and admin end.
 *
 * @link       https://codeboxr.com
 * @since      1.0.0
 *
 * @package    CBXWPSimpleaccounting
 * @subpackage CBXWPSimpleaccounting/includes
 */

/**
 * Class CBXWpsimpleaccountingHelper
 *
 */
class CBXWpsimpleaccountingHelper
{
    /**
     * initialize session
     */
    public static function init_session()
    {
        //if session is not started, let's start it
        /*if ( ! session_id() ) {
            session_start();
        }*/

        if (defined('DOING_CRON')) {
            return;
        }

        if (CBXWpsimpleaccountingHelper::is_rest()) {
            return;
        }

        /**
         * Start sessions if not exists
         *
         * @author     Ivijan-Stefan Stipic <creativform@gmail.com>
         */
        if (version_compare(PHP_VERSION, '7.0.0', '>=')) {
            if (function_exists('session_status') && session_status() == PHP_SESSION_NONE) {
                session_start(array(
                    'cache_limiter' => 'private_no_expire',
                    'read_and_close' => false,
                ));
            }
        } else if (version_compare(PHP_VERSION, '5.4.0', '>=') && version_compare(PHP_VERSION, '7.0.0', '<')) {
            if (function_exists('session_status') && session_status() == PHP_SESSION_NONE) {
                session_cache_limiter('private_no_expire');
                session_start();
            }
        } else {
            if (session_id() == '') {
                if (version_compare(PHP_VERSION, '4.0.0', '>=')) {
                    session_cache_limiter('private_no_expire');
                }
                session_start();
            }
        }

    }//end method

    /**
     * Get month short names
     *
     * @return array
     */
    public static function get_month_short_names()
    {
        $monthnames = array();
        $monthnames[0] = _x('Jan', 'January abbreviation');
        $monthnames[1] = _x('Feb', 'February abbreviation');
        $monthnames[2] = _x('Mar', 'March abbreviation');
        $monthnames[3] = _x('Apr', 'April abbreviation');
        $monthnames[4] = _x('May', 'May abbreviation');
        $monthnames[5] = _x('Jun', 'June abbreviation');
        $monthnames[6] = _x('Jul', 'July abbreviation');
        $monthnames[7] = _x('Aug', 'August abbreviation');
        $monthnames[8] = _x('Sep', 'September abbreviation');
        $monthnames[9] = _x('Oct', 'October abbreviation');
        $monthnames[10] = _x('Nov', 'November abbreviation');
        $monthnames[11] = _x('Dec', 'December abbreviation');

        return $monthnames;
    }//end method getMonthNamesShort

    /**
     * Get month short names(deprecated)
     *
     * @return array
     */
    public static function getMonthNamesShort()
    {
        return CBXWpsimpleaccountingHelper::get_month_short_names();
    }//end method getMonthNamesShort

    /**
     * Get full list of currency codes.
     *
     * @return array
     */
    public static function get_currencies()
    {
        return array_unique(
            apply_filters('cbxwpsimpleaccounting_currencies', array(
                    'AED' => esc_html__('United Arab Emirates Dirham', 'cbxwpsimpleaccounting'),
                    'ARS' => esc_html__('Argentine Peso', 'cbxwpsimpleaccounting'),
                    'AUD' => esc_html__('Australian Dollars', 'cbxwpsimpleaccounting'),
                    'BDT' => esc_html__('Bangladeshi Taka', 'cbxwpsimpleaccounting'),
                    'BRL' => esc_html__('Brazilian Real', 'cbxwpsimpleaccounting'),
                    'BGN' => esc_html__('Bulgarian Lev', 'cbxwpsimpleaccounting'),
                    'CAD' => esc_html__('Canadian Dollars', 'cbxwpsimpleaccounting'),
                    'CLP' => esc_html__('Chilean Peso', 'cbxwpsimpleaccounting'),
                    'CNY' => esc_html__('Chinese Yuan', 'cbxwpsimpleaccounting'),
                    'COP' => esc_html__('Colombian Peso', 'cbxwpsimpleaccounting'),
                    'CZK' => esc_html__('Czech Koruna', 'cbxwpsimpleaccounting'),
                    'DKK' => esc_html__('Danish Krone', 'cbxwpsimpleaccounting'),
                    'DOP' => esc_html__('Dominican Peso', 'cbxwpsimpleaccounting'),
                    'EUR' => esc_html__('Euros', 'cbxwpsimpleaccounting'),
                    'HKD' => esc_html__('Hong Kong Dollar', 'cbxwpsimpleaccounting'),
                    'HRK' => esc_html__('Croatia kuna', 'cbxwpsimpleaccounting'),
                    'HUF' => esc_html__('Hungarian Forint', 'cbxwpsimpleaccounting'),
                    'ISK' => esc_html__('Icelandic krona', 'cbxwpsimpleaccounting'),
                    'IDR' => esc_html__('Indonesia Rupiah', 'cbxwpsimpleaccounting'),
                    'INR' => esc_html__('Indian Rupee', 'cbxwpsimpleaccounting'),
                    'NPR' => esc_html__('Nepali Rupee', 'cbxwpsimpleaccounting'),
                    'ILS' => esc_html__('Israeli Shekel', 'cbxwpsimpleaccounting'),
                    'JPY' => esc_html__('Japanese Yen', 'cbxwpsimpleaccounting'),
                    'KIP' => esc_html__('Lao Kip', 'cbxwpsimpleaccounting'),
                    'KRW' => esc_html__('South Korean Won', 'cbxwpsimpleaccounting'),
                    'MYR' => esc_html__('Malaysian Ringgits', 'cbxwpsimpleaccounting'),
                    'MXN' => esc_html__('Mexican Peso', 'cbxwpsimpleaccounting'),
                    'NGN' => esc_html__('Nigerian Naira', 'cbxwpsimpleaccounting'),
                    'NOK' => esc_html__('Norwegian Krone', 'cbxwpsimpleaccounting'),
                    'NZD' => esc_html__('New Zealand Dollar', 'cbxwpsimpleaccounting'),
                    'PYG' => esc_html__('Paraguayan Guaraní', 'cbxwpsimpleaccounting'),
                    'PHP' => esc_html__('Philippine Pesos', 'cbxwpsimpleaccounting'),
                    'PLN' => esc_html__('Polish Zloty', 'cbxwpsimpleaccounting'),
                    'GBP' => esc_html__('Pounds Sterling', 'cbxwpsimpleaccounting'),
                    'RON' => esc_html__('Romanian Leu', 'cbxwpsimpleaccounting'),
                    'RUB' => esc_html__('Russian Ruble', 'cbxwpsimpleaccounting'),
                    'SGD' => esc_html__('Singapore Dollar', 'cbxwpsimpleaccounting'),
                    'ZAR' => esc_html__('South African rand', 'cbxwpsimpleaccounting'),
                    'SEK' => esc_html__('Swedish Krona', 'cbxwpsimpleaccounting'),
                    'CHF' => esc_html__('Swiss Franc', 'cbxwpsimpleaccounting'),
                    'TWD' => esc_html__('Taiwan New Dollars', 'cbxwpsimpleaccounting'),
                    'THB' => esc_html__('Thai Baht', 'cbxwpsimpleaccounting'),
                    'TRY' => esc_html__('Turkish Lira', 'cbxwpsimpleaccounting'),
                    'UAH' => esc_html__('Ukrainian Hryvnia', 'cbxwpsimpleaccounting'),
                    'USD' => esc_html__('US Dollars', 'cbxwpsimpleaccounting'),
                    'VND' => esc_html__('Vietnamese Dong', 'cbxwpsimpleaccounting'),
                    'EGP' => esc_html__('Egyptian Pound', 'cbxwpsimpleaccounting'),
                    'IRR' => esc_html__('Iranian rial', 'cbxwpsimpleaccounting') //from version
                )
            )
        );
    }//end get_currencies

    /**
     * Get full list of currency codes(deprecated).
     *
     * @return array
     */
    public static function get_cbxwpsimpleaccounting_currencies()
    {
        return CBXWpsimpleaccountingHelper::get_currencies();
    }//end method get_cbxwpsimpleaccounting_currencies


    /**
     * Get Currency name
     *
     * @param $currency
     *
     * @return string
     */
    public static function get_currency_name($currency)
    {
        $currencies = CBXWpsimpleaccountingHelper::get_cbxwpsimpleaccounting_currencies();
        if (isset($currencies[$currency])) {
            return esc_html($currencies[$currency]);
        } else {
            return esc_html__('Unknown Currency', 'cbxwpsimpleaccounting');
        }
    }//end method get_cbxwpsimpleaccounting_currency_name

    /**
     * Get Currency name(deprecated)
     *
     * @param $currency
     *
     * @return string
     */
    public static function get_cbxwpsimpleaccounting_currency_name($currency)
    {
        return CBXWpsimpleaccountingHelper::get_currency_name($currency);
    }//end method get_cbxwpsimpleaccounting_currency_name

    /**
     * default currency
     */
    public static function get_cbxwpsimpleaccounting_currency()
    {
        $settings = new CBXWPSimpleaccounting_Settings_API();
        $currency = sanitize_text_field($settings->get_option('cbxwpsimpleaccounting_currency', 'cbxwpsimpleaccounting_basics', 'USD'));

        return $currency;
    }//end method get_cbxwpsimpleaccounting_currency

    /**
     * Get currency symbol
     *
     * @param string $currency_code
     *
     * @return mixed|void
     */
    public static function get_currency_symbol($currency_code = '')
    {
        if (!$currency_code) {
            $currency_code = CBXWpsimpleaccountingHelper::get_cbxwpsimpleaccounting_currency();
        }

        switch ($currency_code) {
            case 'AED' :
                //$currency_symbol = 'د.إ';
                $currency_symbol = '&#1583;.&#1573;';
                break;
            case 'AUD' :
            case 'ARS' :
            case 'CAD' :
            case 'CLP' :
            case 'COP' :
            case 'HKD' :
            case 'MXN' :
            case 'NZD' :
            case 'SGD' :
            case 'USD' :
                $currency_symbol = '&#36;';
                break;
            case 'BDT':
                //$currency_symbol = '&#2547;&nbsp;';
                $currency_symbol = '&#2547;';
                break;
            case 'BGN' :
                $currency_symbol = '&#1083;&#1074;.';
                break;
            case 'BRL' :
                $currency_symbol = '&#82;&#36;';
                break;
            case 'CHF' :
                $currency_symbol = '&#67;&#72;&#70;';
                break;
            case 'CNY' :
            case 'JPY' :
            case 'RMB' :
                $currency_symbol = '&yen;';
                break;
            case 'CZK' :
                $currency_symbol = '&#75;&#269;';
                break;
            case 'DKK' :
                $currency_symbol = 'DKK';
                break;
            case 'DOP' :
                $currency_symbol = 'RD&#36;';
                break;
            case 'EGP' :
                $currency_symbol = 'EGP';
                break;
            case 'EUR' :
                $currency_symbol = '&euro;';
                //$currency_symbol = chr(128);
                break;
            case 'GBP' :
                $currency_symbol = '&pound;';
                break;
            case 'HRK' :
                $currency_symbol = 'Kn';
                break;
            case 'HUF' :
                $currency_symbol = '&#70;&#116;';
                break;
            case 'IDR' :
                $currency_symbol = 'Rp';
                break;
            case 'ILS' :
                $currency_symbol = '&#8362;';
                break;
            case 'INR' :
                $currency_symbol = 'Rs.';
                break;
            case 'ISK' :
                $currency_symbol = 'Kr.';
                break;
            case 'KIP' :
                $currency_symbol = '&#8365;';
                break;
            case 'KRW' :
                $currency_symbol = '&#8361;';
                break;
            case 'MYR' :
                $currency_symbol = '&#82;&#77;';
                break;
            case 'NGN' :
                $currency_symbol = '&#8358;';
                break;
            case 'NOK' :
                $currency_symbol = '&#107;&#114;';
                break;
            case 'NPR' :
                $currency_symbol = 'Rs.';
                break;
            case 'PHP' :
                $currency_symbol = '&#8369;';
                break;
            case 'PLN' :
                $currency_symbol = '&#122;&#322;';
                break;
            case 'PYG' :
                $currency_symbol = '&#8370;';
                break;
            case 'RON' :
                $currency_symbol = 'lei';
                break;
            case 'RUB' :
                $currency_symbol = '&#1088;&#1091;&#1073;.';
                break;
            case 'SEK' :
                $currency_symbol = '&#107;&#114;';
                break;
            case 'THB' :
                $currency_symbol = '&#3647;';
                break;
            case 'TRY' :
                $currency_symbol = '&#8378;';
                break;
            case 'TWD' :
                $currency_symbol = '&#78;&#84;&#36;';
                break;
            case 'UAH' :
                $currency_symbol = '&#8372;';
                break;
            case 'VND' :
                $currency_symbol = '&#8363;';
                break;
            case 'ZAR' :
                $currency_symbol = '&#82;';
                break;
            case 'IRR' :
                $currency_symbol = '&#65020;';
                break;
            default :
                $currency_symbol = '';
                break;
        }

        return apply_filters('cbxwpsimpleaccounting_currency_symbol', $currency_symbol, $currency_code);
    }//end currency_symbol

    /**
     * Get Currency symbol.(deprecated)
     *
     * @param string $currency (default: '')
     *
     * @return string
     */
    public static function get_cbxwpsimpleaccounting_currency_symbol($currency_code = '')
    {
        return CBXWpsimpleaccountingHelper::get_currency_symbol($currency_code);
    }//end method get_cbxwpsimpleaccounting_currency_symbol


    /**
     * Display formatted value with currency
     *
     * @param $total_number
     * @param $currency_number_decimal
     * @param $currency_decimal_separator
     * @param $currency_thousand_separator
     * @param $currency_position
     * @param $currency_symbol
     *
     * @return string
     */
    public static function format_value($total_number, $currency_number_decimal, $currency_decimal_separator, $currency_thousand_separator, $currency_position, $currency_symbol)
    {

        $total_number = floatval($total_number);

        $negative = $total_number < 0;

        $total_number = floatval($negative ? $total_number * -1 : $total_number);

        $formated_value = number_format($total_number, $currency_number_decimal, $currency_decimal_separator, $currency_thousand_separator);

        switch ($currency_position) {
            case "left":
                $final_formatted_value = $currency_symbol . $formated_value;
                break;
            case "right":
                $final_formatted_value = $formated_value . $currency_symbol;
                break;
            case "left_space":
                $final_formatted_value = $currency_symbol . ' ' . $formated_value;
                break;
            case "right_space":
                $final_formatted_value = $formated_value . ' ' . $currency_symbol;
                break;
            default:
                $final_formatted_value = $currency_symbol . $formated_value;
        }

        $final_formatted_value = ($negative ? '-' : '') . $final_formatted_value;

        return $final_formatted_value;
    }//end method format_value

    /**
     * Display formatted value with currency "Quick method"
     *
     * @param      $total_number
     * @param bool $html_entity_decode_symbol
     *
     * @return string
     */
    public static function format_value_quick($total_number, $html_entity_decode_symbol = false)
    {
        $settings_api = new CBXWPSimpleaccounting_Settings_API();

        $total_number = floatval($total_number);

        $negative = $total_number < 0;
        $total_number = floatval($negative ? $total_number * -1 : $total_number);

        $currency = $settings_api->get_option('cbxwpsimpleaccounting_currency', 'cbxwpsimpleaccounting_basics', 'USD');
        $currency_position = $settings_api->get_option('cbxwpsimpleaccounting_currency_pos', 'cbxwpsimpleaccounting_basics', 'left');
        $currency_symbol = CBXWpsimpleaccountingHelper::get_cbxwpsimpleaccounting_currency_symbol($currency);
        $currency_thousand_separator = $settings_api->get_option('cbxwpsimpleaccounting_thousand_sep', 'cbxwpsimpleaccounting_basics', ',');
        $currency_decimal_separator = $settings_api->get_option('cbxwpsimpleaccounting_decimal_sep', 'cbxwpsimpleaccounting_basics', '.');
        $currency_number_decimal = $settings_api->get_option('cbxwpsimpleaccounting_num_decimals', 'cbxwpsimpleaccounting_basics', '2');
        $formated_value = number_format($total_number, $currency_number_decimal, $currency_decimal_separator, $currency_thousand_separator);


        $currency_symbol = ($html_entity_decode_symbol) ? html_entity_decode($currency_symbol) : $currency_symbol;
        //$currency_symbol = utf8_encode($currency_symbol);

        switch ($currency_position) {
            case "left":
                $final_formatted_value = $currency_symbol . $formated_value;
                break;
            case "right":
                $final_formatted_value = $formated_value . $currency_symbol;
                break;
            case "left_space":
                $final_formatted_value = $currency_symbol . ' ' . $formated_value;
                break;
            case "right_space":
                $final_formatted_value = $formated_value . ' ' . $currency_symbol;
                break;
            default:
                $final_formatted_value = $currency_symbol . $formated_value;
        }

        $final_formatted_value = ($negative ? '-' : '') . $final_formatted_value;

        return $final_formatted_value;
    }//end method format_value_quick

    /**
     * Display formatted value without currency symbol
     *
     * @param      $total_number
     *
     * @return string
     */
    public static function format_only_value($total_number)
    {
        $settings_api = new CBXWPSimpleaccounting_Settings_API();

        $total_number = floatval($total_number);

        $negative = $total_number < 0;
        $total_number = floatval($negative ? $total_number * -1 : $total_number);

        //$currency                    = $settings_api->get_option( 'cbxwpsimpleaccounting_currency', 'cbxwpsimpleaccounting_basics', 'USD' );
        //$currency_symbol             = CBXWpsimpleaccountingHelper::get_cbxwpsimpleaccounting_currency_symbol( $currency );

        $currency_position = $settings_api->get_option('cbxwpsimpleaccounting_currency_pos', 'cbxwpsimpleaccounting_basics', 'left');
        $currency_thousand_separator = $settings_api->get_option('cbxwpsimpleaccounting_thousand_sep', 'cbxwpsimpleaccounting_basics', ',');
        $currency_decimal_separator = $settings_api->get_option('cbxwpsimpleaccounting_decimal_sep', 'cbxwpsimpleaccounting_basics', '.');
        $currency_number_decimal = $settings_api->get_option('cbxwpsimpleaccounting_num_decimals', 'cbxwpsimpleaccounting_basics', '2');
        $formated_value = number_format($total_number, $currency_number_decimal, $currency_decimal_separator, $currency_thousand_separator);


        /*$currency_symbol = ($html_entity_decode_symbol)? html_entity_decode($currency_symbol): $currency_symbol;
        //$currency_symbol = utf8_encode($currency_symbol);

        switch ( $currency_position ) {
            case "left":
                $final_formatted_value = $currency_symbol . $formated_value;
                break;
            case "right":
                $final_formatted_value = $formated_value . $currency_symbol;
                break;
            case "left_space":
                $final_formatted_value = $currency_symbol . ' ' . $formated_value;
                break;
            case "right_space":
                $final_formatted_value = $formated_value . ' ' . $currency_symbol;
                break;
            default:
                $final_formatted_value = $currency_symbol . $formated_value;
        }*/

        $final_formatted_value = ($negative ? '-' : '') . $formated_value;

        return $final_formatted_value;
    }//end method format_only_value

    /**
     * all database table creation during plugin activation
     *
     * @param $charset_collate
     */
    public static function dbTableCreation()
    {

        //ALTER TABLE tablename MODIFY columnname INTEGER;

        global $wpdb;

        $charset_collate = '';
        if ($wpdb->has_cap('collation')) {
            if (!empty($wpdb->charset)) {
                $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
            }
            if (!empty($wpdb->collate)) {
                $charset_collate .= " COLLATE $wpdb->collate";
            }
        }

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $table_expinc = $wpdb->prefix . 'cbaccounting_expinc';

        $sql = "CREATE TABLE $table_expinc (
                          id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                          title varchar(500) DEFAULT NULL COMMENT 'title for list item',
                          amount DECIMAL(18,6) NOT NULL DEFAULT '0' COMMENT 'The amount of expense or income.',
                          source_amount DECIMAL(18,6) NULL DEFAULT NULL COMMENT 'The source amount of expense or income.',
                          source_currency varchar(50) NULL DEFAULT NULL COMMENT 'The source currency',
                          type enum('1','2') NOT NULL DEFAULT '1' COMMENT '1 for income and 2 for expense.',
                          note text DEFAULT NULL COMMENT 'a short description about income or expense.',
                          account int(11) DEFAULT NULL,
                          invoice varchar(100) DEFAULT NULL,
                          istaxincluded tinyint(1) NOT NULL DEFAULT '0',
                          tax DECIMAL(10,2) DEFAULT NULL,
                          add_by bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'foreign key of user table. who add this list.',
                          mod_by bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'foreign key of user table. who last modify this list.',
                          add_date datetime DEFAULT NULL COMMENT 'add date',
                          mod_date datetime DEFAULT NULL COMMENT 'last modified date',
                          vc_id int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'foreign key of vc table.',
                          cat_id int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'foreign key of category table table.',
                          protected tinyint(1) NOT NULL DEFAULT '0' COMMENT 'protected means this log is not allowed to edit',
                          misc text NOT NULL DEFAULT '' COMMENT 'to store extra information as serialized data',
                          PRIMARY KEY (id)
                        ) $charset_collate; ";

        dbDelta($sql);


        $table_category = $wpdb->prefix . 'cbaccounting_category';

        $sql = "CREATE TABLE $table_category (
                          id int(11) unsigned NOT NULL AUTO_INCREMENT,
                          title varchar(200) NOT NULL COMMENT 'category title',
                          note text DEFAULT NULL COMMENT 'short description about category',
                          type enum('1','2') NOT NULL DEFAULT '1' COMMENT '1 for income and 2 for expense.',
                          color varchar(7) NOT NULL,
                          publish enum('0','1') NOT NULL DEFAULT '1' COMMENT '0 for unpublished and 1 for published',
                          add_by bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'foreign key of user table. who add this category',
                          mod_by bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'foreign key of user table. who modified this category',
                          add_date datetime DEFAULT NULL COMMENT 'created date',
                          mod_date datetime DEFAULT NULL COMMENT 'modified date',
                          protected tinyint(1) NOT NULL DEFAULT '0' COMMENT 'protected means this category is not allowed to edit',
                          misc text NOT NULL DEFAULT '' COMMENT 'to store extra information as serialized data',
                          PRIMARY KEY (id)
                        ) $charset_collate; ";

        dbDelta($sql);


        $table_expat_rel = $wpdb->prefix . 'cbaccounting_expcat_rel';

        $sql = "CREATE TABLE $table_expat_rel (
				  id bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'relation id',
                  expinc_id bigint(20) NOT NULL COMMENT 'foreign key of expense/income id',
                  category_id int(11) NOT NULL COMMENT 'foreign key of category table. id of expense or income category. default is un-categorized.',
                  PRIMARY KEY (id)
                ) $charset_collate;";

        dbDelta($sql);


        $table_account = $wpdb->prefix . 'cbaccounting_account_manager';

        $sql = "CREATE TABLE $table_account (
                          id int(11) unsigned NOT NULL AUTO_INCREMENT,
                          title varchar(200) NOT NULL COMMENT 'account title',
                          type varchar(5) NOT NULL COMMENT 'account type',
                          acc_no varchar(200) DEFAULT NULL COMMENT 'account number',
                          acc_name varchar(200) DEFAULT NULL COMMENT 'account name',
                          bank_name varchar(200) DEFAULT NULL COMMENT 'bank name',
                          branch_name varchar(200) DEFAULT NULL COMMENT 'branch name',
                          add_by bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'foreign key of user table. who add this category',
                          mod_by bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'foreign key of user table. who modified this category',
                          add_date datetime DEFAULT NULL COMMENT 'created date',
                          mod_date datetime DEFAULT NULL COMMENT 'modified date',
						  misc text NOT NULL DEFAULT '' COMMENT 'to store extra information as serialized data',
                          PRIMARY KEY (id)
                        ) $charset_collate; ";

        dbDelta($sql);
    }//end method dbTableCreation

    public static function dataMigration()
    {

        global $wpdb;
        $table_expinc = $wpdb->prefix . 'cbaccounting_expinc';
        $database_name = DB_NAME;

        $sql = "SELECT DATA_TYPE FROM information_schema.columns WHERE table_schema = $database_name AND table_name = $table_expinc AND COLUMN_NAME = amount";
        $data_type = $wpdb->get_col($sql);
        if ($data_type !== false && $data_type == 'float') {
            $sql_queries = array();
            $sql_queries[] = $sql_amount = "ALTER TABLE $database_name MODIFY amount DECIMAL(16,4)";
            $sql_queries[] = $sql_source_amount = "ALTER TABLE $database_name MODIFY source_amount DECIMAL(16,4)";
            $sql_queries[] = $sql_tax = "ALTER TABLE $database_name MODIFY tax DECIMAL(10,2)";

            foreach ($sql_queries as $query) {
                $wpdb->query($query);
            }


        }
    }//end method dataMigration

    /**
     * Create Default Categories
     */
    public static function defaultCategoryCreation()
    {
        $cat_counts = CBXWpsimpleaccountingHelper::getCatsCountByType();
        $cats_total = $cats_income_total = $cats_expense_total = 0;

        if (is_array($cat_counts)) {
            $cats_total = isset($cat_counts['total']) ? intval($cat_counts['total']) : 0;
            $cats_income_total = isset($cat_counts['1']) ? intval($cat_counts['1']) : 0;
            $cats_expense_total = isset($cat_counts['2']) ? intval($cat_counts['2']) : 0;

            if ($cats_total == 0) {
                //income and expense default category creation
                self::create_default_category(true, true);
            } else if ($cats_income_total == 0) {
                //create default income category
                self::create_default_category(true, false);
            } else if ($cats_expense_total == 0) {
                //create default expense category
                self::create_default_category(false, true);
            }
        }
    }//end method defaultCategoryCreation


    /**
     * Create default category for income and expense when needed
     *
     * @param bool $create_income
     * @param bool $create_expense
     *
     * @return array
     */
    public static function create_default_category($create_income = true, $create_expense = true)
    {
        global $wpdb;


        $output = array(
            'income_created' => false,
            'expense_created' => false
        );


        $cbxwpsimpleaccounting_category = get_option('cbxwpsimpleaccounting_category', array());


        $cbxacc_category_table_name = $wpdb->prefix . 'cbaccounting_category';
        //title, type, color, note, add_by, protected
        $col_data_format = array('%s', '%d', '%s', '%s', '%d', '%s', '%d');

        //if to create income category
        if ($create_income) {
            $income_default_category = 0;
            $income_col_data = array(
                'title' => esc_html__('Default Income Category', 'cbxwpsimpleaccounting'),
                'type' => 1, // income
                'color' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT),
                'note' => esc_html__('Defalt income category created automatically.', 'cbxwpsimpleaccounting'),
                'add_by' => get_current_user_id(),
                'add_date' => current_time('mysql'),
                'protected' => 0,
            );

            //insert new Woo Sales Income category
            $insert_status = $wpdb->insert($cbxacc_category_table_name, $income_col_data, $col_data_format);
            if ($insert_status != false) {
                //new category inserted successfully
                $income_default_category = $wpdb->insert_id;


                if ($income_default_category > 0) {
                    //update income category
                    $cbxwpsimpleaccounting_category['income_default_category'] = $income_default_category;
                    update_option('cbxwpsimpleaccounting_category', $cbxwpsimpleaccounting_category);
                }

                $output['income_created'] = true;
            }
        }

        //if to create expense category
        if ($create_expense) {
            $expense_default_category = 0;
            $expense_col_data = array(
                'title' => esc_html__('Default Expense Category', 'cbxwpsimpleaccounting'),
                'type' => 2, // expense
                'color' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT),
                'note' => esc_html__('Defalt expense category created automatically.', 'cbxwpsimpleaccounting'),
                'add_by' => get_current_user_id(),
                'add_date' => current_time('mysql'),
                'protected' => 0,
            );
            $insert_status = $wpdb->insert($cbxacc_category_table_name, $expense_col_data, $col_data_format);
            if ($insert_status != false) {
                //new category inserted successfully

                $expense_default_category = $wpdb->insert_id;
                if ($expense_default_category > 0) {
                    //update income category
                    $cbxwpsimpleaccounting_category['expense_default_category'] = $expense_default_category;
                    update_option('cbxwpsimpleaccounting_category', $cbxwpsimpleaccounting_category);
                }

                $output['expense_created'] = true;
            }
        }

        return $output;
    }//end method create_default_category

    /**
     * Get category counts by type
     *
     * @return array
     */
    public static function getCatsCountByType()
    {
        global $wpdb;

        $cbaccounting_cat_table = $wpdb->prefix . 'cbaccounting_category'; //expinc category table name

        $where_sql = '';


        if ($where_sql == '') {
            $where_sql = '1';
        }

        $sql_select = "SELECT type, COUNT(*) as total FROM $cbaccounting_cat_table  WHERE   $where_sql GROUP BY type";

        $results = $wpdb->get_results("$sql_select", 'ARRAY_A');

        $total = 0;
        $data = array(
            '1' => 0,
            '2' => 0,
            'total' => $total
        );


        if ($results != null) {
            foreach ($results as $result) {
                $total += intval($result['total']);
                $data[$result['type']] = $result['total'];
            }
            $data['total'] = $total;
        }

        return $data;

    }//end method getCatsCountByType

    /**
     * @return array
     */
    public static function getAccsCountByType()
    {

        global $wpdb;

        $cbaccounting_acc_table = $wpdb->prefix . 'cbaccounting_account_manager'; //account manager table name


        $where_sql = '';


        if ($where_sql == '') {
            $where_sql = '1';
        }

        $sql_select = "SELECT type, COUNT(*) as total FROM $cbaccounting_acc_table  WHERE   $where_sql GROUP BY type";

        $results = $wpdb->get_results("$sql_select", 'ARRAY_A');

        $total = 0;
        $data = array(
            'cash' => 0,
            'bank' => 0,
            'total' => $total
        );


        if ($results != null) {
            foreach ($results as $result) {
                $total += intval($result['total']);
                $data[$result['type']] = $result['total'];
            }
            $data['total'] = $total;
        }

        return $data;

    }//end method getAccsCountByType

    /**
     * Get Log Data
     *
     * @param int $perpage
     * @param int $page
     *
     * @return array|null|object
     */
    public static function getLogData($type = 0, $category = 0, $date_from = '', $date_to = '', $date_enable = '', $account = 0, $user_addby = 0, $orderby = 'c.id', $order = 'asc', $perpage = 10, $page = 1)
    {

        global $wpdb;


        //all table names
        $cbxexpinc_table = $wpdb->prefix . 'cbaccounting_expinc'; //expinc table name
        $cbaccounting_expcat_rel_table = $wpdb->prefix . 'cbaccounting_expcat_rel'; //expinc and category reltaion table name
        $cbaccounting_cat_table = $wpdb->prefix . 'cbaccounting_category'; //expinc category table name
        $cbxacc_table_name = $wpdb->prefix . 'cbaccounting_account_manager';


        $join = '';
        $join .= " LEFT JOIN $cbaccounting_expcat_rel_table catrel ON c.id = catrel.expinc_id ";
        $join .= " LEFT JOIN $cbaccounting_cat_table cat ON catrel.category_id = cat.id ";
        $join .= " LEFT JOIN $cbxacc_table_name act ON act.id = c.account ";


        $join = apply_filters('cbxwpsimpleaccountinglog_listing_sql_join', $join);

        $where_sql = '';


        //type and category filter (for category filter type needs to be specific)
        if ($type != 0) {
            if ($category != 0) {
                $where_sql .= $wpdb->prepare("c.type = %d AND catrel.category_id = %d", absint($type), absint($category));
            } else {
                $where_sql .= $wpdb->prepare("c.type = %d", absint($type));
            }
        }

        //filter by date range, where sql
        if ($date_enable == 'cbxlogenable') {
            if ($date_from != '' && $date_to != '') {

                if ($where_sql != '') {
                    $where_sql .= ' AND ';
                }

                $where_sql .= " CAST(c.add_date AS DATE) ";
                $where_sql .= $wpdb->prepare("between %s AND %s ", $date_from, $date_to);


            }
        }

        //filter by account no, where sql
        if (intval($account) > 0) {

            if ($where_sql != '') {
                $where_sql .= ' AND ';
            }
            $where_sql .= $wpdb->prepare("c.account=%d ", $account);
        }

        //filter by add_by user id, where sql
        if (intval($user_addby) > 0) {
            if ($where_sql != '') {
                $where_sql .= ' AND ';
            }
            $where_sql .= $wpdb->prepare("c.add_by = %d ", $user_addby);
        }

        $where_sql = apply_filters('cbxwpsimpleaccountinglog_listing_sql_where', $where_sql);

        if ($where_sql == '') {
            $where_sql = '1';
        }


        $start_point = ($page * $perpage) - $perpage;
        $limit_sql = "LIMIT";
        $limit_sql .= ' ' . $start_point . ',';
        $limit_sql .= ' ' . $perpage;


        $sortingOrder = " ORDER BY $orderby $order ";

        $select_extra = '';
        $select_extra = apply_filters('cbxwpsimpleaccountinglog_listing_sql_select_extra', $select_extra);

        $query = "SELECT c.*, cat.id as catid, cat.title as cattitle, cat.color as catcolor, act.title as accountname $select_extra FROM $cbxexpinc_table c $join WHERE  $where_sql $sortingOrder  $limit_sql";


        $allexpincdata = $wpdb->get_results($query, ARRAY_A);


        return $allexpincdata;
    }//end method getLogData

    /**
     * Get total log data count
     *
     * @param int $perpage
     * @param int $page
     *
     * @return array|null|object
     */
    public static function getLogDataCount($type = 0, $category = 0, $date_from = '', $date_to = '', $date_enable = '', $account = 0, $user_addby = 0, $orderby = 'c.id', $order = 'asc', $perpage = 10, $page = 1)
    {

        global $wpdb;


        //all table names
        $cbxexpinc_table = $wpdb->prefix . 'cbaccounting_expinc'; //expinc table name
        $cbaccounting_expcat_rel_table = $wpdb->prefix . 'cbaccounting_expcat_rel'; //expinc and category reltaion table name
        $cbaccounting_cat_table = $wpdb->prefix . 'cbaccounting_category'; //expinc category table name
        $cbxacc_table_name = $wpdb->prefix . 'cbaccounting_account_manager';


        $join = '';
        $join .= " LEFT JOIN $cbaccounting_expcat_rel_table catrel ON c.id = catrel.expinc_id ";
        $join .= " LEFT JOIN $cbaccounting_cat_table cat ON catrel.category_id = cat.id ";
        $join .= " LEFT JOIN $cbxacc_table_name act ON act.id = c.account ";

        $join = apply_filters('cbxwpsimpleaccountinglog_listing_sql_join', $join);


        $where_sql = '';


        //type and category filter (for category filter type needs to be specific)
        if ($type != 0) {
            if ($category != 0) {
                $where_sql .= $wpdb->prepare("c.type = %d AND catrel.category_id = %d", absint($type), absint($category));
            } else {
                $where_sql .= $wpdb->prepare("c.type = %d", absint($type));
            }
        }


        //filter by date range, where sql
        if ($date_enable == 'cbxlogenable') {
            if ($date_from != '' && $date_to != '') {

                if ($where_sql != '') {
                    $where_sql .= ' AND ';
                }

                $where_sql .= " CAST(c.add_date AS DATE) ";
                $where_sql .= $wpdb->prepare("between %s AND %s ", $date_from, $date_to);


            }
        }


        //filter by account no, where sql
        if (intval($account) > 0) {

            if ($where_sql != '') {
                $where_sql .= ' AND ';
            }
            $where_sql .= $wpdb->prepare("c.account = %d ", $account);
        }

        //filter by add_by user id, where sql
        if (intval($user_addby) > 0) {
            if ($where_sql != '') {
                $where_sql .= ' AND ';
            }
            $where_sql .= $wpdb->prepare("c.add_by = %d ", $user_addby);
        }

        $where_sql = apply_filters('cbxwpsimpleaccountinglog_listing_sql_where', $where_sql);

        if ($where_sql == '') {
            $where_sql = '1';
        }

        $sortingOrder = " ORDER BY $orderby $order ";

        $query = "SELECT COUNT(*) FROM $cbxexpinc_table c $join   WHERE  $where_sql $sortingOrder";

        $count = $wpdb->get_var("$query");

        return $count;
    }//end method getLogDataCount

    /**
     * Log export query
     *
     * @return array|null|object
     */
    public static function logExportQueryData()
    {

        global $wpdb;

        $where = $join = $order_by = "";

        //all accounting table name.
        $cbxexpinc_table = $wpdb->prefix . 'cbaccounting_expinc';
        $cbaccounting_expcat_rel_table = $wpdb->prefix . 'cbaccounting_expcat_rel';
        $cbaccounting_cat_table = $wpdb->prefix . 'cbaccounting_category';
        $cbxacc_table_name = $wpdb->prefix . 'cbaccounting_account_manager';

        //set add_date descending by default
        $order_by = 'order by c.add_date desc';

        /* Total logic for getting data to be exported for filtered and filtered data */

        //handle type(income/expense or both) and category as sub logic
        if (isset($_REQUEST['cbxlogexpinc_type']) && absint($_REQUEST['cbxlogexpinc_type']) != 0) {

            if (isset($_REQUEST['cbxlogexpinc_category']) && $_REQUEST['cbxlogexpinc_category'] != 0) {

                $where .= $wpdb->prepare("c.type = %d AND catrel.category_id = %d", absint($_REQUEST['cbxlogexpinc_type']), absint($_REQUEST['cbxlogexpinc_category']));

            } else {

                $where .= $wpdb->prepare("c.type = %d", absint($_REQUEST['cbxlogexpinc_type']));
            }
        }//end  handle type(income/expense or both) and category as sub logic

        //handle date range
        if (isset($_REQUEST['cbxlogenableDaterange']) && $_REQUEST['cbxlogenableDaterange'] == 'cbxlogenable') {
            if (isset($_REQUEST['cbxlogfromDate']) && $_REQUEST['cbxlogfromDate'] != null && isset($_REQUEST['cbxlogtoDate']) && $_REQUEST['cbxlogtoDate'] != null) {

                if ($where != '') {
                    $where .= ' AND ';
                }

                $where .= "CAST(c.add_date AS DATE)";

                $where .= $wpdb->prepare(" between %s AND %s", sanitize_text_field($_REQUEST['cbxlogfromDate']), sanitize_text_field($_REQUEST['cbxlogtoDate']));

            }
        }//end  handle date range

        //handle account filter
        $account_id = isset($_REQUEST['cbxlogexpinc_account']) ? intval($_REQUEST['cbxlogexpinc_account']) : 0;
        if ($account_id > 0) {
            if ($where != '') {
                $where .= ' AND ';
            }

            $where .= $wpdb->prepare("c.account = %d", absint($account_id));
        }//end handle account filter

        $where = apply_filters('cbxwpsimpleaccountinglog_listing_sql_where', $where);

        $order = (isset($_REQUEST['order']) && $_REQUEST['order'] != '') ? $_REQUEST['order'] : 'desc';
        $order_by = (isset($_REQUEST['orderby']) && $_REQUEST['orderby'] != '') ? $_REQUEST['orderby'] : 'c.id';


        $order_by_sql = ' ORDER BY ' . $order_by . ' ' . $order;

        if ($where == '') {
            $where = '1';
        }

        /* End logic here */
        $join .= " LEFT JOIN $cbaccounting_expcat_rel_table catrel ON c.id = catrel.expinc_id ";
        $join .= " LEFT JOIN $cbaccounting_cat_table cat ON catrel.category_id = cat.id ";
        $join .= " LEFT JOIN $cbxacc_table_name act ON act.id = c.account ";

        $join = apply_filters('cbxwpsimpleaccountinglog_listing_sql_join', $join);

        $select_extra = '';
        $select_extra = apply_filters('cbxwpsimpleaccountinglog_listing_sql_select_extra', $select_extra);
        $query = "SELECT c.*, cat.id as catid,cat.title as cattitle,cat.color as catcolor, act.title as accountname $select_extra FROM $cbxexpinc_table c $join WHERE $where $order_by_sql";

        $datas = $wpdb->get_results($query, OBJECT);

        return $datas;
    }//end method logExportQueryData

    /**
     * Get Data
     *
     * @param int $perpage
     * @param int $page
     *
     * @return array|null|object
     */
    public static function getAccountsData($search = '', $type = '', $orderby = 'a.id', $order = 'asc', $perpage = 20, $page = 1)
    {

        global $wpdb;


        //all table names
        $cbaccounting_acc_table = $wpdb->prefix . 'cbaccounting_account_manager'; //account manager table name


        $join = '';
        $join = apply_filters('cbxwpsimpleaccountingacc_listing_sql_join', $join);

        $where_sql = '';

        if ($search != '') {
            if ($where_sql != '') {
                $where_sql .= ' AND ';
            }
            $where_sql .= $wpdb->prepare(" a.type LIKE '%%%s%%' OR a.acc_no LIKE '%%%s%%' OR a.acc_name LIKE '%%%s%%' OR a.bank_name LIKE '%%%s%%' OR a.branch_name LIKE '%%%s%%'", $search, $search, $search, $search, $search);
        }

        //type and account filter (for account filter type needs to be specific)
        if ($type != '') {
            $where_sql .= $wpdb->prepare("a.type = %s", $type);
        }


        $where_sql = apply_filters('cbxwpsimpleaccountingacc_listing_sql_where', $where_sql);

        if ($where_sql == '') {
            $where_sql = '1';
        }


        $start_point = ($page * $perpage) - $perpage;
        $limit_sql = "LIMIT";
        $limit_sql .= ' ' . $start_point . ',';
        $limit_sql .= ' ' . $perpage;


        $sortingOrder = " ORDER BY $orderby $order ";

        $select_extra = '';
        $select_extra = apply_filters('cbxwpsimpleaccountingacc_listing_sql_select_extra', $select_extra);

        $query = "SELECT a.* $select_extra FROM $cbaccounting_acc_table a $join WHERE  $where_sql $sortingOrder  $limit_sql";


        $allexpincdata = $wpdb->get_results($query, ARRAY_A);


        return $allexpincdata;
    }//end method getAccountsData

    /**
     * Get Data
     *
     * @param int $perpage
     * @param int $page
     *
     * @return array|null|object
     */
    public static function getVCData($search = '', $orderby = 'id', $order = 'desc', $perpage = 20, $page = 1)
    {

        global $wpdb;

        $vc_table = $wpdb->prefix . "cbaccounting_vc_manager";


        $sql_select = "SELECT * FROM $vc_table";


        $where_sql = '';

        if ($search != '') {
            if ($where_sql != '') {
                $where_sql .= ' AND ';
            }
            $where_sql .= $wpdb->prepare(" type LIKE '%%%s%%' OR name LIKE '%%%s%%' OR description LIKE '%%%s%%' OR organization LIKE '%%%s%%' ", $search, $search, $search, $search);
        }


        if ($where_sql == '') {
            $where_sql = '1';
        }


        $start_point = ($page * $perpage) - $perpage;
        $limit_sql = "LIMIT";
        $limit_sql .= ' ' . $start_point . ',';
        $limit_sql .= ' ' . $perpage;


        $sortingOrder = " ORDER BY $orderby $order ";


        $data = $wpdb->get_results("$sql_select  WHERE  $where_sql $sortingOrder  $limit_sql", 'ARRAY_A');

        return $data;
    }//end method getVCData

    /**
     * Return frontend nav to navigate among shortcodes
     */
    public static function frontendNavbar()
    {
        //$frontend_setting = get_option('cbxaccounting_frontend');
        $frontend_setting = get_option('cbxwpsimpleaccounting_frontend');


        $dashboard_page_view_link = $logmanager_page_view_link = $statement_page_view_link = '#';

        if ($frontend_setting !== false) {
            if (isset($frontend_setting['cbxwpsafrontend']) && intval($frontend_setting['cbxwpsafrontend']) > 0) {
                $dashboard_page_view_link = get_permalink($frontend_setting['cbxwpsafrontend']);
            }
            if (isset($frontend_setting['cbxwpsafrontendlog']) && intval($frontend_setting['cbxwpsafrontendlog']) > 0) {
                $logmanager_page_view_link = get_permalink($frontend_setting['cbxwpsafrontendlog']);
            }
            if (isset($frontend_setting['cbxwpsafrontendstatement']) && intval($frontend_setting['cbxwpsafrontendstatement']) > 0) {
                $statement_page_view_link = get_permalink($frontend_setting['cbxwpsafrontendstatement']);
            }
        }

        $current_page_id = intval(get_the_ID());

        $cbxsa_fnav_items = array();

        $cbxsa_fnav_items['cbxwpsafrontend'] = '<li role="presentation" class="cbxsa-fnav-item cbxsa-fnav-dashboard ' . (($current_page_id === intval($frontend_setting['cbxwpsafrontend'])) ? ' active ' : '') . '"><a href="' . $dashboard_page_view_link . '">' . esc_html__('Dashboard', 'cbxwpsimpleaccountingfrontend') . '</a></li>';

        $cbxsa_fnav_items['cbxwpsafrontendlog'] = '<li role="presentation" class="cbxsa-fnav-item cbxsa-fnav-log-manager ' . (($current_page_id === intval($frontend_setting['cbxwpsafrontendlog'])) ? ' active ' : '') . '"><a href="' . $logmanager_page_view_link . '">' . esc_html__('Log Manager', 'cbxwpsimpleaccountingfrontend') . '</a></li>';

        $cbxsa_fnav_items['cbxwpsafrontendstatement'] = '<li role="presentation" class="cbxsa-fnav-item cbxsa-fnav-statement ' . (($current_page_id === intval($frontend_setting['cbxwpsafrontendstatement'])) ? ' active ' : '') . '"><a href="' . $statement_page_view_link . '">' . esc_html__('Statement', 'cbxwpsimpleaccountingfrontend') . '</a></li>';


        echo '<ul class="nav nav-tabs nav-tabs-cbxsa-fnav" id="cbxwpsaccfrontendnav">
                   ' . apply_filters('cbxwpsimpleaccountingfrontend_nav_items', implode('', array_values($cbxsa_fnav_items))) . '
                </ul>';
    }//end method frontendNavbar

    /**
     * CBXAccounting Core tables list
     */
    public static function getAllDBTablesList()
    {
        global $wpdb;

        $table_names = array();
        $table_names['Expense Income Log Table(Core)'] = $wpdb->prefix . "cbaccounting_expinc";
        $table_names['Expense Income Category Table(Core)'] = $wpdb->prefix . "cbaccounting_category";
        $table_names['Expense Income Category Relation Table(Core)'] = $wpdb->prefix . "cbaccounting_expcat_rel";
        $table_names['Account Manager Table(Core)'] = $wpdb->prefix . "cbaccounting_account_manager";

        return apply_filters('cbxwpsimpleaccounting_table_list', $table_names);
    }//end method getAllDBTablesList

    /**
     * List all global option name with prefix cbxwpsimpleaccounting_
     */
    public static function getAllOptionNames()
    {
        global $wpdb;

        $prefix = 'cbxwpsimpleaccounting_';
        $option_names = $wpdb->get_results("SELECT * FROM {$wpdb->options} WHERE option_name LIKE '{$prefix}%'", ARRAY_A);

        return apply_filters('cbxwpsimpleaccounting_option_names', $option_names);
    }//end method getAllOptionNames


    /**
     * Check if the category has any logs associated
     *
     * @param int $cat_id
     *
     * @return bool
     */
    public static function isCatEmpty($cat_id = 0)
    {
        global $wpdb;
        $cbaccounting_expcat_rel_table = $wpdb->prefix . 'cbaccounting_expcat_rel'; //expinc and category reltaion table name

        $cat_id = intval($cat_id);
        $result = false;

        if ($cat_id == 0) {
            return $result;
        } //false is safe here

        $query = $wpdb->prepare("SELECT * from $cbaccounting_expcat_rel_table WHERE  category_id = %d LIMIT 0, 1", $cat_id);
        $row = $wpdb->get_row($query, ARRAY_A);
        if ($row === null) {
            return true;
        }

        return $result;
    }//end method isCatEmpty

    /**
     * Get single category information
     *
     * @param int $cat_id
     *
     * @return array|object|void|null
     */
    public static function getCategory($cat_id = 0)
    {
        global $wpdb;
        $cbaccounting_cat_table = $wpdb->prefix . 'cbaccounting_category'; //expinc category table name

        $category = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $cbaccounting_cat_table WHERE id = %d", $cat_id),
            ARRAY_A
        );

        return $category;
    }//end getCategory

    /**
     * Check if the account has any logs associated
     *
     * @param int $account_id
     *
     * @return bool
     */
    public static function isAccountEmpty($account_id = 0)
    {
        global $wpdb;

        $cbxexpinc_table = $wpdb->prefix . 'cbaccounting_expinc'; //expinc table name


        $account_id = intval($account_id);
        $result = false;

        if ($account_id == 0) {
            return $result;
        } //false is safe here

        $query = $wpdb->prepare("SELECT * from $cbxexpinc_table WHERE  account = %d LIMIT 0, 1", $account_id);
        $row = $wpdb->get_row($query, ARRAY_A);
        if ($row === null) {
            return true;
        }

        return $result;
    }//end method isAccountEmpty

    /**
     * Get all categories
     *
     * @return array|null|object
     */
    public static function getAllCategories()
    {
        global $wpdb;
        $cbaccounting_cat_table = $wpdb->prefix . 'cbaccounting_category'; //expinc category table name
        $cats = $wpdb->get_results('SELECT * FROM ' . $cbaccounting_cat_table . ' order by title asc', ARRAY_A);
        if ($cats === null) {
            return array();
        }

        return $cats;
    }//end method getAllCategories

    /**
     * Get all income categories
     *
     * @param array $cats
     * @param bool $force
     *
     * @return array
     */
    public static function getAllIncomeCategories($cats = array(), $force = false)
    {
        $income_cats = array();
        if ($force == true) {
            $cats = CBXWpsimpleaccountingHelper::getAllCategories();
        }

        if (is_array($cats) && sizeof($cats) > 0) {
            foreach ($cats as $cat) {
                if (isset($cat['type']) && intval($cat['type']) == 1) {
                    $cat_id = intval($cat['id']);
                    $income_cats[$cat_id] = $cat;
                }
            }
        }

        return $income_cats;
    }//end method getAllIncomeCategories

    /**
     * Get all expense categories
     *
     * @param array $cats
     * @param bool $force
     *
     * @return array
     */
    public static function getAllExpenseCategories($cats = array(), $force = false)
    {
        $expense_cats = array();
        if ($force == true) {
            $cats = CBXWpsimpleaccountingHelper::getAllCategories();
        }

        if (is_array($cats) && sizeof($cats) > 0) {
            foreach ($cats as $cat) {
                if (isset($cat['type']) && intval($cat['type']) == 2) {
                    $cat_id = intval($cat['id']);
                    $expense_cats[$cat_id] = $cat;
                }
            }
        }

        return $expense_cats;
    }//end method getAllExpenseCategories

    public static function getCatChooserArr($cats = array(), $allow_protected = true)
    {
        $cats_chooser_arr = array();
        $cats_chooser_arr[0] = esc_html__('Choose Category', '');
        if (is_array($cats) && sizeof($cats) > 0) {
            foreach ($cats as $cat) {
                if ($allow_protected == false && isset($cat['protected']) && intval($cat['protected']) == 1) {
                    continue;
                }

                $cat_id = intval($cat['id']);
                $cat_title = $cat['title'];
                $cats_chooser_arr[$cat_id] = esc_html(stripcslashes($cat_title));
            }

        }

        return $cats_chooser_arr;
    }//end method getCatChooserArr;

    /**
     * Inserts a new key/value before the key in the array.
     *
     * @param       $key
     * @param array $array
     * @param       $new_key
     * @param       $new_value
     *
     * @return array|bool
     */
    public static function array_insert_before($key, array &$array, $new_key, $new_value)
    {
        if (array_key_exists($key, $array)) {
            $new = array();
            foreach ($array as $k => $value) {
                if ($k === $key) {
                    $new[$new_key] = $new_value;
                }
                $new[$k] = $value;
            }

            return $new;
        }

        return false;
    }//end method array_insert_before

    /**
     * Inserts a new key/value after the key in the array.
     *
     * @param       $key
     * @param array $array
     * @param       $new_key
     * @param       $new_value
     *
     * @return array|bool
     */
    public static function array_insert_after($key, array &$array, $new_key, $new_value)
    {
        if (array_key_exists($key, $array)) {
            $new = array();
            foreach ($array as $k => $value) {
                $new[$k] = $value;
                if ($k === $key) {
                    $new[$new_key] = $new_value;
                }
            }

            return $new;
        }

        return false;
    }//end method array_insert_after

    /**
     * General tax field sanitize
     *
     * @param $value
     *
     * @return float
     */
    public static function cbxwpsimpleaccounting_tax_sanitize($value)
    {

        return floatval($value);
    }

    /**
     * Create files/directories.
     *
     * This function copied from woocommerce and modified
     */
    public static function create_files()
    {
        // Bypass if filesystem is read-only and/or non-standard upload system is used.
        if (apply_filters('cbxwpsimpleaccounting_install_skip_create_files', false)) {
            return;
        }

        // Install files and folders for uploading files and prevent hotlinking.
        $upload_dir = wp_upload_dir();
        //$download_method = get_option( 'woocommerce_file_download_method', 'force' );

        $files = array(
            array(
                'base' => $upload_dir['basedir'] . '/cbxwpsimpleaccounting_uploads',
                'file' => 'index.html',
                'content' => '',
            ),
            array(
                'base' => $upload_dir['basedir'] . '/cbxwpsimpleaccounting_uploads',
                'file' => '.htaccess',
                'content' => 'deny from all',
            )
        );


        foreach ($files as $file) {
            if (wp_mkdir_p($file['base']) && !file_exists(trailingslashit($file['base']) . $file['file'])) {
                $file_handle = @fopen(trailingslashit($file['base']) . $file['file'], 'w'); // phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged, WordPress.WP.AlternativeFunctions.file_system_read_fopen
                if ($file_handle) {
                    fwrite($file_handle, $file['content']); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fwrite
                    fclose($file_handle); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fclose
                }
            }
        }
    }//end method create_files

    /**
     * Upload error messages translations
     */
    public static function upload_error_messages()
    {
        $error_messages = array(
            1 => esc_html__('The uploaded file exceeds the upload_max_filesize directive in php.ini', 'cbxwpsimpleaccounting'),
            2 => esc_html__('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form', 'cbxwpsimpleaccounting'),
            3 => esc_html__('The uploaded file was only partially uploaded', 'cbxwpsimpleaccounting'),
            4 => esc_html__('No file was uploaded', 'cbxwpsimpleaccounting'),
            6 => esc_html__('Missing a temporary folder', 'cbxwpsimpleaccounting'),
            7 => esc_html__('Failed to write file to disk', 'cbxwpsimpleaccounting'),
            8 => esc_html__('A PHP extension stopped the file upload', 'cbxwpsimpleaccounting'),
            'post_max_size' => esc_html__('The uploaded file exceeds the post_max_size directive in php.ini', 'cbxwpsimpleaccounting'),
            'max_file_size' => esc_html__('File is too big', 'cbxwpsimpleaccounting'),
            'min_file_size' => esc_html__('File is too small', 'cbxwpsimpleaccounting'),
            'accept_file_types' => esc_html__('Filetype not allowed', 'cbxwpsimpleaccounting'),
            'max_number_of_files' => esc_html__('Maximum number of files exceeded', 'cbxwpsimpleaccounting'),
            'max_width' => esc_html__('Image exceeds maximum width', 'cbxwpsimpleaccounting'),
            'min_width' => esc_html__('Image requires a minimum width', 'cbxwpsimpleaccounting'),
            'max_height' => esc_html__('Image exceeds maximum height', 'cbxwpsimpleaccounting'),
            'min_height' => esc_html__('Image requires a minimum height', 'cbxwpsimpleaccounting'),
            'abort' => esc_html__('File upload aborted', 'cbxwpsimpleaccounting'),
            'image_resize' => esc_html__('Failed to resize image', 'cbxwpsimpleaccounting')
        );

        return $error_messages;
    }//end method upload_error_messages

    /**
     * Add utm params to any url
     *
     * @param string $url
     *
     * @return string
     */
    public static function url_utmy($url = '')
    {
        if ($url == '') {
            return $url;
        }

        $url = add_query_arg(array(
            'utm_source' => 'plgsidebarinfo',
            'utm_medium' => 'plgsidebar',
            'utm_campaign' => 'wpfreemium',
        ), $url);

        return $url;
    }//end url_utmy

    /**
     * PDF Export log columns
     *
     * @return mixed|void
     */
    public static function log_export_cols()
    {
        return apply_filters('cbxwpsimpleaccountinglog_log_export_cols', array(
            'title' => esc_html__("Title", 'cbxwpsimpleaccounting'),
            'amt' => esc_html__("Amt.", 'cbxwpsimpleaccounting'),
            'amt_cur' => esc_html__("Amt. Currency", 'cbxwpsimpleaccounting'),
            'type' => esc_html__("Type", 'cbxwpsimpleaccounting'),
            'category' => esc_html__("Cat.", 'cbxwpsimpleaccounting'),
            'note' => esc_html__("Note", 'cbxwpsimpleaccounting'),
            'added_by' => esc_html__("Add By", 'cbxwpsimpleaccounting'),
            'mod_by' => esc_html__("Mod By", 'cbxwpsimpleaccounting'),
            'add_date' => esc_html__("Add Date", 'cbxwpsimpleaccounting'),
            'mod_date' => esc_html__("Mod Date", 'cbxwpsimpleaccounting'),
            'source_amount' => esc_html__("Src. Amt.", 'cbxwpsimpleaccounting'),
            'source_cur' => esc_html__("Src. Curr.", 'cbxwpsimpleaccounting'),
            'tax' => esc_html__("Tax%", 'cbxwpsimpleaccounting'),
            'invoice_id' => esc_html__("Invoice ID", 'cbxwpsimpleaccounting'),
            'account' => esc_html__("Account", 'cbxwpsimpleaccounting'),
            'final_amt' => esc_html__("Final Amt.", 'cbxwpsimpleaccounting')
        ));
    }//end export_pdf_log_cols


    /**
     * Next letter for excel
     *
     * @param string $current_letter
     *
     * @return string
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function excel_next_letter($current_letter = 'A')
    {
        $columnAlpha_index = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($current_letter);
        $letter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnAlpha_index + 1);

        return $letter;
    }//end excel_next_letter

    /**
     * Previous letter for excel
     *
     * @param string $current_letter
     *
     * @return string
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function excel_prev_letter($current_letter = 'A')
    {
        $columnAlpha_index = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($current_letter);
        $letter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnAlpha_index - 1);

        return $letter;
    }//end excel_prev_letter

    /**
     * Checks if the current request is a WP REST API request.
     *
     * https://wordpress.stackexchange.com/a/317041/6343
     *
     * Case #1: After WP_REST_Request initialisation
     * Case #2: Support "plain" permalink settings
     * Case #3: It can happen that WP_Rewrite is not yet initialized,
     *          so do this (wp-settings.php)
     * Case #4: URL Path begins with wp-json/ (your REST prefix)
     *          Also supports WP installations in subfolders
     *
     * @returns boolean
     * @author matzeeable
     */
    public static function is_rest()
    {
        $prefix = rest_get_url_prefix();
        if (defined('REST_REQUEST') && REST_REQUEST // (#1)
            || isset($_GET['rest_route']) // (#2)
            && strpos(trim($_GET['rest_route'], '\\/'), $prefix, 0) === 0)
            return true;
        // (#3)
        global $wp_rewrite;
        if ($wp_rewrite === null) $wp_rewrite = new WP_Rewrite();

        // (#4)
        $rest_url = wp_parse_url(trailingslashit(rest_url()));
        $current_url = wp_parse_url(add_query_arg(array()));
        return strpos($current_url['path'], $rest_url['path'], 0) === 0;
    }//end is_rest
}//end class CBXWpsimpleaccountingHelper