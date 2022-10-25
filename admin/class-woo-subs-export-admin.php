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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-subs-export-admin.js', array( 'jquery' ), $this->version, true );

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
	public function get_subscriptions($args) {

		// query subscriptions
		$subscriptions = get_posts( $args );

		$subscription_rows = [
			['id', 'status', 'date_created', 'first_name', 'last_name', 'email'] // Header info
		];
		// loop through subscriptions and create an array of their data
		foreach( $subscriptions as $id ){
			$subscription = wc_get_order( $id );
			$data = $subscription->get_data();
			$subscription_rows[] = [$data['id'], $data['status'], $data['date_created']->date('Y-m-d H:i:s'), $data['billing']['first_name'], $data['billing']['last_name'], $data['billing']['email']];
		}

		$sales = count($subscription_rows);
		if ($sales){
			return $subscription_rows;
		} else {
			throw new Exception(__('No data matching your criteria was found.', 'woo-subs-export'));
		}
		
	}


	/**
	 * 
	 * Generate CSV, this function is called via ajax request on form submit
	 * 
	 * @since    1.0.0 
	 */
	public function wse_export() {

		

		$args = [
			'numberposts' => -1,
			'date_query' => [
				'after' => $_POST['startdate'],
				'before' => $_POST['enddate']
			],
			'post_status' => [$_POST['status']],
			'post_type' => 'shop_subscription',
			'fields' => 'ids',
		];

		try {
			$response['data'] = $this->get_subscriptions($args);
			$response['success_message'] = __('Successfully exported', 'woo-subs-export');
		}

		catch(Exception $e) {
		  $response['error_message'] =  $e->getMessage();
		}



		// Create CSV

		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="subscriber_export.csv"');

		$fp = fopen('subscriber_export.csv', 'wb');

		foreach ($response['data'] as $fields) {
		    fputcsv($fp, $fields);
		}

		fclose($fp);
		exit( json_encode($response) );
		
	}

}
