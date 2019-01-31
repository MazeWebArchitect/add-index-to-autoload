<?php

/**
 * Defines the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Add_Index_To_Autoload
 * @subpackage Add_Index_To_Autoload/includes
 * @author     Matthias Held <matt@web-architect.me>
 */
class Add_Index_To_Autoload_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'add-index-to-autoload',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

}
