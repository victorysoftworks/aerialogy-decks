<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/victorysoftworks/aerialogy-decks
 * @since             1.0.0
 * @package           Aerialogy_Decks
 *
 * @wordpress-plugin
 * Plugin Name:       Aerialogy Decks
 * Plugin URI:        https://github.com/victorysoftworks/aerialogy-decks
 * Description:       Allow users to create and manage decks of Aerialogy stunts.
 * Version:           1.0.0
 * Author:            Scott Murray
 * Author URI:        https://github.com/victorysoftworks
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'AERIALOGY_DECKS_VERSION', '1.0.0' );

/**
 * Nonce name.
 */

define( 'AERIALOGY_NONCE', '_ae_nonce' );

/**
 * Database table names, without prefix.
 */
define( 'AERIALOGY_DECKS_TABLE', 'academy_decks' );
define( 'AERIALOGY_CARDS_TABLE', 'academy_deck_cards' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-aerialogy-decks-activator.php
 */
function activate_aerialogy_decks() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-aerialogy-decks-activator.php';
	Aerialogy_Decks_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-aerialogy-decks-deactivator.php
 */
function deactivate_aerialogy_decks() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-aerialogy-decks-deactivator.php';
	Aerialogy_Decks_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_aerialogy_decks' );
register_deactivation_hook( __FILE__, 'deactivate_aerialogy_decks' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-aerialogy-decks.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_aerialogy_decks() {

	$plugin = new Aerialogy_Decks();
	$plugin->run();

}
run_aerialogy_decks();
