<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://uvoglu.com
 * @since      1.0.0
 *
 * @package    Uv_Gla_Visibility_Changer
 * @subpackage Uv_Gla_Visibility_Changer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Uv_Gla_Visibility_Changer
 * @subpackage Uv_Gla_Visibility_Changer/admin
 * @author     UVOGLU <hello@uvoglu.com>
 */
class Uv_Gla_Visibility_Changer_Admin {

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

	private $visibility = 'sync';
	private $offset = 0;
	private $count = 10;

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
	 * Register hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function load() {
		// add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		//add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'admin_menu', array( $this, 'uv_add_menu_page' ) );
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
		 * defined in Uv_Gla_Visibility_Changer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Uv_Gla_Visibility_Changer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/uv-gla-visibility-changer-admin.css', array(), $this->version, 'all' );

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
		 * defined in Uv_Gla_Visibility_Changer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Uv_Gla_Visibility_Changer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/uv-gla-visibility-changer-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function uv_add_menu_page() {
		add_menu_page(
			__( 'Google Visibility', 'uv-gla-visibility-changer' ),
			__( 'Google Visibility', 'uv-gla-visibility-changer' ),
			'manage_woocommerce',
			'uv-gla-visibility-changer',
			array( $this, 'uv_add_plugin_page' ),
			'dashicons-visibility',
			58
		);
	}

	public function uv_add_plugin_page() {
		$this->apply_form();
		echo $this->render_page();
	}

	private function apply_form() {
		if ( ! $this->validate_none() ) {
			return;
		}

		$visibility_post = $this->get_post( 'uv-visibility-type', $this->visibility );
		$this->visibility = $visibility_post === 'dont-sync-and-show' ? 'dont-sync-and-show' : 'sync-and-show';
		$this->offset = $this->get_post( 'v-visibility-offset', $this->offset );
		$this->count = $this->get_post( 'uv-visibility-count', $this->count);

		$post_ids = $this->query_posts();
		$this->update_visibility( $post_ids );
	}

	private function query_posts() {
		$query = array(
			'post_type' => 'product',
			'orderby' => 'ID',
			'order' => 'DESC',
			'fields' => 'ids',
			'offset' => $this->offset,
			'numberposts' => $this->count,
		);

		return get_posts( $query );
	}

	private function update_visibility( $post_ids ) {
		foreach ( $post_ids as $post_id ) {
			update_post_meta( $post_id, '_wc_gla_visibility', $this->visibility );
		}
	}

	private function validate_none() {
		if ( ! isset( $_POST[ 'uv_gla_visibility_nonce' ] ) ) {
			return false;
		}
		$nonce = $_POST[ 'uv_gla_visibility_nonce' ];
		if ( !wp_verify_nonce( $nonce, 'uv_gla_visibility_data' ) ) {
			return false;
		}
		return true;
	}

	private function get_post( $key, $default_value ) {
		if ( ! isset( $_POST[ $key ] ) ) {
			return $default_value;
		}
		return sanitize_text_field( $_POST[ $key ] );
	}

	private function render_page() {
		ob_start(); ?>
			<div class="wrap">
				<h1><?php _e( 'Google Visibility', 'uv-gla-visibility-changer' ) ?></h1>
				<p class="description">
					<?php _e( 'Change Google Listings & Ads sync status for multiple products.', 'uv-gla-visibility-changer' ); ?>
					<?php _e( 'Order is determined in descending order of post IDs.', 'uv-gla-visibility-changer' ); ?>
				</p>
				<form method="post" action="<?php menu_page_url( 'uv-gla-visibility-changer' ); ?>">
					<?php wp_nonce_field( 'uv_gla_visibility_data', 'uv_gla_visibility_nonce' ); ?>
					<table class="form-table">
						<tbody>
							<?php
							echo $this->format_rows(
								__( 'Change Visibility to', 'uv-gla-visibility-changer' ),
								$this->generate_select_field(
									'uv-visibility-type',
									array(
										array( 'sync-and-show', __( 'Sync and Show', 'uv-gla-visibility-changer' ) ),
										array( 'dont-sync-and-show', __( 'Don\'t Sync and Show', 'uv-gla-visibility-changer' ) ),
									),
									$this->visibility
								)
							);
							echo $this->format_rows(
								__( 'Offset', 'uv-gla-visibility-changer' ),
								$this->generate_number_input(
									'uv-visibility-offset',
									$this->offset
								)
							);
							echo $this->format_rows(
								__( 'Number of Posts', 'uv-gla-visibility-changer' ),
								$this->generate_number_input(
									'uv-visibility-count',
									$this->count
								)
							);
							?>
						</tbody>
					</table>
					<p class="submit">
						<input
							type="submit"
							class="button button-primary"
							value="<?php _e( 'Apply', 'uv-gla-visibility-changer' ); ?>"
						/>
					</p>
				</form>
			</div>
		<?php

		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	private function format_rows( $label, $input ) {
		return '<tr><th>' . $label . '</th><td>' . $input . '</td></tr>';
	}

	private function generate_select_field( $id, $options, $value ) {
		$input = sprintf(
			'<select id="%s" name="%s">',
			$id,
			$id
		);

		foreach ( $options as $option ) {
			$option_value = $option[0];
			$readable_value = $option[1];

			$input .= sprintf(
				'<option %s value="%s">%s</option>',
				$value === $option_value ? 'selected' : '',
				$option_value,
				$readable_value
			);
		}

		$input .= '</select>';

		return $input;
	}

	private function generate_number_input( $id, $value ) {
		return sprintf(
			'<input type="number" step="1" min="-1" id="%s" name="%s" value="%s">',
			$id,
			$id,
			$value
		);
	}

}
