<?php

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/victorysoftworks/aerialogy-decks
 * @since      1.0.0
 *
 * @package    Aerialogy_Decks
 * @subpackage Aerialogy_Decks/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Aerialogy_Decks
 * @subpackage Aerialogy_Decks/includes
 * @author     Scott Murray <scanmurr@iu.edu>
 */
class Aerialogy_Decks_Activator {

	/**
	 * Set up the plugin after being activated.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		self::createTables();
	}

	/**
	 * Create database tables required by the plugin.
	 *
	 * @since    1.0.0
	 */
	public static function createTables() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		self::createDecksTable($wpdb, $charset_collate);
		self::createCardsTable($wpdb, $charset_collate);
	}

	/**
	 * Create the Decks table.
	 *
	 * @since    1.0.0
	 */
	public static function createDecksTable($wpdb, $charset_collate) {
		$sql = "CREATE TABLE {$wpdb->prefix}" . AERIALOGY_DECKS_TABLE . " (
			id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
			deck_name text NOT NULL,
			user_id int(10) UNSIGNED NOT NULL COMMENT 'foriegn key',
			public tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
			PRIMARY KEY  (id)
		) $charset_collate;";

		dbDelta( $sql );
	}

	/**
	 * Create the Cards table.
	 *
	 * @since    1.0.0
	 */
	public static function createCardsTable($wpdb, $charset_collate) {
		$sql = "CREATE TABLE {$wpdb->prefix}" . AERIALOGY_CARDS_TABLE . " (
			id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
			deck_id int(10) UNSIGNED NOT NULL COMMENT 'foreign key',
			card_post_id int(10) UNSIGNED NOT NULL COMMENT 'foreign key',
			card_post_order tinyint(3) UNSIGNED NOT NULL,
			PRIMARY KEY  (id)
		) $charset_collate;";

		dbDelta( $sql );
	}

}
