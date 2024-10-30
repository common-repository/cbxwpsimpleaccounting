<?php

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}


class CBXWpsimpleaccountinglogListTable extends WP_List_Table {
	protected $cbxsettings = '';
	protected $settingFields = '';


	/** ************************************************************************
	 * REQUIRED. Set up a constructor that references the parent constructor. We
	 * use the parent reference to set some default configs.
	 ***************************************************************************/
	function __construct() {
		global $status, $page;

		$settings = new CBXWPSimpleaccounting_Settings_API();


		$this->cbxsettings   = $settings;
		$this->settingFields = new stdClass();


		//Set parent defaults
		parent::__construct(
			array(
				'singular' => 'cbxaccountinglog',     //singular name of the listed records
				'plural'   => 'cbxaccountinglogs',    //plural name of the listed records
				'ajax'     => false      //does this table support ajax?
			)
		);


		//get all settings.

		$this->settingFields->currency                    = $this->cbxsettings->get_option( 'cbxwpsimpleaccounting_currency', 'cbxwpsimpleaccounting_basics', 'USD' );
		$this->settingFields->currency_position           = $this->cbxsettings->get_option( 'cbxwpsimpleaccounting_currency_pos', 'cbxwpsimpleaccounting_basics', 'left' );
		$this->settingFields->currency_symbol             = CBXWpsimpleaccountingHelper::get_cbxwpsimpleaccounting_currency_symbol( $this->settingFields->currency );
		$this->settingFields->currency_thousand_separator = $this->cbxsettings->get_option( 'cbxwpsimpleaccounting_thousand_sep', 'cbxwpsimpleaccounting_basics', ',' );
		$this->settingFields->currency_decimal_separator  = $this->cbxsettings->get_option( 'cbxwpsimpleaccounting_decimal_sep', 'cbxwpsimpleaccounting_basics', '.' );
		$this->settingFields->currency_number_decimal     = $this->cbxsettings->get_option( 'cbxwpsimpleaccounting_num_decimals', 'cbxwpsimpleaccounting_basics', '2' );
		$this->settingFields->pagination_per_page_data    = $this->cbxsettings->get_option( 'cbxlog_paging_per_page', 'cbxwpsimpleaccounting_log', '50' );
		$this->settingFields->cbxacc_cat_color            = $this->cbxsettings->get_option( 'cbxacc_category_color', 'cbxwpsimpleaccounting_category', 'on' );

	}

	/*
	 * Callback for collumn id
	 *
	 * @param array $item
	 *
	 * @return string
	 */


	function column_id( $item ) {
		return $item['id'];
	}


	/**
	 * Callback for collumn title
	 *
	 * @param array $item
	 *
	 * @return string
	 */

	function column_cbxexpinctitle( $item ) {
		return '<strong><a target="_blank" href="' . get_admin_url() . 'admin.php?page=cbxwpsimpleaccountinglog&id=' . $item['id'] . '&view=1">' . esc_html( $item['title'] ) . '</a></strong>';

	}


	/**
	 * Callback for collumn amount
	 *
	 * @param array $item
	 *
	 * @return string
	 */

	function column_cbxexpincamount( $item ) {
		return CBXWpsimpleaccountingHelper::format_value_quick( $item['amount'] );
	}

	/**
	 * Callback for collumn type
	 *
	 * @param array $item
	 *
	 * @return string
	 */

	function column_cbxtype( $item ) {
		$type = intval( $item['type'] );

		return ( $type == 1 ) ? '<span class="cbxwpsimpleaccounting_type_'.$type.'">'.esc_html__( 'Income', 'cbxwpsimpleaccounting' ).'</span>' : '<span class="cbxwpsimpleaccounting_type_'.$type.'">'.esc_html__( 'Expense', 'cbxwpsimpleaccounting' ).'</span>';
	}

	/**
	 * Callback for collumn category id or category title
	 *
	 * @param array $item
	 *
	 * @return string
	 */

	function column_cbxexpinccat( $item ) {

		$filterby_category_url = add_query_arg(
			array(
				'cbxlogexpinc_type'     => intval( $item['type'] ),
				'cbxlogexpinc_category' => intval( $item['catid'] ),
			)
		);

		$row_style = '';
		if ( $this->settingFields->cbxacc_cat_color == 'on' ) {
			$cat_color = $item['catcolor'];
			$row_style .= ' style = " color: ' . $cat_color . ' !important;"';
		}



		return '<a '.$row_style.' href="' . $filterby_category_url . '">' . esc_html( wp_unslash( $item['cattitle'] ) ) . '</a>';
	}

	/**
	 * Callback for collumn account
	 *
	 * @param array $item
	 *
	 * @return string
	 */

	function column_cbxexpincaccount( $item ) {

		$filterby_account_url = add_query_arg(
			array(
				'cbxlogexpinc_account' => intval( $item['account'] ),
			)
		);

		return ( $item['accountname'] == '' ) ? esc_html__( 'N/A', 'cbxwpsimpleaccounting' ) : '<a href="' . $filterby_account_url . '">' . esc_html( wp_unslash( $item['accountname'] ) ) . '</a>';
	}


	/**
	 * Callback for collumn add_by
	 *
	 * @param array $item
	 *
	 * @return string
	 */

	function column_cbxexpincaddby( $item ) {
		if ( intval( $item['add_by'] ) > 0 ) {
			$filterby_addby_url = add_query_arg(
				array(
					'cbxlogexpinc_addby' => intval( $item['add_by'] ),
				)
			);

			$add_by_user = get_user_by( 'id', $item['add_by'] );

			return '<a href="' . $filterby_addby_url . '">' . esc_attr( wp_unslash( $add_by_user->display_name ) ) . '</a>' . '<a target="_blank" class="cbxeditexpinc_edit_icon" href="' . get_edit_user_link( $item['add_by'] ) . '"></a>';
		}
	}//end method column_cbxexpincaddby

	/**
	 * Callback for collumn mod_by
	 *
	 * @param array $item
	 *
	 * @return string
	 */

	function column_cbxexpincmodby( $item ) {
		if ( intval( $item['mod_by'] ) ) {
			$mod_by_user = get_user_by( 'id', $item['mod_by'] );
			if ( $mod_by_user !== false ) {
				return '<a href="' . get_edit_user_link( $item['mod_by'] ) . '">' . esc_attr( wp_unslash( $mod_by_user->display_name ) ) . '</a>';
			}

		}

		return esc_html__( 'N/A', 'cbxwpsimpleaccounting' );
	}

	/**
	 * Callback for collumn add_date
	 *
	 * @param array $item
	 *
	 * @return string
	 */

	function column_cbxexpincadddate( $item ) {

		return $item['add_date'];
	}

	/**
	 * Callback for collumn mod_date
	 *
	 * @param array $item
	 *
	 * @return string
	 */

	function column_cbxexpincmoddate( $item ) {

		return ( $item['mod_date'] == '' || $item['mod_date'] == null ) ? esc_html__( 'N/A', 'cbxwpsimpleaccounting' ) : $item['mod_date'];
	}

	/**
	 * Callback for collumn source_amount
	 *
	 * @param array $item
	 *
	 * @return string
	 */

	function column_cbxsourceamt( $item ) {
		return ( ( $item['source_amount'] > 0 ) ? $item['source_amount'] : esc_html__( 'N/A', 'cbxwpsimpleaccounting' ) ) . ( ( $item['source_currency'] != 'none' ) ? esc_html( $item['source_currency'] ) : '' );
	}

	/**
	 * Callback for collumn tax
	 *
	 * @param array $item
	 *
	 * @return string
	 */

	function column_cbxexpinctax( $item ) {
		return $item['tax'];
	}

	/**
	 * Callback for collumn tax
	 *
	 * @param array $item
	 *
	 * @return string
	 */

	function column_cbxfinalamt( $item ) {
		$type = intval( $item['type'] );

		$final_amount =  ( $item['tax'] != null && $item['istaxincluded'] == 1 ) ?
			CBXWpsimpleaccountingHelper::format_value_quick( $item['amount'] + ( $item['amount'] * $item['tax'] ) / 100 ) :
			CBXWpsimpleaccountingHelper::format_value_quick( $item['amount'] );


		return '<span class="cbxwpsimpleaccounting_type_'.$type.'">'.$final_amount.'</span>';
	}//end column_cbxfinalamt

	/**
	 * Callback for collumn invoiceno
	 *
	 * @param array $item
	 *
	 * @return string
	 */

	function column_cbxinvoiceno( $item ) {
		return $item['invoice'];
	}

	/**
	 * Callback for  action
	 *
	 * @param array $item
	 *
	 * @return string
	 */

	function column_cbxaction( $item ) {
		$setting              = $this->cbxsettings;
		$allow_protected_edit = $setting->get_option( 'allow_protected_edit', 'cbxwpsimpleaccounting_basics', 'off' );

		$action_output = '';


		if ( current_user_can( 'edit_cbxaccounting' ) && ( ( isset( $item['protected'] ) && intval( $item['protected'] ) == 0 ) || ( isset( $item['protected'] ) && intval( $item['protected'] ) == 1 && $allow_protected_edit == 'on' ) ) ) {

			$action_output .= '<a target="_blank" class="cbxeditexpinc cbxeditexpinc_edit_icon" href="' . get_admin_url() . 'admin.php?page=cbxwpsimpleaccounting_addexpinc&id=' . $item['id'] . '" title="' . esc_html__( 'Edit', 'cbxwpsimpleaccounting' ) . '"></a>';
		}

		if ( current_user_can( 'delete_cbxaccounting' ) ) {
			$action_output .= ' <a data-busy="0" class="cbxdelexpinc"  id="' . $item['id'] . '" href="#" title="' . esc_html__( 'Delete', 'cbxwpsimpleaccounting' ) . '"></a>';
		}


		return $action_output;
	}


	/** ************************************************************************
	 * REQUIRED if displaying checkboxes or using bulk actions! The 'cb' column
	 * is given special treatment when columns are processed. It ALWAYS needs to
	 * have it's own method.
	 *
	 * @param array $item A singular item (one full row's worth of data)
	 *
	 * @return string Text to be placed inside the column <td> (movie title only)
	 **************************************************************************@see WP_List_Table::::single_row_columns()
	 *
	 */
	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			/*$1%s*/
			$this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
			/*$2%s*/
			$item['id']                //The value of the checkbox should be the record's id
		);
	}

	/** ************************************************************************
	 * Recommended. This method is called when the parent class can't find a method
	 * specifically build for a given column. Generally, it's recommended to include
	 * one method for each column you want to render, keeping your package class
	 * neat and organized. For example, if the class needs to process a column
	 * named 'title', it would first see if a method named $this->column_title()
	 * exists - if it does, that method will be used. If it doesn't, this one will
	 * be used. Generally, you should try to use custom column methods as much as
	 * possible.
	 *
	 * Since we have defined a column_title() method later on, this method doesn't
	 * need to concern itself with any column with a name of 'title'. Instead, it
	 * needs to handle everything else.
	 *
	 * For more detailed insight into how columns are handled, take a look at
	 * WP_List_Table::single_row_columns()
	 *
	 * @param array $item A singular item (one full row's worth of data)
	 * @param array $column_name The name/slug of the column to be processed
	 *
	 * @return string Text or HTML to be placed inside the column <td>
	 **************************************************************************/
	function column_default( $item, $column_name ) {

		switch ( $column_name ) {
			case 'id':
				return $item[ $column_name ];
			case 'cbxexpinctitle':
				return $item[ $column_name ];
			case 'cbxexpincamount':
				return $item[ $column_name ];
			case 'cbxtype':
				return $item[ $column_name ];
			case 'cbxexpinccat':
				return $item[ $column_name ];
			case 'cbxexpincaccount':
				return $item[ $column_name ];
			case 'cbxexpincaddby':
				return $item[ $column_name ];
			case 'cbxexpincmodby':
				return $item[ $column_name ];
			case 'cbxexpincadddate':
				return $item[ $column_name ];
			case 'cbxexpincmoddate':
				return $item[ $column_name ];
			case 'cbxsourceamt':
				return $item[ $column_name ];
			case 'cbxexpinctax':
				return $item[ $column_name ];
			case 'cbxfinalamt':
				return $item[ $column_name ];
			case 'cbxinvoiceno':
				return $item[ $column_name ];
			case 'cbxaction':
				return $item[ $column_name ];
			default:
				$hooks_column = '';
				$hooks_column = apply_filters( 'cbxwpsimpleaccountinglog_listing_column_default', $hooks_column, $item, $column_name, $this );
				if ( $hooks_column != '' ) {
					return $hooks_column;
				} else {
					return print_r( $item, true );
				}
		}
	}


	function get_columns() {
		$columns = array(
			'cb'               => '<input type="checkbox" />', //Render a checkbox instead of text
			'id'               => esc_html__( 'ID', 'cbxwpsimpleaccounting' ),
			'cbxexpinctitle'   => esc_html__( 'Title', 'cbxwpsimpleaccounting' ),
			'cbxexpincamount'  => esc_html__( 'Amount', 'cbxwpsimpleaccounting' ),
			'cbxtype'          => esc_html__( 'Type', 'cbxwpsimpleaccounting' ),
			'cbxexpinccat'     => esc_html__( 'Category', 'cbxwpsimpleaccounting' ),
			'cbxexpincaccount' => esc_html__( 'Account', 'cbxwpsimpleaccounting' ),
			'cbxexpincaddby'   => esc_html__( 'Add By', 'cbxwpsimpleaccounting' ),
			'cbxexpincmodby'   => esc_html__( 'Mod By', 'cbxwpsimpleaccounting' ),
			'cbxexpincadddate' => esc_html__( 'Added', 'cbxwpsimpleaccounting' ),
			'cbxexpincmoddate' => esc_html__( 'Modified', 'cbxwpsimpleaccounting' ),
			'cbxsourceamt'     => esc_html__( 'Source Amt.', 'cbxwpsimpleaccounting' ),
			'cbxexpinctax'     => esc_html__( 'Tax%', 'cbxwpsimpleaccounting' ),
			'cbxfinalamt'      => esc_html__( 'Final Amt.', 'cbxwpsimpleaccounting' ),
			'cbxinvoiceno'     => esc_html__( 'Invoice No.', 'cbxwpsimpleaccounting' ),
			'cbxaction'        => esc_html__( 'Action', 'cbxwpsimpleaccounting' ),
		);


		return apply_filters( 'cbxwpsimpleaccountinglog_listing_columns', $columns, $this );
	}


	function get_sortable_columns() {
		$sortable_columns = array(
			'id'               => array( 'c.id', false ),
			'cbxexpinctitle'   => array( 'c.title', false ),
			'cbxexpincamount'  => array( 'c.amount', false ),
			'cbxtype'          => array( 'c.type', false ),
			'cbxexpinccat'     => array( 'cat.title', false ),
			'cbxexpincaccount' => array( 'c.account', false ),
			'cbxexpincaddby'   => array( 'c.add_by', false ),
			'cbxexpincmodby'   => array( 'c.mod_by', false ),
			'cbxexpincadddate' => array( 'c.add_date', false ),
			'cbxexpincmoddate' => array( 'c.mod_date', false ),
			'cbxsourceamt'     => array( 'c.source_amount', false ),
			'cbxexpinctax'     => array( 'c.tax', false ),
		);

		return apply_filters( 'cbxwpsimpleaccountinglog_listing_sortable_columns', $sortable_columns, $this );
		//return $sortable_columns;
	}


	function get_bulk_actions() {
		$bulk_actions = apply_filters(
			'cbxwpsimpleaccountinglog_bulk_action', array(
				'delete' => esc_html__( 'Delete', 'cbxwpsimpleaccounting' )
			)
		);

		return $bulk_actions;
	}


	function process_bulk_action() {

		// security check!
		if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {

			$nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
			$action = 'bulk-' . $this->_args['plural'];

			if ( ! wp_verify_nonce( $nonce, $action ) ) {
				wp_die( 'Nope! Security check failed!' );
			}

		}


		$current_action = $this->current_action();
		//Detect when a bulk action is being triggered...
		if ( 'delete' === $current_action ) {

			if ( ! empty( $_REQUEST['cbxaccountinglog'] ) ) {
				global $wpdb;
				$cbxexpinc_table  = $wpdb->prefix . 'cbaccounting_expinc'; //expinc table name
				$expcat_rel_table = $wpdb->prefix . 'cbaccounting_expcat_rel'; //cat incexp rel table

				$results = $_REQUEST['cbxaccountinglog'];

				foreach ( $results as $id ) {
					$id = (int) $id;

					//pre-process hook before delete
					do_action( 'cbxwpsimpleaccounting_log_delete_before', $id );

					$delete_result = $wpdb->delete( $cbxexpinc_table, array( 'id' => $id ), array( '%d' ) );
					if ( $delete_result !== false ) {
						//post process hook on successful delete
						do_action( 'cbxwpsimpleaccounting_log_delete_after', $id );

						//pre-process hook before delete
						//delete from category incexpense rel table after delete any log
						do_action( 'cbxwpsimpleaccounting_log_rel_delete_before', $id );
						$delete_cat_rel = $wpdb->delete( $expcat_rel_table, array( 'expinc_id' => $id ), array( '%d' ) );
						if ( $delete_cat_rel !== false ) {
							//post-process hook before delete
							do_action( 'cbxwpsimpleaccounting_log_rel_delete_after', $id );
						} else {
							//post-process hook on delete failed of log rel
							do_action( 'cbxwpsimpleaccounting_log_rel_delete_failed', $id );
						}
					} else {

						//post process hook on delete failure
						do_action( 'cbxwpsimpleaccounting_log_delete_failed', $id );
					}
				}
			}

		}

	}


	/** ************************************************************************
	 * REQUIRED! This is where you prepare your data for display. This method will
	 * usually be used to query the database, sort and filter the data, and generally
	 * get it ready to be displayed. At a minimum, we should set $this->items and
	 * $this->set_pagination_args(), although the following properties and methods
	 * are frequently interacted with here...
	 *
	 * @global WPDB $wpdb
	 * @uses $this->_column_headers
	 * @uses $this->items
	 * @uses $this->get_columns()
	 * @uses $this->get_sortable_columns()
	 * @uses $this->get_pagenum()
	 * @uses $this->set_pagination_args()
	 **************************************************************************/
	function prepare_items() {
		$this->process_bulk_action();

		global $wpdb; //This is used only if making any database queries

		$user   = get_current_user_id();
		$screen = get_current_screen();


		$current_page = $this->get_pagenum();

		$option_name = $screen->get_option( 'per_page', 'option' ); //the core class name is WP_Screen

		$per_page = intval( get_user_meta( $user, $option_name, true ) );

		if ( $per_page == 0 ) {
			$per_page = intval( $screen->get_option( 'per_page', 'default' ) );
		}


		$columns  = $this->get_columns();
		$hidden   = array();
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array( $columns, $hidden, $sortable );


		$order    = ( isset( $_REQUEST['order'] ) && $_REQUEST['order'] != '' ) ? $_REQUEST['order'] : 'desc';
		$order_by = ( isset( $_REQUEST['orderby'] ) && $_REQUEST['orderby'] != '' ) ? $_REQUEST['orderby'] : 'c.id';


		//more filters
		$type        = isset( $_REQUEST['cbxlogexpinc_type'] ) ? absint( $_REQUEST['cbxlogexpinc_type'] ) : 0; //type
		$category    = isset( $_REQUEST['cbxlogexpinc_category'] ) ? absint( $_REQUEST['cbxlogexpinc_category'] ) : 0; //category
		$date_from   = isset( $_REQUEST['cbxlogfromDate'] ) ? $_REQUEST['cbxlogfromDate'] : date( 'Y-m-01' ); //date from
		$date_to     = isset( $_REQUEST['cbxlogtoDate'] ) ? $_REQUEST['cbxlogtoDate'] : date( 'Y-m-d' ); //date end
		$date_enable = isset( $_REQUEST['cbxlogenableDaterange'] ) ? sanitize_text_field( $_REQUEST['cbxlogenableDaterange'] ) : ''; //enable date range

		//account and user (new from v1.0.10)
		$account    = isset( $_REQUEST['cbxlogexpinc_account'] ) ? absint( $_REQUEST['cbxlogexpinc_account'] ) : 0; //account
		$user_addby = isset( $_REQUEST['cbxlogexpinc_addby'] ) ? absint( $_REQUEST['cbxlogexpinc_addby'] ) : 0; //log added by user

		$data        = CBXWpsimpleaccountingHelper::getLogData( $type, $category, $date_from, $date_to, $date_enable, $account, $user_addby, $order_by, $order, $per_page, $current_page );
		$total_items = CBXWpsimpleaccountingHelper::getLogDataCount( $type, $category, $date_from, $date_to, $date_enable, $account, $user_addby, $order_by, $order, $per_page, $current_page );


		$this->items = $data;




		/**
		 * REQUIRED. We also have to register our pagination options & calculations.
		 */
		$this->set_pagination_args(
			array(
				'total_items' => $total_items,                  //WE have to calculate the total number of items
				'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
				'total_pages' => ceil( $total_items / $per_page )   //WE have to calculate the total number of pages
			)
		);
	}//end prepare_items

	protected function pagination( $which ) {

		if ( empty( $this->_pagination_args ) ) {
			return;
		}

		$total_items     = $this->_pagination_args['total_items'];
		$total_pages     = $this->_pagination_args['total_pages'];
		$infinite_scroll = false;
		if ( isset( $this->_pagination_args['infinite_scroll'] ) ) {
			$infinite_scroll = $this->_pagination_args['infinite_scroll'];
		}

		if ( 'top' === $which && $total_pages > 1 ) {
			$this->screen->render_screen_reader_content( 'heading_pagination' );
		}

		$output = '<span class="displaying-num">' . sprintf( _n( '%s item', '%s items', $total_items ), number_format_i18n( $total_items ) ) . '</span>';

		$current              = $this->get_pagenum();
		$removable_query_args = wp_removable_query_args();

		$current_url = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );

		$current_url = remove_query_arg( $removable_query_args, $current_url );

		$page_links = array();

		$total_pages_before = '<span class="paging-input">';
		$total_pages_after  = '</span></span>';

		$disable_first = $disable_last = $disable_prev = $disable_next = false;

		if ( $current == 1 ) {
			$disable_first = true;
			$disable_prev  = true;
		}
		if ( $current == 2 ) {
			$disable_first = true;
		}
		if ( $current == $total_pages ) {
			$disable_last = true;
			$disable_next = true;
		}
		if ( $current == $total_pages - 1 ) {
			$disable_last = true;
		}

		//more filters
		$type        = isset( $_REQUEST['cbxlogexpinc_type'] ) ? absint( $_REQUEST['cbxlogexpinc_type'] ) : 0; //type
		$category    = isset( $_REQUEST['cbxlogexpinc_category'] ) ? absint( $_REQUEST['cbxlogexpinc_category'] ) : 0; //category
		$date_from   = isset( $_REQUEST['cbxlogfromDate'] ) ? $_REQUEST['cbxlogfromDate'] : date( 'Y-m-01' ); //date from
		$date_to     = isset( $_REQUEST['cbxlogtoDate'] ) ? $_REQUEST['cbxlogtoDate'] : date( 'Y-m-d' ); //date end
		$date_enable = isset( $_REQUEST['cbxlogenableDaterange'] ) ? sanitize_text_field( $_REQUEST['cbxlogenableDaterange'] ) : ''; //enable date range

		$cbxlogexpinc_vc_val = isset( $_REQUEST['cbxlogexpinc_vc'] ) ? absint( $_REQUEST['cbxlogexpinc_vc'] ) : 0;

		//account and user (new from v1.0.10)
		$account    = isset( $_REQUEST['cbxlogexpinc_account'] ) ? absint( $_REQUEST['cbxlogexpinc_account'] ) : 0; //account
		$user_addby = isset( $_REQUEST['cbxlogexpinc_addby'] ) ? absint( $_REQUEST['cbxlogexpinc_addby'] ) : 0; //log added by user

		$pagination_params = array();

		if ( $type !== 0 ) {
			$pagination_params['cbxlogexpinc_type'] = $type;
		}
		if ( $category !== 0 ) {
			$pagination_params['cbxlogexpinc_category'] = $category;
		}
		if ( $account !== 0 ) {
			$pagination_params['cbxlogexpinc_account'] = $account;
		}
		if ( $user_addby !== 0 ) {
			$pagination_params['cbxlogexpinc_addby'] = $user_addby;
		}
		if ( $cbxlogexpinc_vc_val !== 0 ) {
			$pagination_params['cbxlogexpinc_vc'] = $cbxlogexpinc_vc_val;
		}

		if ( $date_enable == 'cbxlogenable' ) {
			$pagination_params['cbxlogenableDaterange'] = $date_enable;
			$pagination_params['cbxlogfromDate']        = $date_from;
			$pagination_params['cbxlogtoDate']          = $date_to;
		}

		$pagination_params = apply_filters( 'cbxwpsimpleaccounting_admin_log_pagination_params', $pagination_params );

		if ( $disable_first ) {
			$page_links[] = '<span class="tablenav-pages-navspan" aria-hidden="true">&laquo;</span>';
		} else {
			$page_links[] = sprintf( "<a class='first-page' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>%s</span></a>",
				esc_url( remove_query_arg( 'paged', $current_url ) ),
				__( 'First page' ),
				'&laquo;'
			);
		}

		if ( $disable_prev ) {
			$page_links[] = '<span class="tablenav-pages-navspan" aria-hidden="true">&lsaquo;</span>';
		} else {
			$pagination_params['paged'] = max( 1, $current - 1 );

			$page_links[] = sprintf( "<a class='prev-page' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>%s</span></a>",
				esc_url( add_query_arg( $pagination_params, $current_url ) ),
				__( 'Previous page' ),
				'&lsaquo;'
			);
		}

		if ( 'bottom' === $which ) {
			$html_current_page  = $current;
			$total_pages_before = '<span class="screen-reader-text">' . __( 'Current Page' ) . '</span><span id="table-paging" class="paging-input"><span class="tablenav-paging-text">';
		} else {
			$html_current_page = sprintf( "%s<input class='current-page' id='current-page-selector' type='text' name='paged' value='%s' size='%d' aria-describedby='table-paging' /><span class='tablenav-paging-text'>",
				'<label for="current-page-selector" class="screen-reader-text">' . __( 'Current Page' ) . '</label>',
				$current,
				strlen( $total_pages )
			);
		}
		$html_total_pages = sprintf( "<span class='total-pages'>%s</span>", number_format_i18n( $total_pages ) );
		$page_links[]     = $total_pages_before . sprintf( _x( '%1$s of %2$s', 'paging' ), $html_current_page, $html_total_pages ) . $total_pages_after;

		if ( $disable_next ) {
			$page_links[] = '<span class="tablenav-pages-navspan" aria-hidden="true">&rsaquo;</span>';
		} else {
			$pagination_params['paged'] = min( $total_pages, $current + 1 );

			$page_links[] = sprintf( "<a class='next-page' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>%s</span></a>",
				esc_url( add_query_arg( $pagination_params, $current_url ) ),
				__( 'Next page' ),
				'&rsaquo;'
			);
		}

		if ( $disable_last ) {
			$page_links[] = '<span class="tablenav-pages-navspan" aria-hidden="true">&raquo;</span>';
		} else {
			$pagination_params['paged'] = $total_pages;

			$page_links[] = sprintf( "<a class='last-page' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>%s</span></a>",
				esc_url( add_query_arg( $pagination_params, $current_url ) ),
				__( 'Last page' ),
				'&raquo;'
			);
		}

		$pagination_links_class = 'pagination-links';
		if ( ! empty( $infinite_scroll ) ) {
			$pagination_links_class = ' hide-if-js';
		}
		$output .= "\n<span class='$pagination_links_class'>" . join( "\n", $page_links ) . '</span>';

		if ( $total_pages ) {
			$page_class = $total_pages < 2 ? ' one-page' : '';
		} else {
			//$page_class = ' no-pages';
			$page_class = ' ';
		}
		$this->_pagination = "<div class='tablenav-pages{$page_class}'>$output</div>";

		echo $this->_pagination;
	}//end pagination

	/**
	 * Generates content for a single row of the table
	 *
	 * @param object $item The current item
	 *
	 * @since  3.1.0
	 * @access public
	 *
	 */
	public function single_row( $item ) {

		$row_style = '';
		/*if ( $this->settingFields->cbxacc_cat_color == 'on' ) {
			$row_style .= ' style = " color: ' . $item['catcolor'] . ';"';
		}*/


		echo '<tr id="cbxexpinc_row_' . $item['id'] . '" ' . $row_style . '>';
		$this->single_row_columns( $item );
		echo '</tr>';
	}//end single_row
}//end class CBXWpsimpleaccountinglogListTable