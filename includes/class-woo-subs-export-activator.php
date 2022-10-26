<?php

/**
 * Fired during plugin activation
 *
 * @link       https://reflekt.ch
 * @since      1.0.0
 *
 * @package    Woo_Subs_Export
 * @subpackage Woo_Subs_Export/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woo_Subs_Export
 * @subpackage Woo_Subs_Export/includes
 * @author     Stirling Tschan <stirlingtschan@gmail.com>
 */
class Woo_Subs_Export_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */

    public function update_htaccess( $rules )
    {
        $content = <<<EOD
        \n # BEGIN WooCommerce Subscriptions Export
        # restrict access to subscriber export files
        RewriteCond %{HTTP_COOKIE} !.*wordpress_logged_in.*$ [NC]
        RewriteCond %{REQUEST_URI} ^(.*?/?)wp-content/uploads/subscriber-exports/* [NC]
        RewriteRule . http://%{HTTP_HOST}%1/wp-login.php?redirect_to=%{REQUEST_URI} [L,QSA]
        # END WooCommerce Subscriptions Export\n
        EOD;
    return $content . $rules;
    }

	public static function activate() {
        mkdir(wp_upload_dir()['basedir'] . '/subscriber-exports');
        //Woo_Subs_Export->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        //add_filter('mod_rewrite_rules', 'update_htaccess');
	}

}
