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
	public static function activate() {
        

        $dirname = wp_upload_dir()['basedir'] . '/subscriber-exports';

        // Get canonicalized absolute pathname
        $path = realpath($dirname);

        // If it exist, check if it's a directory
        if ($path === false AND !is_dir($path)) {
            mkdir($dirname);
        }
	}

}
