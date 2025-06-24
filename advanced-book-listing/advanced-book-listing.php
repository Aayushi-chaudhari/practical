<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://google.com
 * @since             1.0.0
 * @package           Advanced_Book_Listing
 *
 * @wordpress-plugin
 * Plugin Name:       Advanced Book Listing
 * Plugin URI:        https://google.com
 * Description:       This is a description of the plugin.
 * Version:           1.0.0
 * Author:            Aayushi Chaudhari
 * Author URI:        https://google.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       advanced-book-listing
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ADVANCED_BOOK_LISTING_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-advanced-book-listing-activator.php
 */
function activate_advanced_book_listing() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-advanced-book-listing-activator.php';
	Advanced_Book_Listing_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-advanced-book-listing-deactivator.php
 */
function deactivate_advanced_book_listing() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-advanced-book-listing-deactivator.php';
	Advanced_Book_Listing_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_advanced_book_listing' );
register_deactivation_hook( __FILE__, 'deactivate_advanced_book_listing' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-advanced-book-listing.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_advanced_book_listing() {

	$plugin = new Advanced_Book_Listing();
	$plugin->run();

}
run_advanced_book_listing();

require_once plugin_dir_path( __FILE__ ) . 'includes/class-advanced-book-listing-cpt.php';
new Advanced_Book_Listing_CPT();
