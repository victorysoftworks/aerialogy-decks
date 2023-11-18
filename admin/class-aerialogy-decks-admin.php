<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/victorysoftworks/aerialogy-decks
 * @since      1.0.0
 *
 * @package    Aerialogy_Decks
 * @subpackage Aerialogy_Decks/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Aerialogy_Decks
 * @subpackage Aerialogy_Decks/admin
 * @author     Scott Murray <scanmurr@iu.edu>
 */
class Aerialogy_Decks_Admin {

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
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Aerialogy_Decks_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Aerialogy_Decks_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/aerialogy-decks-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Aerialogy_Decks_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Aerialogy_Decks_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/aerialogy-decks-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function create_deck() {
		$user = wp_get_current_user();
		$user_id = $user->id;

		$this->verify_nonce( $_POST );
		$this->verify_user( $_POST, $user_id );
		$this->add_deck_to_database( $_POST, $user_id );

	}

	private function verify_nonce($post) {
		// TODO: Replace with nonce verify failure hook

		if ( ! isset($post[AERIALOGY_NONCE]) || ! wp_verify_nonce( $post[AERIALOGY_NONCE], 'create_aerialogy_deck' ) ) {
			die( 'Invalid nonce' );
		}
	}

	private function verify_user($post, $user_id) {
		if ( ! isset($post['user_id']) || $post['user_id'] != $user_id ) {
			die( 'Attempted to create deck for someone other than currently logged-in user' ); 
		}
	}

	private function add_deck_to_database($post, $user_id) {
		global $wpdb;

		$deck_name = preg_replace('/[^\w\d\s]+/', '', $post['deck_name']);

		$success = $wpdb->insert(
			$wpdb->prefix . AERIALOGY_DECKS_TABLE,
			[ 'deck_name' => $deck_name, 'user_id' => $user_id ],
			[ '%s', '%d' ]
		);

		if ($success) {
			$redirect_url = wp_sanitize_redirect( $post['_wp_http_referer'] );
			$redirect_params = http_build_query( ['create_success' => true ] );
			wp_safe_redirect( "$redirect_url?$redirect_params" );
		} else {
			die( 'Failed to create deck' );
		}
	}

}
