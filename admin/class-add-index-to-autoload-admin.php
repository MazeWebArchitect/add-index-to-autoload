<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://raidboxes.io
 * @since      1.0.0
 *
 * @package    Add_Index_To_Autoload
 * @subpackage Add_Index_To_Autoload/admin
 */

class Add_Index_To_Autoload_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/add-index-to-autoload-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register and localize the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/add-index-to-autoload-admin.js', array( 'jquery' ), $this->version, true );

		// For localizing and noncing the "check schedule"-Ajax function
		wp_localize_script( $this->plugin_name, 'aital_check_schedule_settings', array(
			'ajax_check_failed' => __( 'There was an error executing the check', 'add-index-to-autoload'),
			'nonce' => wp_create_nonce( "aital_check_schedule_settings_nonce" ),
			'ajax_url' => admin_url( 'admin-ajax.php' )
		) );

		// For localizing and noncing the "check Index"-Ajax function
		wp_localize_script( $this->plugin_name, 'aital_check_index_settings', array(
			'check_label' => __( 'Check', 'add-index-to-autoload'),
			'checking_label' => __( 'checking', 'add-index-to-autoload'),
			'ajax_check_failed' => __( 'There was an error executing the request', 'add-index-to-autoload'),
			'nonce' => wp_create_nonce( "aital_check_index_settings_nonce" ),
			'ajax_url' => admin_url( 'admin-ajax.php' )
		) );

		// For localizing and noncing the "add Index"-Ajax function
		wp_localize_script( $this->plugin_name, 'aital_add_index_settings', array(
			'add_label' => __( 'Add Index', 'add-index-to-autoload'),
			'adding_label' => __( 'adding', 'add-index-to-autoload'),
			'ajax_check_failed' => __( 'There was an error executing the request', 'add-index-to-autoload'),
			'nonce' => wp_create_nonce( "aital_add_index_settings_nonce" ),
			'ajax_url' => admin_url( 'admin-ajax.php' )
		) );

		// For localizing and noncing the "remove Index"-Ajax function
		wp_localize_script( $this->plugin_name, 'aital_remove_index_settings', array(
			'remove_label' => __( 'Remove Index', 'add-index-to-autoload'),
			'removing_label' => __( 'removing', 'add-index-to-autoload'),
			'ajax_check_failed' => __( 'There was an error executing the request', 'add-index-to-autoload'),
			'nonce' => wp_create_nonce( "aital_remove_index_settings_nonce" ),
			'ajax_url' => admin_url( 'admin-ajax.php' )
		) );

		// For localizing and noncing the "schedule-Index-Check"-Ajax function
		wp_localize_script( $this->plugin_name, 'aital_schedule_index_check_settings', array(
			'nonce' => wp_create_nonce( "aital_schedule_index_check_settings_nonce" ),
			'ajax_check_failed' => __( 'There was an error executing the request', 'add-index-to-autoload'),
			'ajax_url' => admin_url( 'admin-ajax.php' )
		) );

	}

	/**
	 * Register any menu pages used by the plugin.
	 * @since  1.0.0
	 * @access public
	 */
	public function aital_menu_pages() {

		add_submenu_page (
			'tools.php',
			__( 'Manage: Add Index To Autoload', 'add-index-to-autoload' ),
			__( 'Add Index To Autoload', 'add-index-to-autoload' ),
			'install_plugins',
			'add-index-to-autoload',
			array( $this, 'aital_menu_pages_callback')
			);

	}

	/**
	 * The callback for creating a new submenu page under the "Tools" menu.
	 * @since  1.0.0
	 * @access public
	 */
	public function aital_menu_pages_callback() {

		// Display this page:
		require_once AITAL_PATH. 'admin/partials/add-index-to-autoload-admin-display.php';

	}


	public function aital_check_if_index_exists() {

		// Define the global wpdb object
		global $wpdb;

		// Query the WordPress database for the indexes auf *_options
		$optionsindex = $wpdb->get_results('SHOW INDEX FROM '.esc_sql($wpdb->options) );

		// If the whole options table has no index halt and return false
		if ( empty($optionsindex) || !is_array($optionsindex) ) {
			return false;
		}

		// If there a indexes found, loop through them
		foreach ( $optionsindex as $index ) {

			// Check properties
			if ( ! is_object( $index ) || ! isset( $index->Key_name ) || ! isset( $index->Column_name ) ) {
				continue;
			}

			// Check if the autoload row has an index in key and column name, only than return true
			if ( 'autoload' == $index->Key_name && 'autoload' == $index->Column_name ) {
				return true;
			}
		}

		// If everything fails return false
		return false;

	}

	// The function to process the aital_check_if_index_exists()-check
	public function aital_check() {
		check_ajax_referer( 'aital_check_index_settings_nonce', 'nonce' );

		if ( $this->aital_check_if_index_exists() === true ) {
			$hasindex = array(
				'code' => 'aital-check-index-success-message-index',
				'message' => __( 'The autoload field has an index, you are fine', 'add-index-to-autoload' )
			);
			wp_send_json_success( $hasindex );
		}
		elseif ( $this->aital_check_if_index_exists() === false ) {
			$noindex = array(
				'code' => 'aital-check-index-success-message-no-index',
				'message' => __( 'The autoload field does not have an index', 'add-index-to-autoload' )
			);
			wp_send_json_success( $noindex );
		}
		else {
			$error = new WP_Error( 'aital-error-001', __( 'There was an error processing the check', 'add-index-to-autoload' ));
			wp_send_json_error( $error );
		}

	}

	// The function to add the index
	public function aital_add_index() {
		check_ajax_referer( 'aital_add_index_settings_nonce', 'nonce' );

		// Define the global wpdb object
		global $wpdb;

		// Check if the index already exists, if true, that do not add it again
		if ( $this->aital_check_if_index_exists() === true ) {
			$error = new WP_Error( 'aital-error-002', __( 'Index already exists, no need to add it again.', 'add-index-to-autoload' ));
			wp_send_json_error( $error );
		}
		else {
			$add_index_sql = "ALTER TABLE " . esc_sql( $wpdb->options ) . " ADD KEY autoload (autoload)";
			$wpdb->query( $add_index_sql );
			$addedindex = array(
				'code' => 'aital-added-index-success-message',
				'message' => __( 'Index successfully added', 'add-index-to-autoload' )
			);
			wp_send_json_success( $addedindex );
		}

	}

	// The function to remove the index
	public function aital_remove_index() {
		check_ajax_referer( 'aital_remove_index_settings_nonce', 'nonce' );

		// Define the global wpdb object
		global $wpdb;

		// Check if the index exists before attempting to remove it
		if ( $this->aital_check_if_index_exists() === true ) {
			$remove_index_sql = "ALTER TABLE ".esc_sql( $wpdb->options )." DROP KEY autoload";
			$wpdb->query($remove_index_sql);
			$removedindex = array(
				'code' => 'aital-remove-index-success-message',
				'message' => __( 'Index successfully removed', 'add-index-to-autoload' )
			);
			wp_send_json_success( $removedindex );
		}
		else {
			$error = new WP_Error( 'aital-error-003', __( 'There is no index on the autoload field, so it cannot be removed', 'add-index-to-autoload' ));
			wp_send_json_error( $error );
		}

	}

	// The function to check if the scheduler has a scheduled hook
	public function aital_check_if_scheduler_exists() {
		check_ajax_referer( 'aital_check_schedule_settings_nonce', 'nonce' );

		if (wp_next_scheduled ( 'aital_schedule_check' )){
			$check = array(
				'exists' => true
			);
			wp_send_json_success( $check );
		}
		else {
			$check = array(
				'exists' => false
			);
			wp_send_json_success( $check );
		}

	}

	// The function to add or delete the wp-cron check for an index
	public function aital_schedule_index_check() {
		check_ajax_referer( 'aital_schedule_index_check_settings_nonce', 'nonce' );

		$delete = $_POST['delete'];
		$period = $_POST['period'];


		if ($delete === "true" ) {
			if (wp_next_scheduled ( 'aital_schedule_check' )) {
				wp_clear_scheduled_hook( 'aital_schedule_check' );
				$deleted = array(
					'code'    => 'aital-deleted-hook-success-message',
					'deleted' => true,
					'message' => __( 'Hook successfully deleted', 'add-index-to-autoload' )
				);
				wp_send_json_success( $deleted );
			}
			else {
				$deleted = array(
					'code'    => 'aital-deleted-hook-failed-message',
					'deleted' => false,
					'message' => __( 'Hook could not be deleted, because it does not exist', 'add-index-to-autoload' )
				);
				wp_send_json_success( $deleted );
			}
		}

		if ( !wp_next_scheduled ( 'aital_schedule_check' )) {
			wp_schedule_event(time(), $period, 'aital_schedule_check');
			$scheduledhook = array(
				'code' => 'aital-added-hook-success-message',
				'added' => true,
				'message' => __( 'Check scheduled successfully', 'add-index-to-autoload' )
			);
			wp_send_json_success( $scheduledhook );
		}
		else {
			wp_clear_scheduled_hook( 'aital_schedule_check' );
			wp_schedule_event(time(), $period, 'aital_schedule_check');
			$scheduledhook = array(
				'code' => 'aital-added-hook-success-message',
				'added' => true,
				'message' => __( 'Check schedule updated', 'add-index-to-autoload' )
			);
			wp_send_json_success( $scheduledhook );
		}

	}

	// The functions that wp-cron uses to periodically check if the index exists and display an notice in the admin area
	function aital_scheduled_check() {

		$plugin_name = $this->plugin_name;
		$version = $this->version;
		global $pagenow;

		if( in_array( $pagenow, array( 'index.php' ) ) ) {
			if ( $this->aital_check_if_index_exists() === false ) {
				add_action( 'admin_notices', array( $plugin_name, $version, 'aital_scheduled_check_admin_notice' ) );
			}
		}

	}

	// The function that builds the admin notice that displays if the scheduled check for an index fails
	function aital_scheduled_check_admin_notice() {

		?>
		<div id="aital-admin-notice-no-index" class="notice notice-info is-dismissible">
			<p>
				<strong><?php echo __( 'Add Index To Autoload Warning:', 'add-index-to-autoload' ) ?></strong>
				<?php echo __( 'There is no index on the autoload field on your options table, to add it click
 				<a href="tools.php?page=add-index-to-autoload">here</a>', 'add-index-to-autoload' ) ?>
			</p>
		</div>
		<?php

	}

}
