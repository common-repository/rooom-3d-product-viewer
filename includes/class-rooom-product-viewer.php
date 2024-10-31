<?php
/**
 * Base class file for the rooom 3D Product Viewer
 *
 * @package rooom 3D Product Viewer
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Rooom_Product_Viewer' ) ) :
	/**
	 * My Extension core class
	 */
	class Rooom_Product_Viewer {

		/**
		 * The single instance of the class.
		 *
		 * @since 1.0.0
		 * @var mixed $instance The single instance of the class.
		 */
		protected static $instance = null;

		/**
		 * Constructor.
		 */
		protected function __construct() {
			$this->includes();
			$this->init();
		}

		/**
		 * Main Extension Instance.
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Cloning is forbidden.
		 */
		public function __clone() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'woocommerce' ), '2.1' );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 */
		public function __wakeup() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Unserializing instances of this class is forbidden.', 'woocommerce' ), '2.1' );
		}

		/**
		 * Function for loading dependencies.
		 */
		private function includes() {
			include_once plugin_dir_path( __FILE__ ) . 'rooom-html-functions.php';
			include_once plugin_dir_path( __FILE__ ) . 'rooom-admin-settings.php';
			include_once plugin_dir_path( __FILE__ ) . 'rooom-woocommerce-settings.php';
			include_once plugin_dir_path( __FILE__ ) . 'rooom-woocommerce-frontend.php';
		}

		/**
		 * Function for returning the plugin name.
		 *
		 * @return string Name of the plugin.
		 */
		public static function rooom_plugin_name() {
			return 'rooom-3d-product-viewer';
		}

		/**
		 * Function for returning the plugin folder.
		 * Needed for showing assets in the frontend.
		 */
		public static function rooom_plugin_dir() {
			return plugins_url() . '/' . Rooom_Product_Viewer::rooom_plugin_name(); // phpcs:ignore
		}

		/**
		 * Function for returning the base plugin file name.
		 * Needed for showing links to settings and documentation on the plugin page.
		 */
		public static function rooom_plugin_filename() {
			return  Rooom_Product_Viewer::rooom_plugin_name() . '/rooom-woocommerce-plugin.php'; // phpcs:ignore
		}

		/**
		 * Main Extension Instance.
		 */
		public static function is_wc_active() {
			return class_exists( 'WooCommerce' );
		}

		/**
		 * Function for getting everything set up and ready to run.
		 */
		private function init() {

			add_action( 'admin_init', 'register_rooom_viewer_settings' );
			add_action( 'admin_init', 'display_rooom_viewer_settings' );

			/**
			 * Add index.js to admin
			 */
			add_action( 'admin_enqueue_scripts', 'rooom_add_color_picker' );

			/**
			 * Adds WP color picker to admin settings.
			 *
			 * @param mixed $hook Hook.
			 */
			function rooom_add_color_picker( $hook ) {
				if ( is_admin() ) {
					/* Add the color picker css file */
					wp_enqueue_style( 'wp-color-picker' );

					/* Include our custom jQuery file with WordPress Color Picker dependency */
					wp_enqueue_script( 'rooom-custom-script', Rooom_Product_Viewer::rooom_plugin_dir() . '/src/index.js', array( 'wp-color-picker' ), 20211908, true ); // phpcs:ignore
				}
			}

			/**
			 * Add the configuration page
			 */
			add_filter( 'plugin_action_links_' . self::rooom_plugin_filename(), 'add_plugin_page_settings_link', 10 );

			/**
			 * Adds admin settings page to WooCommerce settings menu.
			 *
			 * @param array $links Array with links.
			 */
			function add_plugin_page_settings_link( $links ) {
				array_unshift( $links, '<a href="' . admin_url( 'admin.php?page=rooom-viewer' ) . '">' . __( 'Settings', 'rooom-3d-product-viewer' ) . '</a>' );
				array_unshift( $links, '<a href="' . __("https://help.rooom.com/hc/en-us/articles/4604601703953-Plugin-for-WooCommerce", 'rooom-3d-product-viewer') . '" target="_blank">' . __( 'Instructions', 'rooom-3d-product-viewer' ) . '</a>' );

				return $links;
			}
			/**
			* Add frontend.js to frontend
			*/
			add_action( 'wp_enqueue_scripts', 'rooom_add_custom_frontend_script' );

			/**
			 * Adds admin settings page to WooCommerce settings menu.
			 *
			 * @param mixed $hook Hook from which the function is called.
			 */
			function rooom_add_custom_frontend_script( $hook ) {
				wp_enqueue_script( 'rooom-custom-frontend-script', Rooom_Product_Viewer::rooom_plugin_dir() . '/src/frontend.js', null, 20211908, true ); // phpcs:ignore
				wp_enqueue_style( 'rooom-custom-frontend-style', Rooom_Product_Viewer::rooom_plugin_dir() . '/src/rooom.css', null, 20211908 ); // phpcs:ignore
			}

			/**
			 * Update info into the database
			 */
			if ( ! function_exists( 'register_rooom_viewer_settings' ) ) {

				/**
				 * Register options for global settings.
				 */
				function register_rooom_viewer_settings() {
					/**
					 * General
					 */
					register_setting( 'rooom-viewer-settings-general', 'rooom_viewer_autospin', array( 'default' => 0 ) );
					register_setting( 'rooom-viewer-settings-general', 'rooom_viewer_autostart', checkbox_add_sanitizing_and_set_default( 'no' ) );
					register_setting( 'rooom-viewer-settings-general', 'rooom_viewer_lang' );
					register_setting( 'rooom-viewer-settings-general', 'rooom_viewer_start_ar', checkbox_add_sanitizing_and_set_default( 'no' ) );

					/**
					 * Environment
					 */
					register_setting( 'rooom-viewer-settings-environment', 'rooom_viewer_bg_color', array( 'default' => null ) );
					register_setting( 'rooom-viewer-settings-environment', 'rooom_viewer_skybox', checkbox_add_sanitizing_and_set_default( 'no' ) );
					register_setting( 'rooom-viewer-settings-environment', 'rooom_viewer_transparent', checkbox_add_sanitizing_and_set_default( 'no' ) );
					register_setting( 'rooom-viewer-settings-environment', 'rooom_viewer_env_intensity' );
					register_setting( 'rooom-viewer-settings-environment', 'rooom_viewer_mirror', checkbox_add_sanitizing_and_set_default( 'no' ) );

					/**
					 * Animations
					 */
					register_setting( 'rooom-viewer-settings-animations', 'rooom_viewer_animations', checkbox_add_sanitizing_and_set_default( 'yes' ) );
					register_setting( 'rooom-viewer-settings-animations', 'rooom_viewer_animation_play' );
					register_setting( 'rooom-viewer-settings-animations', 'rooom_viewer_animation_loop', checkbox_add_sanitizing_and_set_default( 'no' ) );

					/**
					 * Annotations
					 */
					register_setting( 'rooom-viewer-settings-annotations', 'rooom_viewer_annotation_marker_color' );
					register_setting( 'rooom-viewer-settings-annotations', 'rooom_viewer_annotation_marker_size' );
					register_setting( 'rooom-viewer-settings-annotations', 'rooom_viewer_annotation_show' );
					register_setting( 'rooom-viewer-settings-annotations', 'rooom_viewer_annotations', checkbox_add_sanitizing_and_set_default( 'no' ) );
					register_setting( 'rooom-viewer-settings-annotations', 'rooom_viewer_annotations_show', checkbox_add_sanitizing_and_set_default( 'yes' ) );
					register_setting( 'rooom-viewer-settings-annotations', 'rooom_viewer_annotations_type' );

					/**
					 * Augmented Reality
					 */
					register_setting( 'rooom-viewer-settings-augmented-reality', 'rooom_viewer_ar_scale', checkbox_add_sanitizing_and_set_default( 'no' ) );
					register_setting( 'rooom-viewer-settings-augmented-reality', 'rooom_viewer_ar_placement' );

					/**
					 * Camera
					 */
					register_setting( 'rooom-viewer-settings-camera', 'rooom_viewer_camera_zoom_auto', checkbox_add_sanitizing_and_set_default( 'yes' ) );
					register_setting( 'rooom-viewer-settings-camera', 'rooom_viewer_camera_zoom_max' );
					register_setting( 'rooom-viewer-settings-camera', 'rooom_viewer_camera_zoom_min' );
					register_setting( 'rooom-viewer-settings-camera', 'rooom_viewer_camera_zoom_start' );

					/**
					 * User-Interface
					 */
					register_setting( 'rooom-viewer-settings-user-interface', 'rooom_viewer_ui_animations', checkbox_add_sanitizing_and_set_default( 'yes' ) );
					register_setting( 'rooom-viewer-settings-user-interface', 'rooom_viewer_ui_annotations', checkbox_add_sanitizing_and_set_default( 'yes' ) );
					register_setting( 'rooom-viewer-settings-user-interface', 'rooom_viewer_ui_ar', checkbox_add_sanitizing_and_set_default( 'yes' ) );
					register_setting( 'rooom-viewer-settings-user-interface', 'rooom_viewer_ui_fullscreen', checkbox_add_sanitizing_and_set_default( 'yes' ) );
					register_setting( 'rooom-viewer-settings-user-interface', 'rooom_viewer_ui_general_controls', checkbox_add_sanitizing_and_set_default( 'yes' ) );
					register_setting( 'rooom-viewer-settings-user-interface', 'rooom_viewer_ui_help', checkbox_add_sanitizing_and_set_default( 'yes' ) );
					register_setting( 'rooom-viewer-settings-user-interface', 'rooom_viewer_ui_hint_color' );
					register_setting( 'rooom-viewer-settings-user-interface', 'rooom_viewer_ui_progress_bg', checkbox_add_sanitizing_and_set_default( 'yes' ) );
					register_setting( 'rooom-viewer-settings-user-interface', 'rooom_viewer_ui_progress_color' );
					register_setting( 'rooom-viewer-settings-user-interface', 'rooom_viewer_ui_zoom', checkbox_add_sanitizing_and_set_default( 'yes' ) );
					register_setting( 'rooom-viewer-settings-user-interface', 'rooom_viewer_logo' );
				}
			}
			/**
				* Show admin settings
				*/
			if ( ! function_exists( 'output_general_settings' ) ) {

				/**
				 * Empty function to have a callback for the add_settings_section function.
				 */
				function output_general_settings() {
				}
			}

			if ( ! function_exists( 'checkbox_add_sanitizing_and_set_default' ) ) {

				/**
				 * Returns array with sanitizing callback function and default value for registering checkbox settings.
				 *
				 * @param string $default default value for the setting (optional).
				 */
				function checkbox_add_sanitizing_and_set_default( $default = 'no' ) {
					return array(
						'default'           => $default,
						'sanitize_callback' => 'set_checkbox_value_to_yes_or_no',
					);
				}
			}

			if ( ! function_exists( 'set_checkbox_value_to_yes_or_no' ) ) {
				/**
				 * Sets option value to 'no' if checkbox is not checked instead of leaving it empty.
				 *
				 * @param mixed $args value to be sanizited.
				 */
				function set_checkbox_value_to_yes_or_no( $args ) {
					if ( 'yes' === $args ) {
						return 'yes';    // checkbox is checked.
					} else {
						return 'no';   // checkbox is not checked.
					}
				}
			}
			if ( ! function_exists( 'rooom_viewer_menu' ) ) {

				/**
				 * Variable/Function Name Description
				 * $page_title    The title shown in the web-browser when viewing your plugin page
				 * $menu_title    The title for the menu button shown in the WordPress dashboard
				 * $capability    manage_options allows only Super Admin and Administrator to view plugin
				 * $menu_slug URL to access plugin such as: /wp-admin/admin.php?page=extra-post-info
				 * $function  The function that contains the code for what to actually display on your plugin page
				 * $icon_url  Icon used in dashboard. You can use WordPress dash icons, or direct images like: $icon_url = plugins_url( ‘extra-post-info/icon.png’ );
				 * $position  Icon position in dashboard
				 * add_menu_page  The WordPress function that hooks in and builds our plugin menu in the dashboard
				 */
				function rooom_viewer_menu() {
					$page_title = 'rooom 3D Product Viewer';
					$menu_title = '3D Product Viewer';
					$capability = 'manage_options';
					$menu_slug  = 'rooom-viewer';
					$function   = 'rooom_viewer_admin_page';
					$icon_url   = 'dashicons-media-code';
					$position   = 4;

					add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function, $position );
					if ( Rooom_Product_Viewer::is_wc_active() ) { // phpcs:ignore
						add_submenu_page( 'woocommerce', $page_title, $menu_title, $capability, $menu_slug, $function, $position );
					}
				}
			}
			add_action( 'admin_menu', 'rooom_viewer_menu' );

			/**
			 * Checks if $arr has $key and return its value or null.
			 *
			 * @param array  $arr Array.
			 * @param string $key Key.
			 * @return mixed returns null if key is missing or false.
			 */
			function get_arr_key_if_set( $arr, $key ) {
				return empty( $arr[ $key ] ) ? null : $arr[ $key ];
			}

			/**
			 * Polyfill for the ternary operator (for compatibility)
			 *
			 * Returns the same as $x ?? $y but considering empty string the same as null.
			 *
			 * @param mixed $x First value.
			 * @param mixed $y Second value.
			 * @return mixed
			 */
			function empty_coalesce( $x, $y ) {
				if ( $x && ! empty( $x ) ) {
					return $x;
				} else {
					return $y;
				}
			}

			/**
			 * Polyfill for the ternary operator (for compatibility)
			 *
			 * Returns the same as $x ?? $y but considering empty string the same as null.
			 *
			 * @param mixed $x first value.
			 * @param mixed $y second value.
			 * @return mixed
			 */
			function empty_or_zero_coalesce( $x, $y ) {
				if ( 0 === $x || '0' === $x ) {
					return $x;
				}

				if ( $x && ! empty( $x ) ) {
					return $x;
				} else {
					return $y;
				}
			}

			/**
			 * Takes value from checkbox input.
			 *
			 * @param mixed $x first value.
			 * @param mixed $y second value.
			 * @return mixed
			 */
			function tri_state_radio_coalesce( $x, $y ) {

				$radio_options = array( 'yes', 'no' );

				if ( $x && in_array( $x, $radio_options, true ) ) {
					return $x;
				} else {
					return $y;
				}
			}

			/**
			 * Returns value of variable if it is not empty.
			 *
			 * @param mixed $value first value.
			 * @param mixed $default second value.
			 * @return mixed
			 */
			function get_value_if_non_empty( $value, $default ) {
				return empty( $value ) ? $default : $value;
			}

			/**
			 * Convert 'yes' or 'no' (other values) into number string '1' or '0'
			 *
			 * @param string $val String to convert (usually 'yes' or 'no').
			 * @return string|null '1' or '0' or null
			 */
			function yes_to_number_string( $val ) {
				if ( ! isset( $val ) ) {
					return null;
				}
				if ( 'yes' === $val ) {
					return '1';
				}
				return '0';
			}

			/**
			 * Get $post_meta and decide if the rooom Viewer is enabled.
			 * Check for meta keys _rooom_viewer_enabled and _rooom_viewer_product_id
			 *
			 * @param mixed $post_meta post meta array (optional).
			 * @return boolean
			 */
			function is_rooom_viewer_enabled( $post_meta = '' ) {

				$post_id   = get_the_ID();
				$post_meta = empty( $post_meta ) ? $post_meta : get_post_meta( $post_id );

				if ( isset( $post_meta['_rooom_viewer_enabled'] )
					&& 'yes' === $post_meta['_rooom_viewer_enabled'][0]    // checkbox is checked.
					&& isset( $post_meta['_rooom_viewer_product_id'] )      // product viewer id is set.
					&& ! empty( $post_meta['_rooom_viewer_product_id'][0] ) ) {
					return true;
				} else {
					return false;
				}
			}
		}
	}
	endif;
