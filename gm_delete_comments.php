<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           gm_delete_comments
 *
 * @wordpress-plugin
 * Plugin Name:       Delete Comments
 * Plugin URI:        http://gauravmittal.in/gm-delete-comments/
 * Description:       This plugin comes with very feature that allow to delete the comments based on category, users or all at once. It's best for victims of spammer attacks.
 * Version:           1.0.0
 * Author:            Gaurav Mittal
 * Author URI:        http://gauravmittal.in/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gm-delete-comments
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gm-delete-comments-activator.php
 */
function activate_gm_delete_comments() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gm-delete-comments-activator.php';
	gm_delete_comments_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gm-delete-comments-deactivator.php
 */
function deactivate_gm_delete_comments() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gm-delete-comments-deactivator.php';
	gm_delete_comments_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_gm_delete_comments' );
register_deactivation_hook( __FILE__, 'deactivate_gm_delete_comments' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-gm-delete-comments.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_gm_delete_comments() {

	$plugin = new gm_delete_comments();
	$plugin->run();

}
run_gm_delete_comments();
