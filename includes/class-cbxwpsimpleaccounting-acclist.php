<?php

	if ( ! class_exists( 'WP_List_Table' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
	}


	class CBXWpsimpleaccountingAccListTable extends WP_List_Table {

		protected $cbxsettings = '';
		protected $settingFields = '';


		/** ************************************************************************
		 * REQUIRED. Set up a constructor that references the parent constructor. We
		 * use the parent reference to set some default configs.
		 ***************************************************************************/
		function __construct( $setting_ref ) {


			$this->cbxsettings   = $setting_ref;
			$this->settingFields = new stdClass();


			//Set parent defaults
			parent::__construct(
				array(
					'singular' => 'cbxaccountingacc',     //singular name of the listed records
					'plural'   => 'cbxaccountingaccs',    //plural name of the listed records
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

		/**
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
		function column_title( $item ) {

			return '<strong><a target="_blank" href="' . get_admin_url() . 'admin.php?page=cbxwpsimpleaccounting_accmanager&id=' . $item['id'] . '&view=addedit">' . esc_html( $item['title'] ) . '</a></strong>';

		}


		/**
		 * Callback for collumn type
		 *
		 * @param array $item
		 *
		 * @return string
		 */
		function column_type( $item ) {

			return ( stripslashes( $item['type'] ) == 'cash' ) ? esc_html__( 'Cash', 'cbxwpsimpleaccounting' ) : esc_html__( 'Bank', 'cbxwpsimpleaccounting' );
		}

		/**
		 * Callback for collumn account no
		 *
		 * @param array $item
		 *
		 * @return string
		 */
		function column_acc_no( $item ) {

			return wp_unslash( $item['acc_no'] );
		}

		/**
		 * Callback for collumn account name
		 *
		 * @param array $item
		 *
		 * @return string
		 */
		function column_acc_name( $item ) {

			return wp_unslash( $item['acc_name'] );
		}

		/**
		 * Callback for collumn bank name
		 *
		 * @param array $item
		 *
		 * @return string
		 */
		function column_bank_name( $item ) {

			return wp_unslash( $item['bank_name'] );
		}

		/**
		 * Callback for collumn branch name
		 *
		 * @param array $item
		 *
		 * @return string
		 */
		function column_branch_name( $item ) {
			return wp_unslash( $item['branch_name'] );
		}


		/**
		 * Callback for collumn add_by
		 *
		 * @param array $item
		 *
		 * @return string
		 */
		function column_addby( $item ) {
			if(intval($item['add_by']) > 0){
				$add_by_user = get_user_by( 'id', $item['add_by'] );
				if($add_by_user !== false){
					return '<a target="_blank" href="' . get_edit_user_link( $item['add_by'] ) . '">' . wp_unslash( $add_by_user->display_name ) . '</a>';
				}
			}

			return esc_html__( 'N/A', 'cbxwpsimpleaccounting' );
		}

		/**
		 * Callback for collumn mod_by
		 *
		 * @param array $item
		 *
		 * @return string
		 */
		function column_modby( $item ) {
			if ( intval($item['mod_by']) > 0 ) {
				$mod_by_user = get_user_by( 'id', $item['mod_by'] );

				if($mod_by_user != false){
					return '<a href="' . get_edit_user_link( $item['mod_by'] ) . '">' . wp_unslash( $mod_by_user->display_name ) . '</a>';
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
		function column_adddate( $item ) {

			return esc_attr($item['add_date']);
		}

		/**
		 * Callback for collumn mod_date
		 *
		 * @param array $item
		 *
		 * @return string
		 */

		function column_moddate( $item ) {

			return ( $item['mod_date'] == '' || $item['mod_date'] == null ) ? esc_html__( 'N/A', 'cbxwpsimpleaccounting' ) : esc_attr($item['mod_date']);
		}


		/**
		 * Callback for collumn 'published'
		 *
		 * @param array $item
		 *
		 * @return string
		 */

		function column_publish( $item ) {

			$status = intval( $item['publish'] );

			$states_list = array(
				'0' => esc_html__( 'Yes', 'cbxwpsimpleaccounting' ),
				'1' => esc_html__( 'No', 'cbxwpsimpleaccounting' ),
			);


			return isset( $states_list[ $status ] ) ? $states_list[ $status ] : esc_html__( 'N/A', 'cbxwpsimpleaccounting' );
		}


		function column_cb( $item ) {
			return sprintf(
				'<input type="checkbox" name="%1$s[]" value="%2$s" />',
				/*$1%s*/
				$this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
				/*$2%s*/
				$item['id']                //The value of the checkbox should be the record's id
			);
		}


		/**
		 * Get default value for column if not specific function
		 *
		 * @param object $item
		 * @param string $column_name
		 *
		 * @return mixed|string|void
		 */
		function column_default( $item, $column_name ) {
			switch ( $column_name ) {
				case 'id':
					return $item[ $column_name ];
				case 'title':
					return $item[ $column_name ];
				case 'type':
					return $item[ $column_name ];
				case 'acc_no':
					return $item[ $column_name ];
				case 'acc_name':
					return $item[ $column_name ];
				case 'bank_name':
					return $item[ $column_name ];
				case 'branch_name':
					return $item[ $column_name ];
				case 'addby':
					return $item[ $column_name ];
				case 'modby':
					return $item[ $column_name ];
				case 'adddate':
					return $item[ $column_name ];
				case 'moddate':
					return $item[ $column_name ];
				default:
					$hooks_column = '';
					$hooks_column = apply_filters( 'cbxwpsimpleaccountingacc_listing_column_default', $hooks_column, $item, $column_name, $this );
					if ( $hooks_column != '' ) {
						return $hooks_column;
					} else {
						return print_r( $item, true );
					}
			}
		}

		/**
		 * Add extra markup in the toolbars before or after the list
		 *
		 * @param string $which , helps you decide if you add the markup after (bottom) or before (top) the list
		 */
		function extra_tablenav( $which ) {
			if ( $which == "top" ) {
				if ( defined('CBXPHPSPREADSHEET_PLUGIN_NAME') && file_exists( CBXPHPSPREADSHEET_ROOT_PATH . 'lib/vendor/autoload.php' ) ) {
				    ?>
                    <p><select name="format" class="cbxformataccount">
                            <option id="formatXLS" value="xls"><?php esc_html_e( 'XLS', 'cbxwpsimpleaccounting' ); ?></option>
							<option id="formatXLSX" value="xlsx"><?php esc_html_e( 'XLSX', 'cbxwpsimpleaccounting' ); ?></option>
							<option id="formatODS" value="ods"><?php esc_html_e( 'ODS', 'cbxwpsimpleaccounting' ); ?></option>
						</select>
                        <input type="submit" name="cbxwpsimpleaccounting_accounts_export" id="csvExport" class="button"   value="<?php esc_html_e('Export', 'cbxwpsimpleaccounting'); ?>" />
                    </p>
                    <?php
                }
				?>

				<?php
			}
		}


		/**
		 * Get column and titles
		 *
		 * @return mixed|void
		 */
		function get_columns() {
			$columns = array(
				'cb'          => '<input type="checkbox" />', //Render a checkbox instead of text
				'title'       => esc_html__( 'Title', 'cbxwpsimpleaccounting' ),
				'type'        => esc_html__( 'Type', 'cbxwpsimpleaccounting' ),
				'acc_no'      => esc_html__( 'Acc. No.', 'cbxwpsimpleaccounting' ),
				'acc_name'    => esc_html__( 'Acc. Name', 'cbxwpsimpleaccounting' ),
				'bank_name'   => esc_html__( 'Bank Name', 'cbxwpsimpleaccounting' ),
				'branch_name' => esc_html__( 'Bank Branch', 'cbxwpsimpleaccounting' ),
				'addby'       => esc_html__( 'Add By', 'cbxwpsimpleaccounting' ),
				'modby'       => esc_html__( 'Mod By', 'cbxwpsimpleaccounting' ),
				'adddate'     => esc_html__( 'Added', 'cbxwpsimpleaccounting' ),
				'moddate'     => esc_html__( 'Modified', 'cbxwpsimpleaccounting' ),
				'id'          => esc_html__( 'ID', 'cbxwpsimpleaccounting' )
			);

			return apply_filters( 'cbxwpsimpleaccountingacc_listing_columns', $columns, $this );
		}


		/**
		 * Get sortable column
		 *
		 * @return mixed|void
		 */
		function get_sortable_columns() {
			$sortable_columns = array(
				'id'          => array( 'a.id', false ),
				'title'       => array( 'a.title', false ),
				'type'        => array( 'a.type', false ),
				'acc_no'      => array( 'a.acc_no', false ),
				'acc_name'    => array( 'a.acc_name', false ),
				'bank_name'   => array( 'a.bank_name', false ),
				'branch_name' => array( 'a.branch_name', false ),
				'addby'       => array( 'a.add_by', false ),
				'modby'       => array( 'a.mod_by', false ),
				'adddate'     => array( 'a.add_date', false ),
				'moddate'     => array( 'a.mod_date', false ),
			);

			return apply_filters( 'cbxwpsimpleaccountingacc_listing_sortable_columns', $sortable_columns, $this );
		}


		function get_bulk_actions() {

			$bulk_actions = apply_filters(
				'cbxwpsimpleaccountingacc_bulk_action', array(
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

				if ( ! wp_verify_nonce( $nonce, $action ) ){
					wp_die( 'Nope! Security check failed!' );
				}


			}

			$current_action = $this->current_action();



			//Detect when a bulk action is being triggered...
			if ( 'delete' === $current_action ) {

				if ( ! empty( $_REQUEST['cbxaccountingacc'] ) ) {
					global $wpdb;
					$cbxaccmanger_table = $wpdb->prefix . 'cbaccounting_account_manager'; //account_manager table name

					$results = $_REQUEST['cbxaccountingacc'];

					$delete_response = array();

					foreach ( $results as $id ) {
						$id = (int) $id;

						$isEmpty = CBXWpsimpleaccountingHelper::isAccountEmpty($id);
						if($isEmpty == false) {
							$delete_response[] = array(
								'error' => 0,
								'msg'   => sprintf(__('Account id: %d  can not be deleted as there are log entry associated this account.', 'cbxwpsimpleaccounting'), $id)
							);

							continue;
						}

						//pre-process hook before delete
						do_action( 'cbxwpsimpleaccounting_account_delete_before', $id );

						$delete_result = $wpdb->delete( $cbxaccmanger_table, array( 'id' => $id ), array( '%d' ) );
						if ( $delete_result !== false ) {

							$delete_response[] = array(
								'error' => 0,
								'msg'   => sprintf(__('Account id: %d  deleted successfully.', 'cbxwpsimpleaccounting'), $id)
							);

							//post process hook on successful delete
							do_action( 'cbxwpsimpleaccounting_account_delete_after', $id );
						} else {


							$delete_response[] = array(
								'error' => 0,
								'msg'   => sprintf(__('Account id: %d  delete failed', 'cbxwpsimpleaccounting'), $id)
							);

							//post process hook on delete failure
							do_action( 'cbxwpsimpleaccounting_account_delete_failed', $id );
						}

					}//end for each
					$_SESSION['cbxwpsimpleaccounting_accounts_bulkdelete'] = $delete_response;
				}

			}

		}


		function prepare_items() {

			$this->process_bulk_action();

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



			$search   = ( isset( $_REQUEST['s'] ) && $_REQUEST['s'] != '' ) ? sanitize_text_field( $_REQUEST['s'] ) : '';
			$order    = ( isset( $_REQUEST['order'] ) && $_REQUEST['order'] != '' ) ? $_REQUEST['order'] : 'desc';
			$order_by = ( isset( $_REQUEST['orderby'] ) && $_REQUEST['orderby'] != '' ) ? $_REQUEST['orderby'] : 'a.id';

			//more filters
			$type = isset( $_REQUEST['cbxactacc_type'] ) ? stripslashes( $_REQUEST['cbxactacc_type'] ) : ''; //type

			$data        = CBXWpsimpleaccountingHelper::getAccountsData( $search, $type, $order_by, $order, $per_page, $current_page );
			$total_items = $this->getDataCount( $search, $type, $order_by, $order );


			$this->items = $data;


			/**
			 * REQUIRED. We also have to register our pagination options & calculations.
			 */
			$this->set_pagination_args(
				array(
					'total_items' => $total_items,
					//WE have to calculate the total number of items
					'per_page'    => $per_page,
					//WE have to determine how many items to show on a page
					'total_pages' => ceil( $total_items / $per_page )
					//WE have to calculate the total number of pages
				)
			);
		}

		/**
		 * Get total data count
		 *
		 * @param int $perpage
		 * @param int $page
		 *
		 * @return array|null|object
		 */
		function getDataCount( $search = '', $type = '', $orderby = 'a.id', $order = 'asc' ) {

			global $wpdb;


			//all table names

			$cbaccounting_acc_table = $wpdb->prefix . 'cbaccounting_account_manager'; //account manager table name


			$join = '';


			$join = apply_filters( 'cbxwpsimpleaccountingacc_listing_sql_join', $join );


			$where_sql = '';

			if ( $search != '' ) {
				if ( $where_sql != '' ) {
					$where_sql .= ' AND ';
				}
				$where_sql .= $wpdb->prepare( " a.type LIKE '%%%s%%' OR a.acc_no LIKE '%%%s%%' OR a.acc_name LIKE '%%%s%%' OR a.bank_name LIKE '%%%s%%' OR a.branch_name LIKE '%%%s%%'", $search, $search, $search, $search, $search );
			}

			//type and account filter (for account filter type needs to be specific)
			if ( $type != '' ) {
				$where_sql .= $wpdb->prepare( "a.type = %s", $type );
			}


			$where_sql = apply_filters( 'cbxwpsimpleaccountingacc_listing_sql_where', $where_sql );

			if ( $where_sql == '' ) {
				$where_sql = '1';
			}

			$sortingOrder = " ORDER BY $orderby $order ";

			$query = "SELECT COUNT(*) FROM $cbaccounting_acc_table a $join   WHERE  $where_sql $sortingOrder";

			$count = $wpdb->get_var( "$query" );

			return $count;
		}


		/**
		 * Generate the tbody element for the list table.
		 *
		 * @since  3.1.0
		 * @access public
		 */
		public function display_rows_or_placeholder() {
			if ( $this->has_items() ) {
				$this->display_rows();
			} else {
				echo '<tr class="no-items"><td class="colspanchange" colspan="' . $this->get_column_count() . '">';
				echo '<div class="notice notice-warning inline"><p>';
				$this->no_items();
				echo '</p></div>';
				echo '</td></tr>';
			}
		}


		/**
		 * Message to be displayed when there are no items
		 *
		 * @since  3.1.0
		 * @access public
		 */
		public function no_items() {
			_e( 'No Account found.', 'cbxwpsimpleaccounting' );
		}

		/**
		 * Generates content for a single row of the table
		 *
		 * @since  3.1.0
		 * @access public
		 *
		 * @param object $item The current item
		 */
		public function single_row( $item ) {

			$row_class = 'cbxaccountingacc_row';
			$row_class = apply_filters( 'cbxaccountingacc_row_class', $row_class, $item );
			echo '<tr id="cbxaccountingacc_row_' . $item['id'] . '" class="' . $row_class . '">';
			$this->single_row_columns( $item );
			echo '</tr>';
		}

		/**
		 * Get the top links before the table listing
		 *
		 * @return array
		 */
		function get_views() {

			$views   = array();
			$current = ( isset( $_REQUEST['cbxactacc_type'] ) ? $_REQUEST['cbxactacc_type'] : 'all' );


			$data = CBXWpsimpleaccountingHelper::getAccsCountByType();


			//All link
			$class        = ( $current == 'all' ? ' class="current"' : '' );
			$all_url      = remove_query_arg( 'cbxactacc_type' );
			$views['all'] = "<a href='{$all_url }' {$class} >" . sprintf( __( 'All (%d)', 'cbxwpsimpleaccounting' ), $data['total'] ) . "</a>";

			//cash link
			$foo_url       = add_query_arg( 'cbxactacc_type', 'cash' );
			$class         = ( $current == 'cash' ? ' class="current"' : '' );
			$views['cash'] = "<a href='{$foo_url}' {$class} >" . sprintf( __( 'Cash (%d)', 'cbxwpsimpleaccounting' ), $data['cash'] ) . "</a>";

			//bank link
			$bar_url       = add_query_arg( 'cbxactacc_type', 'bank' );
			$class         = ( $current == 'bank' ? ' class="current"' : '' );
			$views['bank'] = "<a href='{$bar_url}' {$class} >" . sprintf( __( 'Bank (%d)', 'cbxwpsimpleaccounting' ), $data['bank'] ) . "</a>";


			return $views;
		}
	}//end class CBXWpsimpleaccountingAccListTable