<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/victorysoftworks/aerialogy-decks
 * @since      1.0.0
 *
 * @package    Aerialogy_Decks
 * @subpackage Aerialogy_Decks/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Aerialogy_Decks
 * @subpackage Aerialogy_Decks/includes
 * @author     Scott Murray <scanmurr@iu.edu>
 */
class Aerialogy_Decks_Deactivator {

	/**
	 * Cleans up the plugin after being deactivated.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		self::removeTables();
	}

	/**
	 * Remove Aerialogy Decks tables from the database.
	 *
	 * @since    1.0.0
	 */
	public static function removeTables() {
		global $wpdb;
    
		$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}" . AERIALOGY_DECKS_TABLE );
		$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}" . AERIALOGY_CARDS_TABLE );
	}

}
