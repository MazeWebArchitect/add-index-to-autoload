<?php

/**
 * The file that defines the core plugin class
 *
 * @link       https://raidboxes.io
 * @since      1.0.0
 *
 * @package    Add_Index_To_Autoload
 * @subpackage Add_Index_To_Autoload/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization and admin-specific hooks
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Add_Index_To_Autoload
 * @subpackage Add_Index_To_Autoload/includes
 * @author     Matthias Held <matt@web-architect.me>
 */
class Add_Index_To_Autoload {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Add_Index_To_Autoload_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Defines the core functionality of the plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'AITAL_VERSION' ) ) {
			$this->version = AITAL_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'add-index-to-autoload';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();

	}

	/**
	 * Loads the required dependencies for this plugin.
	 * Creates an instance of the loader which will be used to register the hooks with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-add-index-to-autoload-loader.php';

		/**
		 * The class responsible for defining internationalization functionality of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-add-index-to-autoload-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-add-index-to-autoload-admin.php';

		$this->loader = new Add_Index_To_Autoload_Loader();

	}

	/**
	 * Defines the locale for this plugin for internationalization.
	 *
	 * Uses the Add_Index_To_Autoload_i18n class in order to set the domain and to register the hook with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Add_Index_To_Autoload_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Add_Index_To_Autoload_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'aital_menu_pages' );
		$this->loader->add_action( 'aital_schedule_check', $plugin_admin, 'aital_scheduled_check' );

		// The ajax functions for the plugin options
		$this->loader->add_action( 'wp_ajax_aital_check_if_scheduler_exists', $plugin_admin, 'aital_check_if_scheduler_exists' );
		$this->loader->add_action( 'wp_ajax_aital_check', $plugin_admin, 'aital_check' );
		$this->loader->add_action( 'wp_ajax_aital_add_index', $plugin_admin, 'aital_add_index' );
		$this->loader->add_action( 'wp_ajax_aital_remove_index', $plugin_admin, 'aital_remove_index' );
		$this->loader->add_action( 'wp_ajax_aital_schedule_index_check', $plugin_admin, 'aital_schedule_index_check' );

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
	 * The name of the plugin used to uniquely identify it within the context of WordPress and to define
	 * internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Add_Index_To_Autoload_Loader    Orchestrates the hooks of the plugin.
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

}