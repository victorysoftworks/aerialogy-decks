<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/victorysoftworks/aerialogy-decks
 * @since      1.0.0
 *
 * @package    Aerialogy_Decks
 * @subpackage Aerialogy_Decks/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Aerialogy_Decks
 * @subpackage Aerialogy_Decks/public
 * @author     Scott Murray <scanmurr@iu.edu>
 */
class Aerialogy_Decks_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/aerialogy-decks-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/aerialogy-decks-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register Gutenberg blocks for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function register_blocks() {

		register_block_type( plugin_dir_path( dirname( __FILE__ ) ) . 'blocks/show-user-decks', [
			'render_callback' => [ $this, 'show_user_decks' ]
		] );
	
	}

	/**
	 * Function for rendering the "show user decks" block.
	 *
	 * @since    1.0.0
	 */
	public function show_user_decks( $block_attributes, $content ) {
		if ( ! is_user_logged_in() ) return;

		$user = wp_get_current_user();
		$username = $user->display_name;
		$user_id = $user->id;
		$decks = $this->get_user_decks($user_id);

		ob_start();
		include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/show-user-decks.php';
		return ob_get_clean();
	}

	private function get_user_decks( $user_id ) {
		global $wpdb;

		$sql = $wpdb->prepare(
			"SELECT * FROM `{$wpdb->prefix}" . AERIALOGY_DECKS_TABLE . "` WHERE `user_id` = %d",
			$user_id
		);

		$decks = $wpdb->get_results($sql, ARRAY_A);

		foreach ($decks as $key => $deck) {
			$sql = $wpdb->prepare(
				"SELECT * FROM `{$wpdb->prefix}" . AERIALOGY_CARDS_TABLE . "` WHERE `deck_id` = %d",
				$deck['id']
			);

			$cards = $wpdb->get_results($sql, ARRAY_A);

			$decks[$key]['cards'] = $cards;
		}

		return $decks;
	}

}
