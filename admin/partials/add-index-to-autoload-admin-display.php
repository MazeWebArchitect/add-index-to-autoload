<?php

/**
 * Provides a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://raidboxes.io
 * @since      1.0.0
 *
 * @package    Add_Index_To_Autoload
 * @subpackage Add_Index_To_Autoload/admin/partials
 */

// Prevent direct access.
if ( ! defined( 'AITAL_PATH' ) ) exit;

?>

<div id="aital-admin-wrapper">
    <?php /* Header */ ?>
    <section id="aital-header">
        <img id="aital-logo" src="<?php echo plugin_dir_url( __FILE__ ) . '../img/aital-logo.png'; ?>" alt="<?php echo __( 'Add Index To Autoload Logo', 'add-index-to-autoload' ) ?>" />
        <h1 id="aital-title" class="aital-blue"><?php echo __( 'Manage Add Index To Autoload', 'add-index-to-autoload' ) ?></h1>
    </section>

	<?php /* About section */ ?>
    <section id="aital-about" class="aital-card">
        <h2><?php echo __( 'About', 'add-index-to-autoload' ) ?></h2>
        <p>
            <?php echo
            __( 'This tool will speed up your database queries by adding an index to the “autoload” field.<br>
                With this index the query time for the autoload option will not increase with growing table size.<br> 
                Therefore it helps speeding things up – especially with big option-tables.',
                'add-index-to-autoload'
            )
            ?>
        </p>
        <h2><?php echo __( 'Plugin-Overview', 'add-index-to-autoload' ) ?></h2>
        <p><?php echo __( 'This plugin offers four options:', 'add-index-to-autoload' ) ?></p>
        <ol>
            <li><?php echo __( 'A one-click check mechanism to check if indexes on the autoload field exist', 'add-index-to-autoload' ) ?></li>
            <li><?php echo __( 'An option that adds an index to the autoload field', 'add-index-to-autoload' ) ?></li>
            <li><?php echo __( 'One-click index removal', 'add-index-to-autoload' ) ?></li>
            <li><?php echo __( 'Adding a simple wp-cronjob, that periodically checks if the index still exists and notifies you, if it doesn’t.', 'add-index-to-autoload' ) ?></li>
        </ol>
    </section>

	<?php /* How to section */ ?>
    <section id="aital-how-to" class="aital-card">
        <h2><?php echo __( 'How to', 'add-index-to-autoload' ) ?></h2>
        <ol>
            <li><?php echo __( 'Backup your WordPress database', 'add-index-to-autoload' ) ?> <em><?php echo  __('(optional but recommended!)', 'add-index-to-autoload') ?></em></li>
            <li><?php echo __( 'Go to the "Options" Section below and click the Add Index button', 'add-index-to-autoload' ) ?></li>
            <li><?php echo __( 'Click the Check button: You should see a success message after a couple of seconds.<br> - If you don’t, please issue a support ticket.', 'add-index-to-autoload' ) ?></li>
            <li><?php echo __( 'Specify a periodic check for the autoload field ', 'add-index-to-autoload' ) ?> <em><?php echo  __('(optional but recommended!)', 'add-index-to-autoload') ?></em></li>
        </ol>
    </section>

	<?php /* Option section */ ?>
    <section id="aital-options" class="aital-card">
        <h2><?php echo __( 'Options', 'add-index-to-autoload' ) ?></h2>
        <div id="aital-button-section">
            <div id="button-section-left" class="aital-float-left">
                <a id="aital_check_index" class="aital-button aital-border-blue"><?php echo __( 'Check', 'add-index-to-autoload' ) ?></a>
            </div>
            <div id="aital-info-notification-section" class="aital-float-left">
                <div id="aital-info-notification-message">
                </div>
            </div>
            <div id="button-section-right" class="aital-float-right">
                <a id="aital_add_index" class="aital-button aital-bg-green aital-white"><?php echo __( 'Add Index', 'add-index-to-autoload' ) ?></a>
                <a id="aital_remove_index" class="aital-button aital-bg-red aital-white"><?php echo __( 'Remove Index', 'add-index-to-autoload' ) ?></a>
            </div>
        </div>
        <div class="aital-float-clear"></div>
    </section>

	<?php /* Scheduler section */ ?>
    <section id="aital-scheduler" class="aital-card">
        <div id="aital-scheduler-header">
            <h2><?php echo __( 'Scheduler', 'add-index-to-autoload' ) ?></h2>
            <span class="aital-scheduler-switch-off hidden"> <?php echo __( 'Off', 'add-index-to-autoload' ) ?></span>
            <span class="aital-scheduler-switch-on hidden"> <?php echo __( 'On', 'add-index-to-autoload' ) ?></span>
        </div>
        <div id="aital-scheduler-options" class="hidden">
            <div id="aital-scheduler-config">
	            <p>
                    <?php echo __( 'Run the check every', 'add-index-to-autoload' ) ?>
                </p>
                <label for="aital-scheduler-config-period"></label>
                <select id="aital-scheduler-config-period" name="aital-scheduler-config-period">
                    <option value="hourly"><?php echo __( 'hour', 'add-index-to-autoload' ) ?></option>
                    <option value="daily"><?php echo __( 'day', 'add-index-to-autoload' ) ?></option>
                </select>
                <a id="aital_add_schedule" class="aital-button-small aital-bg-grey aital-dark-blue"><?php echo __( 'Save', 'add-index-to-autoload' ) ?></a>
                <a id="aital_delete_schedule" class="aital-button-small aital-bg-red aital-white"><?php echo __( 'Delete', 'add-index-to-autoload' ) ?></a>
            </div>
            <sub><em><?php echo __( 'The recommended value is once per day.', 'add-index-to-autoload' ) ?></em></sub>
            <div id="aital-scheduler-info-notification-section">
                <div id="aital-scheduler-info-notification-message">
                </div>
            </div>
            <p><?php echo __( 'This plugin will notify you (via notification banner in this WordPress dashboard) if the scheduled check returns a missing index', 'add-index-to-autoload' ) ?></p>
        </div>
    </section>

</div>