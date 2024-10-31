<?php
/**
 * Prints settings fields for global settings
 *
 * @package rooom 3D Product Viewer
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;
if ( ! function_exists( 'display_rooom_viewer_settings' ) ) {

	/**
	 * Calls Settings API to add admin settings
	 */
	function display_rooom_viewer_settings() {

		// Add settings sections parted by the different tabs on the rooom 3D Product Viewer settings page.
		add_settings_section( 'general', __( 'General', 'rooom-3d-product-viewer' ), 'output_general_settings', 'rooom-viewer' );
		add_settings_section( 'environment', __( 'Environment', 'rooom-3d-product-viewer' ), 'output_general_settings', 'rooom-viewer' );
		add_settings_section( 'animations', __( 'Animations', 'rooom-3d-product-viewer' ), 'output_general_settings', 'rooom-viewer' );
		add_settings_section( 'annotations', __( 'Annotations', 'rooom-3d-product-viewer' ), 'output_general_settings', 'rooom-viewer' );
		add_settings_section( 'augmented-reality', __( 'Augmented Reality', 'rooom-3d-product-viewer' ), 'output_general_settings', 'rooom-viewer' );
		add_settings_section( 'camera', __( 'Camera', 'rooom-3d-product-viewer' ), 'output_general_settings', 'rooom-viewer' );
		add_settings_section( 'user-interface', __( 'User Interface', 'rooom-3d-product-viewer' ), 'output_general_settings', 'rooom-viewer' );

		// General Settings.
		add_settings_field(
			'autospin',
			__( 'Autospin', 'rooom-3d-product-viewer' ),
			'print_number_field',
			'rooom-viewer',
			'general',
			array(

				'setting_id'  => 'rooom_viewer_autospin',
				'description' => __( 'Setting a number greater than 0 causes the model to automatically spin around the y-axis after loading. The number determines the rotation speed.', 'rooom-3d-product-viewer' ),
				'default'     => '0',
				'steps'       => '0.1',
			)
		);

		add_settings_field(
			'autostart',
			__( 'Autostart', 'rooom-3d-product-viewer' ),
			'print_boolean_field',
			'rooom-viewer',
			'general',
			array(

				'setting_id'  => 'rooom_viewer_autostart',
				'description' => __( 'When checked, model loads immediately once the page is ready, rather than waiting for the user to click the Play button', 'rooom-3d-product-viewer' ),
				'default'     => 'no',
			)
		);
		add_settings_field(
			'lang',
			__( 'Language', 'rooom-3d-product-viewer' ),
			'print_dropdown_field',
			'rooom-viewer',
			'general',
			array(

				'setting_id'  => 'rooom_viewer_lang',
				'options'     => array(
					__( 'German', 'rooom-3d-product-viewer' ) => 'de',
					__( 'English', 'rooom-3d-product-viewer' )  => 'en',
				),
				'description' => __( 'Set the language for the product viewer. Default: Language set in WordPress settings.', 'rooom-3d-product-viewer' ),
				'default'     => 'de',
			)
		);
		add_settings_field(
			'start-ar',
			__( 'Start AR', 'rooom-3d-product-viewer' ),
			'print_boolean_field',
			'rooom-viewer',
			'general',
			array(

				'setting_id'  => 'rooom_viewer_start_ar',
				'description' => __( 'Force the AR mode after start.', 'rooom-3d-product-viewer' ),
				'default'     => 'no',
			)
		);

		// Environment Settings.
		add_settings_field(
			'bg-color',
			__( 'Background Color', 'rooom-3d-product-viewer' ),
			'print_color_picker_field',
			'rooom-viewer',
			'environment',
			array(

				'setting_id' => 'rooom_viewer_bg_color',
				'default'    => 'ffffff',
			)
		);

		add_settings_field(
			'skybox',
			__( 'Skybox', 'rooom-3d-product-viewer' ),
			'print_boolean_field',
			'rooom-viewer',
			'environment',
			array(

				'setting_id'  => 'rooom_viewer_skybox',
				'description' => __( 'Activates skybox around product', 'rooom-3d-product-viewer' ),
				'default'     => 'yes',
			)
		);

		add_settings_field(
			'transparent',
			__( 'Transparent', 'rooom-3d-product-viewer' ),
			'print_boolean_field',
			'rooom-viewer',
			'environment',
			array(

				'setting_id'  => 'rooom_viewer_transparent',
				'description' => __( 'Makes background of the rooom viewer transparent. Overwrites the skybox setting if active.', 'rooom-3d-product-viewer' ),
				'default'     => 'no',
			)
		);

		add_settings_field(
			'env-intensity',
			__( 'Environment Intensity', 'rooom-3d-product-viewer' ),
			'print_number_field',
			'rooom-viewer',
			'environment',
			array(

				'setting_id'  => 'rooom_viewer_env_intensity',
				'description' => __( 'Sets brightness of the rooom viewer.', 'rooom-3d-product-viewer' ),
				'default'     => '1.5',
				'steps'       => '0.1',
			)
		);

		add_settings_field(
			'mirror',
			__( 'Mirror', 'rooom-3d-product-viewer' ),
			'print_boolean_field',
			'rooom-viewer',
			'environment',
			array(

				'setting_id'  => 'rooom_viewer_mirror',
				'description' => __( 'Enable mirror under the product', 'rooom-3d-product-viewer' ),
				'default'     => 'yes',
			)
		);

		// Animations Settings.

		add_settings_field(
			'animations',
			__( 'Animations', 'rooom-3d-product-viewer' ),
			'print_boolean_field',
			'rooom-viewer',
			'animations',
			array(

				'setting_id'  => 'rooom_viewer_animations',
				'description' => __( 'Enables animations on object.', 'rooom-3d-product-viewer' ),
				'default'     => 'yes',
			)
		);

		add_settings_field(
			'animation-play',
			__( 'First Animation', 'rooom-3d-product-viewer' ),
			'print_number_field',
			'rooom-viewer',
			'animations',
			array(

				'setting_id'  => 'rooom_viewer_animation_play',
				'description' => __( 'Setting to a number greater than -1 will play the animation with index X after viewer start.', 'rooom-3d-product-viewer' ),
				'default'     => '-1',
			)
		);

		add_settings_field(
			'animation-loop',
			__( 'Animation Loop', 'rooom-3d-product-viewer' ),
			'print_boolean_field',
			'rooom-viewer',
			'animations',
			array(

				'setting_id'  => 'rooom_viewer_animation_loop',
				'description' => __( 'Enables the loop-mode for "animation_play" animation.', 'rooom-3d-product-viewer' ),
				'default'     => 'yes',
			)
		);

		// Annotations Settings.

		add_settings_field(
			'annotations',
			__( 'Annotations', 'rooom-3d-product-viewer' ),
			'print_boolean_field',
			'rooom-viewer',
			'annotations',
			array(

				'setting_id'  => 'rooom_viewer_annotations',
				'description' => __( 'Enables annotations on object.', 'rooom-3d-product-viewer' ),
				'default'     => 'yes',
			)
		);

		add_settings_field(
			'annotations-show',
			__( 'Show All Annotations', 'rooom-3d-product-viewer' ),
			'print_boolean_field',
			'rooom-viewer',
			'annotations',
			array(

				'setting_id'  => 'rooom_viewer_annotations_show',
				'description' => __( 'Show all annotations at the same time.', 'rooom-3d-product-viewer' ),
				'default'     => 'no',
			)
		);

		add_settings_field(
			'annotation-show',
			__( 'First Annotations', 'rooom-3d-product-viewer' ),
			'print_number_field',
			'rooom-viewer',
			'annotations',
			array(

				'setting_id'  => 'rooom_viewer_annotation_show',
				'description' => __( 'Setting to a number greater than -1 will show the annotation with index X after viewer start.', 'rooom-3d-product-viewer' ),
				'default'     => '-1',
			)
		);

		add_settings_field(
			'annotation-marker-color',
			__( 'Annotation Marker', 'rooom-3d-product-viewer' ),
			'print_color_picker_field',
			'rooom-viewer',
			'annotations',
			array(

				'setting_id'  => 'rooom_viewer_annotation_marker_color',
				'description' => __( 'Sets the color of the annotation markers.', 'rooom-3d-product-viewer' ),
				'default'     => 'ffffff',
			)
		);

		add_settings_field(
			'annotation-marker-size',
			__( 'Annotation Marker Size', 'rooom-3d-product-viewer' ),
			'print_number_field',
			'rooom-viewer',
			'annotations',
			array(

				'setting_id'  => 'rooom_viewer_annotation_marker_size',
				'description' => __( 'Setting a different size (in centimeter) for annotation marker. Relative to mesh scaling.', 'rooom-3d-product-viewer' ),
				'default'     => '1',
				'step'        => '0.1',
			)
		);

		add_settings_field(
			'annotation-type',
			__( 'Annotations Type', 'rooom-3d-product-viewer' ),
			'print_dropdown_field',
			'rooom-viewer',
			'annotations',
			array(

				'setting_id'  => 'rooom_viewer_annotations_type',
				'options'     => array(
					__('Point', 'rooom-3d-product-viewer' ) => 'point',
					__('Line', 'rooom-3d-product-viewer' )  => 'line',
				),
				'description' => __( "Setting to 'line' will show the annotations as lines / flags.", 'rooom-3d-product-viewer' ),
				'default'     => 'point',
			)
		);
		// AR Settings.

		add_settings_field(
			'ar-scale',
			__( 'AR Scale', 'rooom-3d-product-viewer' ),
			'print_boolean_field',
			'rooom-viewer',
			'augmented_reality',
			array(

				'setting_id'  => 'rooom_viewer_ar_scale',
				'description' => __( 'Setting the scale mode for android and ios devices (fixed = false, auto = true).', 'rooom-3d-product-viewer' ),
				'default'     => 'yes',
			)
		);

		add_settings_field(
			'ar-placement',
			__( 'AR Placement', 'rooom-3d-product-viewer' ),
			'print_dropdown_field',
			'rooom-viewer',
			'augmented_reality',
			array(

				'setting_id'  => 'rooom_viewer_ar_placement',
				'options'     => array(
					'Floor' => 'floor',
					'Wall'  => 'wall',
				),
				'description' => __( 'Setting to "wall" will enable the placement for walls', 'rooom-3d-product-viewer' ),
				'default'     => 'floor',
			)
		);
		// Camera Settings.

		add_settings_field(
			'camera-zoom-auto',
			__( 'Camera Zoom Auto', 'rooom-3d-product-viewer' ),
			'print_boolean_field',
			'rooom-viewer',
			'camera',
			array(

				'setting_id'  => 'rooom_viewer_camera_zoom_auto',
				'description' => __( 'Enables automatic scaling of camera zoom. If not activated, Camera Zoom Max, Camera Zoom Min and Camera Zoom Start need to be set manually.', 'rooom-3d-product-viewer' ),
				'default'     => 'yes',
			)
		);

		add_settings_field(
			'camera-zoom-max',
			__( 'Camera Zoom Max', 'rooom-3d-product-viewer' ),
			'print_number_field',
			'rooom-viewer',
			'camera',
			array(

				'setting_id' => 'rooom_viewer_camera_zoom_max',
				'default'    => '20',
			)
		);

		add_settings_field(
			'camera-zoom-min',
			__( 'Camera Zoom Min', 'rooom-3d-product-viewer' ),
			'print_number_field',
			'rooom-viewer',
			'camera',
			array(
				'setting_id' => 'rooom_viewer_camera_zoom_min',
				'default'    => '1',
			)
		);

		add_settings_field(
			'camera-zoom-start',
			__( 'Camera Zoom Start', 'rooom-3d-product-viewer' ),
			'print_number_field',
			'rooom-viewer',
			'camera',
			array(
				'setting_id' => 'rooom_viewer_camera_zoom_start',
				'default'    => '0',
			)
		);

		// User Interface Settings.

		add_settings_field(
			'ui-animations-menu',
			__( 'UI Animations', 'rooom-3d-product-viewer' ),
			'print_boolean_field',
			'rooom-viewer',
			'ui',
			array(
				'setting_id'  => 'rooom_viewer_ui_animations',
				'description' => __( 'Show animation menu, if animations are available.', 'rooom-3d-product-viewer' ),
				'default'     => 'yes',
			)
		);

		add_settings_field(
			'ui-annotations-menu',
			__( 'UI Annotations', 'rooom-3d-product-viewer' ),
			'print_boolean_field',
			'rooom-viewer',
			'ui',
			array(
				'setting_id'  => 'rooom_viewer_ui_annotations',
				'description' => __( 'Show annotation menu.', 'rooom-3d-product-viewer' ),
				'default'     => 'yes',
			)
		);

		add_settings_field(
			'ui-general-controls',
			__( 'Show Controls', 'rooom-3d-product-viewer' ),
			'print_boolean_field',
			'rooom-viewer',
			'ui',
			array(
				'setting_id'  => 'rooom_viewer_ui_general_controls',
				'description' => __( 'Show UI control buttons. If not checked, the main control buttons in the bottom right of the viewer (Help, AR, Fullscreen and Zoom) will be hidden and the respective settings are overwritten.', 'rooom-3d-product-viewer' ),
				'default'     => 'yes',
			)
		);

		add_settings_field(
			'ur-view-in-ar-button',
			__( 'View in AR', 'rooom-3d-product-viewer' ),
			'print_boolean_field',
			'rooom-viewer',
			'ui',
			array(
				'setting_id'  => 'rooom_viewer_ui_ar',
				'description' => __( 'Show the View in AR button.', 'rooom-3d-product-viewer' ),
				'default'     => 'yes',
			)
		);

		add_settings_field(
			'ui-fullscreen',
			__( 'UI Fullscreen Button', 'rooom-3d-product-viewer' ),
			'print_boolean_field',
			'rooom-viewer',
			'ui',
			array(
				'setting_id'  => 'rooom_viewer_ui_fullscreen',
				'description' => __( 'Show the Fullscreen button.', 'rooom-3d-product-viewer' ),
				'default'     => 'yes',
			)
		);

		add_settings_field(
			'ui-zoom-control-buttons',
			__( 'Zoom Buttons', 'rooom-3d-product-viewer' ),
			'print_boolean_field',
			'rooom-viewer',
			'ui',
			array(
				'setting_id'  => 'rooom_viewer_ui_zoom',
				'description' => __( 'Show the zoom control buttons.', 'rooom-3d-product-viewer' ),
				'default'     => 'yes',
			)
		);

		add_settings_field(
			'ui-help',
			__( 'UI Help Button', 'rooom-3d-product-viewer' ),
			'print_boolean_field',
			'rooom-viewer',
			'ui',
			array(
				'setting_id'  => 'rooom_viewer_ui_help',
				'description' => __( 'Show the Help button.', 'rooom-3d-product-viewer' ),
				'default'     => 'yes',
			)
		);

		add_settings_field(
			'ui-hint-color',
			__( 'UI Hint Color', 'rooom-3d-product-viewer' ),
			'print_color_picker_field',
			'rooom-viewer',
			'ui',
			array(
				'setting_id' => 'rooom_viewer_ui_hint_color',
			)
		);

		add_settings_field(
			'loading-progress-background',
			__( 'Loading Progress Background', 'rooom-3d-product-viewer' ),
			'print_boolean_field',
			'rooom-viewer',
			'ui',
			array(
				'setting_id'  => 'rooom_viewer_ui_progress_bg',
				'description' => __( 'Show a dark background on the loading screen.', 'rooom-3d-product-viewer' ),
				'default'     => 'yes',
			)
		);

		add_settings_field(
			'loading-progress-color',
			__( 'Loading Progress Color', 'rooom-3d-product-viewer' ),
			'print_color_picker_field',
			'rooom-viewer',
			'ui',
			array(
				'setting_id'  => 'rooom_viewer_ui_progress_color',
				'description' => __( 'Change the color of the viewer loading bar', 'rooom-3d-product-viewer' ),
			)
		);

		add_settings_field(
			'loading-progress-logo',
			__( 'Loading Progress Logo', 'rooom-3d-product-viewer' ),
			'print_string_field',
			'rooom-viewer',
			'ui',
			array(
				'setting_id'  => 'rooom_viewer_logo',
				'description' => __( 'Set the image of the viewer loading screen.', 'rooom-3d-product-viewer' ),
				'default'     => 'https://www.rooom.com/assets/img/logo/logo.svg',
			)
		);

	}
}
if ( ! function_exists( 'print_boolean_field' ) ) {

	/**
	 * Prints checkbox on global settings page
	 *
	 * @param array $args Array containing setting id, description of the option and its default value.
	 */
	function print_boolean_field( $args ) {
		$settings_id = isset( $args['setting_id'] ) ? $args['setting_id'] : '';
		$description = isset( $args['description'] ) ? $args['description'] : '';
		$default     = isset( $args['default'] ) ? $args['default'] : true;

		$rendered_input_field = admin_input_boolean( $settings_id, $description, $default );
		$rendered_input_field = is_array( $rendered_input_field ) ? implode( '', $rendered_input_field ) : $rendered_input_field;

		echo wp_kses( $rendered_input_field, rooom_allowed_tags() );
	}
	// }
}

if ( ! function_exists( 'print_number_field' ) ) {

	/**
	 * Prints number input on global settings page
	 *
	 * @param array $args Array containing setting id, description of the option, its default value and steps.
	 */
	function print_number_field( $args ) {
		$settings_id = isset( $args['setting_id'] ) ? $args['setting_id'] : '';
		$description = isset( $args['description'] ) ? $args['description'] : '';
		$default     = isset( $args['default'] ) ? $args['default'] : '0';
		$steps       = isset( $args['steps'] ) ? $args['steps'] : '1';

		$rendered_input_field = admin_input_number( $settings_id, $description, $default, $steps );
		$rendered_input_field = is_array( $rendered_input_field ) ? implode( '', $rendered_input_field ) : $rendered_input_field;

		echo wp_kses( $rendered_input_field, rooom_allowed_tags() );
	}
}

if ( ! function_exists( 'print_string_field' ) ) {

	/**
	 * Prints string input on global settings page
	 *
	 * @param array $args Array containing setting id, description of the option and its default value.
	 */
	function print_string_field( $args ) {
		$settings_id = isset( $args['setting_id'] ) ? $args['setting_id'] : '';
		$description = isset( $args['description'] ) ? $args['description'] : '';
		$default     = isset( $args['default'] ) ? $args['default'] : '';

		$rendered_input_field = admin_input_string( $settings_id, $description, $default );
		$rendered_input_field = is_array( $rendered_input_field ) ? implode( '', $rendered_input_field ) : $rendered_input_field;

		echo wp_kses( $rendered_input_field, rooom_allowed_tags() );
	}
}

if ( ! function_exists( 'print_color_picker_field' ) ) {

	/**
	 * Prints color picker field on global settings page
	 *
	 * @param array $args Array containing setting id, description of the option and its default value.
	 */
	function print_color_picker_field( $args ) {
		$settings_id = isset( $args['setting_id'] ) ? $args['setting_id'] : '';
		$description = isset( $args['description'] ) ? $args['description'] : '';
		$default     = isset( $args['default'] ) ? $args['default'] : '';

		$rendered_input_field = admin_input_color_picker( $settings_id, $description, $default );
		$rendered_input_field = is_array( $rendered_input_field ) ? implode( '', $rendered_input_field ) : $rendered_input_field;

		echo wp_kses( $rendered_input_field, rooom_allowed_tags() );
	}
}
if ( ! function_exists( 'print_dropdown_field' ) ) {

	/**
	 * Prints select input on global settings page
	 *
	 * @param array $args Array containing setting id, selectable options, description of the option and its default value.
	 */
	function print_dropdown_field( $args ) {
		$settings_id = isset( $args['setting_id'] ) ? $args['setting_id'] : '';
		$options     = isset( $args['options'] ) ? $args['options'] : array();
		$description = isset( $args['description'] ) ? $args['description'] : '';
		$default     = isset( $args['default'] ) ? $args['default'] : '';

		$rendered_input_field = admin_input_dropdown( $settings_id, $description, $options, $default );

		echo wp_kses( $rendered_input_field, rooom_allowed_tags() );
	}
}

/**
 * Render the rooom Woocommerce Plugin Admin Page
 */
if ( ! function_exists( 'rooom_viewer_admin_page' ) ) {

	/**
	 * Render the rooom Woocommerce Plugin Admin Page
	 */
	function rooom_viewer_admin_page() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<style>
			.input-f-w {
			width: 100%;
			}
		</style>
		<h1><?php esc_html_e( 'rooom 3D Product Viewer Settings', 'rooom-3d-product-viewer' ); ?></h1>
		<p><?php esc_html_e( 'Global settings for the rooom 3D Product Viewer', 'rooom-3d-product-viewer' ); ?></p>
		<?php
		$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'general';
		?>
		<h2 class="nav-tab-wrapper">
			<a href="?page=rooom-viewer&tab=general" class="nav-tab <?php echo 'general' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'General', 'rooom-3d-product-viewer' ); ?></a>
			<a href="?page=rooom-viewer&tab=environment" class="nav-tab <?php echo 'environment' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Environment', 'rooom-3d-product-viewer' ); ?></a>
			<a href="?page=rooom-viewer&tab=animations" class="nav-tab <?php echo 'animations' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Animations', 'rooom-3d-product-viewer' ); ?></a>
			<a href="?page=rooom-viewer&tab=annotations" class="nav-tab <?php echo 'annotations' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Annotations', 'rooom-3d-product-viewer' ); ?></a>
			<a href="?page=rooom-viewer&tab=augmented-reality" class="nav-tab <?php echo 'augmented-reality' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Augmented Reality', 'rooom-3d-product-viewer' ); ?></a>
			<a href="?page=rooom-viewer&tab=camera" class="nav-tab <?php echo 'camera' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Camera', 'rooom-3d-product-viewer' ); ?></a>
			<a href="?page=rooom-viewer&tab=user-interface" class="nav-tab <?php echo 'user-interface' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'User Interface', 'rooom-3d-product-viewer' ); ?></a>
			<a href="?page=rooom-viewer&tab=shortcode-generator" class="nav-tab <?php echo 'shortcode-generator' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Shortcode Generator', 'rooom-3d-product-viewer' ); ?></a>

		</h2>
		<form method="post" action="options.php">
		<table class="form-table">

		<?php settings_fields( 'rooom-viewer-settings' ); ?>

		<?php
		if ( 'general' === $active_tab ) {
			settings_fields( 'rooom-viewer-settings-general' );
			do_settings_fields( 'rooom-viewer', 'general' );

		} elseif ( 'environment' === $active_tab ) {

			// Environment.
			settings_fields( 'rooom-viewer-settings-environment' );
			do_settings_fields( 'rooom-viewer', 'environment' );

			// Animations.
		} elseif ( 'animations' === $active_tab ) {
			settings_fields( 'rooom-viewer-settings-animations' );
			do_settings_fields( 'rooom-viewer', 'animations' );

			// Annotations.
		} elseif ( 'annotations' === $active_tab ) {

			settings_fields( 'rooom-viewer-settings-annotations' );
			do_settings_fields( 'rooom-viewer', 'annotations' );

			// AR.
		} elseif ( 'augmented-reality' === $active_tab ) {
			settings_fields( 'rooom-viewer-settings-augmented-reality' );
			do_settings_fields( 'rooom-viewer', 'augmented_reality' );

			// Camera.
		} elseif ( 'camera' === $active_tab ) {

			settings_fields( 'rooom-viewer-settings-camera' );
			do_settings_fields( 'rooom-viewer', 'camera' );

			// UI.
		} elseif ( 'user-interface' === $active_tab ) {
			settings_fields( 'rooom-viewer-settings-user-interface' );
			do_settings_fields( 'rooom-viewer', 'ui' );
		} 
		?>
	</table>
				<?php
				submit_button( __( 'Save Settings', 'rooom-3d-product-viewer' ) );
				?>

</form>
<?php

//include Shortcode generator
if ( 'shortcode-generator' === $active_tab ) {
	include_once plugin_dir_path( __FILE__ ) . "rooom-shortcode-generator.php";

}
?>
<img src="/wp-content/plugins/rooom-3d-product-viewer/assets/rooom_logo.png" class="rooom-logo-admin" style="
	position: absolute;
	right: 10px;
	top: 30px;
">
				<?php

	}
}
