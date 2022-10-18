<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://reflekt.ch
 * @since      1.0.0
 *
 * @package    Woo_Subs_Export
 * @subpackage Woo_Subs_Export/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Subs_Export
 * @subpackage Woo_Subs_Export/admin
 * @author     Stirling Tschan <stirlingtschan@gmail.com>
 */
class Woo_Subs_Export_Admin {

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
		 * defined in Woo_Subs_Export_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Subs_Export_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-subs-export-admin.css', array(), $this->version, 'all' );

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
		 * defined in Woo_Subs_Export_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Subs_Export_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-subs-export-admin.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * 
	 * Add Options Page to export orders
	 * 
	 * @since    1.0.0 
	 */
	public function add_backend_page() {
		add_options_page(
			__('Export Subscriptions', 'woo-subs-export'),
			__('Export Subscriptions', 'woo-subs-export'),
			'list_users',
			'woo-subs-export',
			array($this, 'render_backend_page_content'),
			null
		);
	}


	/**
	 * 
	 * Render Options Page
	 * 
	 * @since    1.0.0 
	 */
	public function render_backend_page_content() {
		include('partials/woo-subs-export-admin-display.php');
	}


	/**
	 * 
	 * Get Subscriptions
	 * 
	 * @since    1.0.0 
	 */
	public function get_subscriptions() {

		$subscriptions = get_posts( array(
		    'numberposts' => -1,
		    'post_type'   => 'shop_subscription', 
		    'post_status' => 'wc-active',
		    'date_query' => array(
		    	array(
		    		'after'     => 'January 1st, 2013',
		    		'before'    => array(
		    			'year'  => 2013,
		    			'month' => 2,
		    			'day'   => 28,
		    		),
		    		'inclusive' => true,
		    	),
		    ),
		));
		$sales = count($subscriptions);
		return ['sales' => $sales];
		
	}


	/**
	 * 
	 * Generate CSV, this function is called via ajax request on form submit
	 * 
	 * @since    1.0.0 
	 */
	public function wse_export($data) {

		return $_POST;

		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="subscriber_export.csv"');
		$data = $this->get_subscriptions();

		$fp = fopen('php://output', 'wb');
		foreach ( $data as $line ) {
		    $val = explode(",", $line);
		    fputcsv($fp, $val);
		}
		fclose($fp);
		
	}

}
