<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://uvoglu.com
 * @since      1.0.0
 *
 * @package    Uv_Gla_Visibility_Changer
 * @subpackage Uv_Gla_Visibility_Changer/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Uv_Gla_Visibility_Changer
 * @subpackage Uv_Gla_Visibility_Changer/includes
 * @author     UVOGLU <hello@uvoglu.com>
 */
class Uv_Gla_Visibility_Changer_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'uv-gla-visibility-changer',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

	/**
	 * Register hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function load() {
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
	}

}
