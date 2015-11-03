<?php
/*
Plugin Name: BuddyPress Admin Only Profile Fields
Description: Easily set the visibility of BuddyPress profile fields to hidden, allowing only admin users to edit and view them.
Version: 1.2
Author: Ashley Rich
Contributors: Garrett Hyder
Author URI: http://ashleyrich.com
License: GPL2
Text Domain: buddypress-admin-only-profile-fields
Domain Path: /languages/

Copyright 2013  Ashley Rich (email : hello@ashleyrich.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * BuddyPress Admin Only Profile Fields
 *
 * @package  BuddyPress Admin Only Profile Fields
 * @since    1.0
 */
class BP_Admin_Only_Profile_Fields {

	/**
	 * Instance of this class.
	 *
	 * @since  1.0
	 */
	private static $instance = null;

	/**
	 * Initialize the plugin.
	 *
	 * @since  1.0
	 */
	private function __construct() {
		// Setup plugin constants
		self::setup_constants();

		// Load plugin text domain
		self::load_plugin_textdomain();

		// Actions
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Filters
		add_filter( 'bp_xprofile_get_visibility_levels', array( $this, 'custom_visibility_levels' ) );
		add_filter ( 'bp_xprofile_get_hidden_field_types_for_user', array( $this, 'append_hidden_level' ), 10, 3 );
		add_filter ( 'bp_profile_get_visibility_radio_buttons', array( $this, 'filter_hidden_visibility_from_radio_buttons' ), 10, 3);
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since  1.0
	 *
	 * @return BP_Admin_Only_Profile_Fields
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Setup plugin constants.
	 *
	 * @since  1.0
	 */
	private function setup_constants() {
		if ( ! defined( 'BPAOPF_VERSION' ) ) {
			define( 'BPAOPF_VERSION', '1.2' );
		}

		if ( ! defined( 'BPAOPF_PLUGIN_URL' ) ) {
			define( 'BPAOPF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		if ( ! defined( 'BPAOPF_PLUGIN_DIR' ) ) {
			define( 'BPAOPF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}
	}

	/**
	 * Load the plugin text domain.
	 *
	 * @since  1.0
	 */
	private function load_plugin_textdomain() {
		load_plugin_textdomain( 'buddypress-admin-only-profile-fields', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @since  1.1
	 */
	public function enqueue_scripts() {
		$min     = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$src     = plugins_url( 'js/script' . $min . '.js', __FILE__ );
		$version = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? time() : BPAOPF_VERSION;

		wp_register_script( 'bp_admin_only_profile_fields', $src, array( 'jquery' ), $version, true );

		if ( ! empty( $_GET['page'] ) && false !== strpos( $_GET['page'], 'bp-profile-setup' ) ) {
			wp_enqueue_script( 'bp_admin_only_profile_fields' );
		}
	}

	/**
	 * Add our hidden visibility level.
	 *
	 * @since  1.0
	 *
	 * @param array $levels
	 *
	 * @return array
	 */
	public function custom_visibility_levels( $levels ) {
		$levels['hidden'] = array(
			'id'    => 'hidden',
			'label' => __( 'Admin', 'buddypress-admin-only-profile-fields' )
		);
		$levels['admin-all'] = array(
				'id'    => 'admin-all',
				'label' => __( 'Everyone (Admin Editable)', 'buddypress-admin-only-profile-fields' )
		);
		$levels['admin-owner'] = array(
			'id'    => 'admin-owner',
			'label' => __( 'Only Me (Admin Editable)', 'buddypress-admin-only-profile-fields' )
		);

		return $levels;
	}

	/**
	 * Append 'hidden' to the visibility levels for this user pair.
	 *
	 * @since  1.2
	 *
	 * @param array $hidden_levels
	 * @param int   $displayed_user_id
	 * @param int   $current_user_id
	 *
	 * @return array
	 */
	public function append_hidden_level( $hidden_levels, $displayed_user_id, $current_user_id ) {
		if ( ! current_user_can( apply_filters( 'bp_admin_only_profile_fields_cap', 'manage_options' ) ) ) {
			// Current user is non-admin
			$hidden_levels[] = 'hidden';

			if ( empty( $current_user_id ) ) {
				// Current user is not logged in
				$hidden_levels[] = 'admin-owner';
			} else {
				if ( $displayed_user_id !== $current_user_id ) {
					// Not viewing own profile
					$hidden_levels[] = 'admin-owner';
				} else {
					if ( bp_is_user_profile_edit() ) {
						// Editing profile
						$hidden_levels[] = 'admin-owner';
						$hidden_levels[] = 'admin-all';
					}
				}
			}
		}

		return $hidden_levels;
	}

	/**
	 * Filter 'hidden' visibility levels from radio buttons.
	 *
	 * @since  1.2
	 *
	 * @param string $retval
	 * @param array   $r
	 * @param array   $args
	 *
	 * @return array
	 */
	public function filter_hidden_visibility_from_radio_buttons( $retval, $r, $args ) {
		// Empty return value, filled in below if a valid field ID is found
		$retval = '';

		// Only do-the-do if there's a valid field ID
		if ( ! empty( $r['field_id'] ) ) {
			// Start the output buffer
			ob_start();

			// Output anything before
			echo $r['before']; ?>

			<?php if ( bp_current_user_can( 'bp_xprofile_change_field_visibility' ) ) : ?>
				<?php foreach ( bp_xprofile_get_visibility_levels() as $level ) : ?>
					<?php if ( ! in_array( $level['id'], array( 'hidden', 'admin-owner', 'admin-all' ) ) ) : ?>
						<?php printf( $r['before_radio'], esc_attr( $level['id'] ) ); ?>

						<label for="<?php echo esc_attr( 'see-field_' . $r['field_id'] . '_' . $level['id'] ); ?>">
							<input type="radio"
								   id="<?php echo esc_attr( 'see-field_' . $r['field_id'] . '_' . $level['id'] ); ?>"
								   name="<?php echo esc_attr( 'field_' . $r['field_id'] . '_visibility' ); ?>"
								   value="<?php echo esc_attr( $level['id'] ); ?>" <?php checked( $level['id'], bp_get_the_profile_field_visibility_level() ); ?> />
							<span class="field-visibility-text"><?php echo esc_html( $level['label'] ); ?></span>
						</label>

						<?php echo $r['after_radio']; ?>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif;

			// Output anything after
			echo $r['after'];

			// Get the output buffer and empty it
			$retval = ob_get_clean();
		}

		return $retval;
	}
}

$bp_admin_only_profile_fields = BP_Admin_Only_Profile_Fields::get_instance();