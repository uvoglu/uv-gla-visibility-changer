<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://uvoglu.com
 * @since      1.0.0
 *
 * @package    Uv_Gla_Visibility_Changer
 * @subpackage Uv_Gla_Visibility_Changer/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Uv_Gla_Visibility_Changer
 * @subpackage Uv_Gla_Visibility_Changer/includes
 * @author     UVOGLU <hello@uvoglu.com>
 */
class Uv_Gla_Visibility_Changer {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Uv_Gla_Visibility_Changer_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'UV_GLA_VISIBILITY_CHANGER_VERSION' ) ) {
			$this->version = UV_GLA_VISIBILITY_CHANGER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'uv-gla-visibility-changer';
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Uv_Gla_Visibility_Changer_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-uv-gla-visibility-changer-i18n.php';
		$plugin_i18n = new Uv_Gla_Visibility_Changer_i18n();
		$plugin_i18n->load();
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-uv-gla-visibility-changer-admin.php';
		$plugin_admin = new Uv_Gla_Visibility_Changer_Admin( $this->get_plugin_name(), $this->get_version() );
		$plugin_admin->load();
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->set_locale();
		$this->define_admin_hooks();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
