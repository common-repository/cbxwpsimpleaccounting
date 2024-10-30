<?php

	if ( ! class_exists( 'WP_List_Table' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
	}


	class CBXWpsimpleaccountingCatListTable extends WP_List_Table {



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
					'singular' => 'cbxaccountingcat',     //singular name of the listed records
					'plural'   => 'cbxaccountingcats',    //plural name of the listed records
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
			if ( isset( $item['protected'] ) && intval( $item['protected'] ) == 1 ) {
				return '<strong><a target="_blank" href="' . get_admin_url() . 'admin.php?page=cbxwpsimpleaccounting_cat&id=' . $item['id'] . '&view=view">' . esc_html( $item['title'] ) . '</a></strong>';
			} else {
				return '<strong><a target="_blank" href="' . get_admin_url() . 'admin.php?page=cbxwpsimpleaccounting_cat&id=' . $item['id'] . '&view=addedit">' . esc_html( $item['title'] ) . '</a></strong>';
			}

		}


		/**
		 * Callback for collumn type
		 *
		 * @param array $item
		 *
		 * @return string
		 */

		function column_type( $item ) {

			return ( intval( $item['type'] ) == 1 ) ? esc_html__( 'Income', 'cbxwpsimpleaccounting' ) : esc_html__( 'Expense', 'cbxwpsimpleaccounting' );
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
				if($add_by_user !==  false){
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
				if($mod_by_user !== false){
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

			return $item['add_date'];
		}

		/**
		 * Callback for collumn mod_date
		 *
		 * @param array $item
		 *
		 * @return string
		 */

		function column_moddate( $item ) {

			return ( $item['mod_date'] == '' || $item['mod_date'] == null ) ? esc_html__( 'N/A', 'cbxwpsimpleaccounting' ) : $item['mod_date'];
		}

		/**
		 * Callback for collumn 'color'
		 *
		 * @param array $item
		 *
		 * @return string
		 */

		function column_color( $item ) {

			$color = $item['color'];
			if ( $color != '' ) {
				return '<div style="background-color: ' . $color . '; display: block; width: 100%; height: 100%; padding: 5px;">&nbsp;</div>';
			}

			return esc_html__( 'N/A', 'cbxwpsimpleaccounting' );
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

		/**
		 * Callback for collumn 'protected'
		 *
		 * @param array $item
		 *
		 * @return string
		 */

		function column_protected( $item ) {

			$status = intval( $item['protected'] );

			$states_list = array(
				'0' => esc_html__( 'No', 'cbxwpsimpleaccounting' ),
				'1' => esc_html__( 'Yes', 'cbxwpsimpleaccounting' ),
			);

			$output = '';
			if ( $status == 1 ) {
				$output = '<i class="dashicons dashicons-lock"></i> ' . ( isset( $states_list[ $status ] ) ? $states_list[ $status ] : esc_html__( 'N/A', 'cbxwpsimpleaccounting' ) );
			} else {
				$output = '<i class="dashicons dashicons-unlock"></i> ' . ( isset( $states_list[ $status ] ) ? $states_list[ $status ] : esc_html__( 'N/A', 'cbxwpsimpleaccounting' ) );
			}

			return $output;
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
				case 'addby':
					return $item[ $column_name ];
				case 'modby':
					return $item[ $column_name ];
				case 'adddate':
					return $item[ $column_name ];
				case 'moddate':
					return $item[ $column_name ];
				case 'color':
					return $item[ $column_name ];
				case 'publish':
					return $item[ $column_name ];
				case 'protected':
					return $item[ $column_name ];
				default:
					$hooks_column = '';
					$hooks_column = apply_filters( 'cbxwpsimpleaccountingcat_listing_column_default', $hooks_column, $item, $column_name, $this );
					if ( $hooks_column != '' ) {
						return $hooks_column;
					} else {
						return print_r( $item, true );
					}
			}
		}


		/**
		 * Get column and titles
		 *
		 * @return mixed|void
		 */
		function get_columns() {
			$columns = array(
				'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
				'title'     => esc_html__( 'Title', 'cbxwpsimpleaccounting' ),
				'type'      => esc_html__( 'Type', 'cbxwpsimpleaccounting' ),
				'addby'     => esc_html__( 'Add By', 'cbxwpsimpleaccounting' ),
				'modby'     => esc_html__( 'Mod By', 'cbxwpsimpleaccounting' ),
				'adddate'   => esc_html__( 'Added', 'cbxwpsimpleaccounting' ),
				'moddate'   => esc_html__( 'Modified', 'cbxwpsimpleaccounting' ),
				'color'     => esc_html__( 'Color', 'cbxwpsimpleaccounting' ),
				'publish'   => esc_html__( 'Publish', 'cbxwpsimpleaccounting' ),
				'protected' => esc_html__( 'Protected', 'cbxwpsimpleaccounting' ),
				'id'        => esc_html__( 'ID', 'cbxwpsimpleaccounting' )
			);

			return apply_filters( 'cbxwpsimpleaccountingcat_listing_columns', $columns, $this );
		}


		/**
		 * Get sortable column
		 *
		 * @return mixed|void
		 */
		function get_sortable_columns() {
			$sortable_columns = array(
				'id'        => array( 'c.id', false ),
				'title'     => array( 'c.title', false ),
				'type'      => array( 'c.type', false ),
				'addby'     => array( 'c.add_by', false ),
				'modby'     => array( 'c.mod_by', false ),
				'adddate'   => array( 'c.add_date', false ),
				'moddate'   => array( 'c.mod_date', false ),
				'color'     => array( 'c.color', false ),
				'publish'   => array( 'c.publish', false ),
				'protected' => array( 'c.protected', false )
			);

			return apply_filters( 'cbxwpsimpleaccountingcat_listing_sortable_columns', $sortable_columns, $this );
		}


		function get_bulk_actions() {

			$bulk_actions = apply_filters(
				'cbxwpsimpleaccountingcat_bulk_action', array(
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


				if ( ! empty( $_REQUEST['cbxaccountingcat'] ) ) {
					global $wpdb;
					//$cbxexpinc_table  = $wpdb->prefix . 'cbaccounting_expinc'; //expinc table name
					//$expcat_rel_table = $wpdb->prefix . 'cbaccounting_expcat_rel'; //cat incexp rel table

					$cbaccounting_cat_table = $wpdb->prefix . 'cbaccounting_category'; //expinc category table name

					$results = $_REQUEST['cbxaccountingcat'];


					$delete_response = array();

					foreach ( $results as $id ) {
						$id = (int) $id;
						$isEmpty = CBXWpsimpleaccountingHelper::isCatEmpty($id);
						if($isEmpty == false) {
							$delete_response[] = array(
								'error' => 0,
								'msg'   => sprintf(__('Category id: %d  can not be deleted as there are log entry associated this category.', 'cbxwpsimpleaccounting'), $id)
							);

							continue;
						}


						//pre-process hook before delete
						do_action('cbxwpsimpleaccounting_cat_delete_before', $id);

						$delete_result = $wpdb->delete($cbaccounting_cat_table, array('id' => $id), array('%d'));
						if($delete_result !== false){
							$delete_response[] = array(
								'error' => 0,
								'msg'   => sprintf(__('Category id: %d  deleted successfully.', 'cbxwpsimpleaccounting'), $id)
							);

							//post process hook on successful delete
							do_action('cbxwpsimpleaccounting_cat_delete_after', $id);
						}
						else{

							$delete_response[] = array(
								'error' => 0,
								'msg'   => sprintf(__('Category id: %d  delete failed', 'cbxwpsimpleaccounting'), $id)
							);

							//post process hook on delete failure
							do_action('cbxwpsimpleaccounting_cat_delete_failed', $id);
						}
					}//end for each

					$_SESSION['cbxwpsimpleaccounting_cats_bulkdelete'] = $delete_response;
				}

			}

		}//end process_bulk_action


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




			$order    = ( isset( $_REQUEST['order'] ) && $_REQUEST['order'] != '' ) ? $_REQUEST['order'] : 'desc';
			$order_by = ( isset( $_REQUEST['orderby'] ) && $_REQUEST['orderby'] != '' ) ? $_REQUEST['orderby'] : 'c.id';


			//more filters
			$type = isset( $_REQUEST['cbxactcat_type'] ) ? absint( $_REQUEST['cbxactcat_type'] ) : 0; //type


			$data        = $this->getData( $type, $order_by, $order, $per_page, $current_page );
			$total_items = $this->getDataCount( $type, $order_by, $order );


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
		}//end prepare_items

		/**
		 * Get Data
		 *
		 * @param int $perpage
		 * @param int $page
		 *
		 * @return array|null|object
		 */
		function getData( $type = 0, $orderby = 'c.id', $order = 'asc', $perpage = 20, $page = 1 ) {

			global $wpdb;


			//all table names
			$cbaccounting_cat_table = $wpdb->prefix . 'cbaccounting_category'; //expinc category table name


			$join = '';
			$join = apply_filters( 'cbxwpsimpleaccountingcat_listing_sql_join', $join );

			$where_sql = '';

			//type and category filter (for category filter type needs to be specific)
			if ( $type != 0 ) {
				$where_sql .= $wpdb->prepare( "c.type = %d", absint( $type ) );
			}


			$where_sql = apply_filters( 'cbxwpsimpleaccountingcat_listing_sql_where', $where_sql );

			if ( $where_sql == '' ) {
				$where_sql = '1';
			}


			$start_point = ( $page * $perpage ) - $perpage;
			$limit_sql   = "LIMIT";
			$limit_sql   .= ' ' . $start_point . ',';
			$limit_sql   .= ' ' . $perpage;


			$sortingOrder = " ORDER BY $orderby $order ";

			$select_extra = '';
			$select_extra = apply_filters( 'cbxwpsimpleaccountingcat_listing_sql_select_extra', $select_extra );

			$query = "SELECT c.* $select_extra FROM $cbaccounting_cat_table c $join WHERE  $where_sql $sortingOrder  $limit_sql";


			$allexpincdata = $wpdb->get_results( $query, ARRAY_A );


			return $allexpincdata;
		}

		/**
		 * Get total data count
		 *
		 * @param int $perpage
		 * @param int $page
		 *
		 * @return array|null|object
		 */
		function getDataCount( $type = 0, $orderby = 'c.id', $order = 'asc' ) {

			global $wpdb;


			//all table names

			$cbaccounting_cat_table = $wpdb->prefix . 'cbaccounting_category'; //expinc category table name


			$join = '';


			$join = apply_filters( 'cbxwpsimpleaccountingcat_listing_sql_join', $join );


			$where_sql = '';


			//type and category filter (for category filter type needs to be specific)
			if ( $type != 0 ) {
				$where_sql .= $wpdb->prepare( "c.type = %d", absint( $type ) );
			}


			$where_sql = apply_filters( 'cbxwpsimpleaccountingcat_listing_sql_where', $where_sql );

			if ( $where_sql == '' ) {
				$where_sql = '1';
			}

			$sortingOrder = " ORDER BY $orderby $order ";

			$query = "SELECT COUNT(*) FROM $cbaccounting_cat_table c $join   WHERE  $where_sql $sortingOrder";

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
			esc_html_e( 'No category found.', 'cbxwpsimpleaccounting' );
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

			$row_class = 'cbxaccountingcat_row';
			$row_class = apply_filters( 'cbxaccountingcat_row_class', $row_class, $item );
			echo '<tr id="cbxaccountingcat_row_' . $item['id'] . '" class="' . $row_class . '">';
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
			$current = ( isset( $_REQUEST['cbxactcat_type'] ) ? $_REQUEST['cbxactcat_type'] : 'all' );


			$data = CBXWpsimpleaccountingHelper::getCatsCountByType();


			//All link
			$class        = ( $current == 'all' ? ' class="current"' : '' );
			$all_url      = remove_query_arg( 'cbxactcat_type' );
			$views['all'] = "<a href='{$all_url }' {$class} >" . sprintf( __( 'All (%d)', 'cbxwpsimpleaccounting' ), $data['total'] ) . "</a>";

			//income link
			$foo_url         = add_query_arg( 'cbxactcat_type', '1' );
			$class           = ( $current == '1' ? ' class="current"' : '' );
			$views['income'] = "<a href='{$foo_url}' {$class} >" . sprintf( __( 'Income (%d)', 'cbxwpsimpleaccounting' ), $data[1] ) . "</a>";

			//expense link
			$bar_url          = add_query_arg( 'cbxactcat_type', '2' );
			$class            = ( $current == '2' ? ' class="current"' : '' );
			$views['expense'] = "<a href='{$bar_url}' {$class} >" . sprintf( __( 'Expense (%s)', 'cbxwpsimpleaccounting' ), $data[2] ) . "</a>";


			return $views;
		}

		/**
		 * Pagination
		 *
		 * @param string $which
		 */
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

			$pagination_params = array();

			$search = isset( $_REQUEST['s'] ) ? esc_attr( wp_unslash( $_REQUEST['s'] ) ) : '';


			if ( $search != '' ) {
				$pagination_params['s'] = $search;
			}




			$pagination_params = apply_filters( 'cbxwpbookmark_pagination_log_params', $pagination_params );

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

	}//end class CBXWpsimpleaccountingCatListTable