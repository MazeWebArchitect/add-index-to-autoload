<?php

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Add_Index_To_Autoload
 * @subpackage Add_Index_To_Autoload/includes
 * @author     Matthias Held <matt@web-architect.me>
 */
class Add_Index_To_Autoload_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		// Delete the scheduled index checker
		if ( wp_next_scheduled ( 'aital_schedule_check' ) ) {
			wp_clear_scheduled_hook( 'aital_schedule_check' );
		}

	}

}
