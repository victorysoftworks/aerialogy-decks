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

		register_block_type( plugin_dir_path( dirname( __FILE__ ) ) . 'blocks/add-card', [
			'render_callback' => [ $this, 'add_card' ]
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

		if (isset($_GET['create_success'])) {
			include plugin_dir_path( dirname( __FILE__ ) ) . 'public/markup/show-user-decks/deck-created-message.php';
		}

		if (isset($_GET['delete_success'])) {
			include plugin_dir_path( dirname( __FILE__ ) ) . 'public/markup/show-user-decks/deck-deleted-message.php';
		}
		
		if (count($decks) > 0) {
			include plugin_dir_path( dirname( __FILE__ ) ) . 'public/markup/show-user-decks/show-decks.php';
		} else {
			include plugin_dir_path( dirname( __FILE__ ) ) . 'public/markup/show-user-decks/no-decks.php';
		}

		include plugin_dir_path( dirname( __FILE__ ) ) . 'public/markup/show-user-decks/create-deck-form.php';
		
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

	/**
	 * Register custom post types for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function register_post_types() {

		$svg = 'data:image/svg+xml;base64,PHN2ZyBmaWxsPSIjMDAwMDAwIiBoZWlnaHQ9IjgwMHB4IiB3aWR0aD0iODAwcHgiIHZlcnNpb249IjEuMSIgaWQ9IkNhcGFfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgCgkgdmlld0JveD0iMCAwIDQ1NC45MTggNDU0LjkxOCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPHBhdGggZD0iTTI1MS4yNTMsMzYuOTIyYzMuNTMzLDcuNTE1LDQuODQxLDE1LjUxLDQuMjA5LDIzLjI0N2MtMC4wNjYsMC44MTMsMS4xNjYsMS40MTUsMS44MzEsMC44NjEKCQljOC42NDQtNy4yLDExLjcwNS0xOS41NzYsNi42OTUtMzAuMjMyYy00Ljk3LTEwLjU3Mi0xNi4zMS0xNi4xMDQtMjcuMjg4LTE0LjE3NmMtMC45OTUsMC4xNzUtMS4yODYsMS43ODMtMC40NjksMi4zNgoJCUMyNDIuNTA3LDIzLjQyMiwyNDcuNzU2LDI5LjQ4NCwyNTEuMjUzLDM2LjkyMnoiLz4KCTxwYXRoIGQ9Ik0yMDUuOTkxLDEwMy4xMTdjMTEuOTM2LDAsMjMuMTU3LTQuNjQ4LDMxLjU5Ni0xMy4wODdjMTcuNDIyLTE3LjQyMiwxNy40MjItNDUuNzctMC4wMDEtNjMuMTkyCgkJYy04LjQzOC04LjQzOC0xOS42NTktMTMuMDg2LTMxLjU5NS0xMy4wODZjLTExLjkzNywwLTIzLjE1Nyw0LjY0Ny0zMS41OTYsMTMuMDg2Yy0xNy40MjMsMTcuNDIyLTE3LjQyMyw0NS43Ny0wLjAwMSw2My4xOTIKCQlDMTgyLjgzMyw5OC40NjksMTk0LjA1NSwxMDMuMTE3LDIwNS45OTEsMTAzLjExN3oiLz4KCTxwYXRoIGQ9Ik0zNjcuMTAxLDIwNC4xNWMtMy4wMzEsMC02LjE2MiwxLjMyMi05LjMxMywzLjkzMmwtNDYuMzQ3LDM4LjVjLTMuODg3LDMuMjIxLTEwLjg3Niw1LjQ3MS0xNi45OTcsNS40NzEKCQljLTEuNzAzLDAtMy4yNTUtMC4xNy00LjYxMi0wLjUwNmwtNTYuNjI3LTE0LjAxMmMtMC42MDQtMi43NTUtMS42NDYtNS4zODctMy4xNjYtNy43MTVsLTE0LjU5Ny0yMi4zNjQKCQljLTMuNzU2LTUuNzU0LTUuOTItMTUuOTA4LTQuNjMyLTIxLjcyOWMxLjQ3OS02LjY4Niw1Ljc1OC0xOC4xNjUsOS4zNDMtMjUuMDY2bDguNTYtMTYuNDc1bDU0LjgyNy0yNS4wMjkKCQljNS40MzMtMi40OCwxMy4zMDYtNy4zODcsMTcuOTI0LTExLjE3Mmw0NS41MDgtMzcuMjkxYzYuMjE2LTUuMDkzLDguMTczLTEzLjkwNyw0LjQ1NC0yMC4wNjYKCQljLTIuMTc3LTMuNjA1LTYuMDU2LTUuNzU3LTEwLjM3Ni01Ljc1N2MtMy4yMjIsMC02LjUwMiwxLjE5NS05LjIzOCwzLjM2NmwtNDAuMjY5LDMxLjk1OWMtMy45MTIsMy4xMDUtMTEuMTY4LDcuMjE0LTE1Ljg0NCw4Ljk3MwoJCWwtNTIuMjg3LDE5LjY2M2wtNDIuOTMyLDAuMTAzYy0wLjMzNywwLjAwMS0wLjY4MiwwLjAyOC0xLjAyNCwwLjA0M0wxNTIuNzYsNzUuNjVjLTMuMDQ2LTMuODAyLTYuNzMyLTEwLjk3My04LjA1LTE1LjY1OQoJCWwtMTMuOTI0LTQ5LjQ4OUMxMjkuMDE4LDQuMjIsMTIzLjkzMSwwLDExOC4xMjYsMGMtMS41ODksMC0zLjE0OSwwLjMyMS00LjYzOSwwLjk1NGMtNi42MiwyLjgxNC0xMC4xOTYsMTEuMTA0LTguMTQyLDE4Ljg3MwoJCWwxNS4wNDgsNTYuODc4YzEuNTY0LDUuOTE0LDUuNTY1LDE0LjQ1MSw5LjEwOSwxOS40MzdsMjEuOTE1LDMwLjgzN2MtNC44OSw4Ljk0Ni0xOC4wNTQsMzYuODc1LTE4LjA1NCw3OC4zMQoJCWMwLDI1Ljc2Miw5LjI0Miw0My41MywxOC45OTMsNTUuMTA2bC0yNy4zODEsNjEuMTc0Yy0zLjQwNyw3LjYxMS04Ljg1NCwxOS45NDEtMTIuMTQzLDI3LjQ4NWwtMzMuNTQ5LDc2LjkzOQoJCWMtNC4zNTksOS45OTYsMC4wNTcsMjIuMDQyLDkuODQ3LDI2Ljg1NGwwLjE1MiwwLjA3NWMyLjY5MywxLjMyNCw1LjU0MSwxLjk5NSw4LjQ2NywxLjk5NWM3LjY3NCwwLDE0LjQ5Mi00LjY5OSwxNy4zNzEtMTEuOTcKCQlsMzAuNTYxLTc3LjE4MWMyLjk2Mi03LjQ4LDguNzQ0LTE5LjE3MywxMi44OTEtMjYuMDY0bDMzLjA4My01NS4wMDJjMC4zMTgsMC4wMTEsMC42MzEsMC4wMzUsMC45NTMsMC4wMzUKCQljNi4wNzMsMCwxMi4yNjUtMS45NjEsMTcuMDc2LTUuMjIzbDc2LjQ2LDE3LjE1NmMxLjk1MiwwLjQzOCw0LjA4OCwwLjY2LDYuMzQ5LDAuNjZjOC43NDcsMCwxOC4xNjktMy4xOTUsMjQuMDA4LTguMTQyCgkJbDQ3LjgyLTQwLjYxOWM3LjI4NS02LjE3NCwxMi45OTEtMTguNjk4LDEyLjk5MS0yOC41MTJ2LTIuNjk4QzM3Ny4zMTMsMjA3LjYwOSwzNzEuODEyLDIwNC4xNSwzNjcuMTAxLDIwNC4xNXogTTE1OC4yMDksMTMxLjAzMgoJCWM0LjE2NS02LjUxMSwxMy44OTctMTEuODU0LDIxLjYyNi0xMS44NzNsNDAuNjQtMC4wOThjNy43MjktMC4wMTksMTEuMTM4LDUuNTc4LDcuNTc0LDEyLjQzN2wtMTUuMjEyLDI5LjI3OQoJCWMtMy4zMDksNi4zNjgtNy4wOTksMTYuMzczLTguODEsMjMuMTI2bC02My4xODksOC4wMzhDMTQzLjY2MSwxNTMuNzg4LDE1OC4yMDksMTMxLjAzMiwxNTguMjA5LDEzMS4wMzJ6IE0yMjAuODAyLDI1Mi42NzUKCQlsLTEyLjc4MiwxNC43MjNjLTUuMDY3LDUuODM3LTE1LjIyNCw4LjY0Ni0yMi41NzEsNi4yNDRjMCwwLTM2Ljk0Mi0xMi4wODUtNDMuOTQ2LTU0LjUzNmw2OC4xMDItOC4zMTFsMTIuNzI4LDE5LjUKCQlDMjI2LjU1OSwyMzYuNzY3LDIyNS44NjksMjQ2LjgzOSwyMjAuODAyLDI1Mi42NzV6Ii8+CjwvZz4KPC9zdmc+';

		register_post_type('aerialogy_card', [
			'labels' => [
				'name' => 'Aerialogy Cards',
				'singular_name' => 'Aerialogy Card'
			],
			'description' => 'Cards that can be added to Aerialogy decks',
			'show_in_menu' => true,
			'menu_icon' => $svg,
			'show_in_rest' => true,
			'public' => true,
			'has_archive' => false,
			'template' => [[
				'core/paragraph', 
				[
					'placeholder' => 'Add description here...',
					'lock' => [ 'move' => true, 'remove' => true ]
				]
			]]
		]);
	
	}

}
