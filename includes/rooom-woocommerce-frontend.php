<?php
/**
 * Creates and prints rooom 3D Product Viewer HTML to show on product pages.
 *
 * Contains functions to create and wrap the iframe link and callbacks to show them on product pages.
 *
 * @package rooom 3D Product Viewer
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'rooom_create_iframe_link' ) ) {
	/**
	 * Render the Rooom Viewer if it is enabled
	 * Creates link to iframe with given settings
	 *
	 * @param string $viewer_key ID of the product viewer to show.
	 * @param string $viewer_height Height of the product viewer. Default: 100%. Will then fill parent elements aspect ratio of 16 : 9.
	 * @return string $iframe HTML for displaying the product viewer iframe.
	 */
	function rooom_create_iframe_link( $viewer_key = '', $viewer_height = '100%' ) {

		if ( '' === $viewer_key ) {
			return;
		}

		// iframe is part of product image gallery.
		$product_page = ( Rooom_Product_Viewer::is_wc_active() && is_product() );

		if ( $product_page ) {
			$post_id = get_the_ID();

			$post_meta = get_post_meta( $post_id );

			/* Return if not enabled */
			if ( ! is_rooom_viewer_enabled( $post_meta ) ) {
				return '';
			}

			/**
			 * Environment
			 */
			$product_rooom_viewer_bg_color       = empty_coalesce( get_arr_key_if_set( $post_meta, '_rooom_viewer_bg_color' ), array( '' ) );
			$post_meta['_rooom_viewer_bg_color'] = array(
				empty_coalesce(
					$product_rooom_viewer_bg_color[0],
					get_value_if_non_empty( get_option( 'rooom_viewer_bg_color' ), 'ffffff' )
				),
			);

			$product_rooom_viewer_logo       = empty_coalesce( get_arr_key_if_set( $post_meta, '_rooom_viewer_logo' ), array( '' ) );
			$post_meta['_rooom_viewer_logo'] = array(
				empty_coalesce(
					$product_rooom_viewer_logo[0],
					get_value_if_non_empty( get_option( 'rooom_viewer_logo' ), 'https://static.rooom.com/product-viewer/statics/logo-icon.png' )
				),
			);

			$product_rooom_viewer_skybox       = empty_coalesce( get_arr_key_if_set( $post_meta, '_rooom_viewer_skybox' ), array( 'default' ) );
			$post_meta['_rooom_viewer_skybox'] = array(
				tri_state_radio_coalesce(
					$product_rooom_viewer_skybox[0],
					get_value_if_non_empty( get_option( 'rooom_viewer_skybox' ), 'yes' )
				),
			);

			$product_rooom_viewer_transparent       = empty_coalesce( get_arr_key_if_set( $post_meta, '_rooom_viewer_transparent' ), array( 'default' ) );
			$post_meta['_rooom_viewer_transparent'] = array(
				tri_state_radio_coalesce(
					$product_rooom_viewer_transparent[0],
					get_value_if_non_empty( get_option( 'rooom_viewer_transparent' ), 'no' )
				),
			);

			$product_rooom_viewer_env_intensity       = empty_coalesce( get_arr_key_if_set( $post_meta, '_rooom_viewer_env_intensity' ), array( '' ) );
			$post_meta['_rooom_viewer_env_intensity'] = array(
				empty_coalesce(
					$product_rooom_viewer_env_intensity[0],
					get_value_if_non_empty( get_option( 'rooom_viewer_env_intensity' ), '1.5' )
				),
			);

		}

		$general = array(
			'autospin=' . esc_attr( empty_coalesce( get_option( 'rooom_viewer_autospin' ), '0' ) ),
			'autostart=' . esc_attr( add_boolean_url_parameter( 'rooom_viewer_autostart', 'no' ) ),
			'lang=' . esc_attr( empty_coalesce( get_option( 'rooom_viewer_lang' ), substr( get_locale(), 0, 2 ) ) ), // default: wordpress language.
			'start_ar=' . esc_attr( add_boolean_url_parameter( 'rooom_viewer_start_ar', 'no' ) ),
		);

		$environment = array();
		if ( $product_page ) {
			$environment = array(
				'transparent=' . esc_attr( yes_to_number_string( $post_meta['_rooom_viewer_transparent'][0] ) ),
				'skybox=' . esc_attr( yes_to_number_string( $post_meta['_rooom_viewer_skybox'][0] ) ),
				'bg_color=' . esc_attr( str_replace( '#', '', $post_meta['_rooom_viewer_bg_color'][0] ) ),
				'env_intensity=' . esc_attr( $post_meta['_rooom_viewer_env_intensity'][0] ),
				'mirror=' . esc_attr( yes_to_number_string( $post_meta['_rooom_viewer_mirror'][0] ) ),
			);
		} else {
			$environment = array(
				'transparent=' . esc_attr( yes_to_number_string( get_value_if_non_empty( get_option( 'rooom_viewer_transparent' ), 'no' ) ) ),
				'skybox=' . esc_attr( yes_to_number_string( get_value_if_non_empty( get_option( 'rooom_viewer_skybox' ), 'yes' ) ) ),
				'bg_color=' . esc_attr( str_replace( '#', '', get_value_if_non_empty( get_option( 'rooom_viewer_bg_color' ), 'ffffff' ) ) ),
				'env_intensity=' . esc_attr( get_value_if_non_empty( get_option( 'rooom_viewer_env_intensity' ), '1.5' ) ),
				'mirror=' . esc_attr( yes_to_number_string( get_value_if_non_empty( get_option( 'rooom_viewer_mirror' ), 'no' ) ) ),
			);
		}

		$animations = array(
			'animations=' . esc_attr( add_boolean_url_parameter( 'rooom_viewer_animations', 'yes' ) ),
			'animation_play=' . esc_attr( empty_or_zero_coalesce( get_option( 'rooom_viewer_animation_play' ), '-1' ) ),
			'animation_loop=' . esc_attr( add_boolean_url_parameter( 'rooom_viewer_animation_loop', 'no' ) ),
		);

		$annotations = array(
			'annotation_marker_color=' . esc_attr( empty_coalesce( str_replace( '#', '', get_option( 'rooom_viewer_annotation_marker_color' ) ), 'ffffff' ) ),
			'annotation_marker_size=' . esc_attr( empty_coalesce( get_option( 'rooom_viewer_annotation_marker_size' ), '1' ) ),
			'annotation_show=' . esc_attr( empty_or_zero_coalesce( get_option( 'rooom_viewer_annotation_show' ), '-1' ) ),
			'annotations=' . esc_attr( add_boolean_url_parameter( 'rooom_viewer_annotations', 'yes' ) ),
			'annotations_show=' . esc_attr( add_boolean_url_parameter( 'rooom_viewer_annotations_show', 'no' ) ),
			'annotations_type=' . esc_attr( empty_coalesce( get_option( 'rooom_viewer_annotations_type' ), 'point' ) ),
		);

		$augmented_reality = array(
			'ar_scale=' . esc_attr( add_boolean_url_parameter( 'rooom_viewer_ar_scale', 'yes' ) ),
			'ar_placement=' . esc_attr( empty_coalesce( get_option( 'rooom_viewer_ar_placement' ), 'floor' ) ),
		);

		$camera = array(
			'camera_zoom_auto=' . esc_attr( add_boolean_url_parameter( 'rooom_viewer_camera_zoom_auto', 'yes' ) ),
			'camera_zoom_max=' . esc_attr( empty_or_zero_coalesce( get_option( 'rooom_viewer_camera_zoom_max' ), '20' ) ),
			'camera_zoom_min=' . esc_attr( empty_or_zero_coalesce( get_option( 'rooom_viewer_camera_zoom_min' ), '0.003' ) ),
			'camera_zoom_start=' . esc_attr( empty_or_zero_coalesce( get_option( 'rooom_viewer_camera_zoom_start' ), '0' ) ),
		);

		$ui = array(
			'ui_animations=' . esc_attr( add_boolean_url_parameter( 'rooom_viewer_ui_animations', 'yes' ) ),
			'ui_annotations=' . esc_attr( add_boolean_url_parameter( 'rooom_viewer_ui_annotations', 'yes' ) ),
			'ui_ar=' . esc_attr( add_boolean_url_parameter( 'rooom_viewer_ui_ar', 'yes' ) ),
			'ui_general_controls=' . esc_attr( add_boolean_url_parameter( 'rooom_viewer_ui_general_controls', 'yes' ) ),
			'ui_fullscreen=' . esc_attr( add_boolean_url_parameter( 'rooom_viewer_ui_fullscreen', 'yes' ) ),
			'ui_help=' . esc_attr( add_boolean_url_parameter( 'rooom_viewer_ui_help', 'yes' ) ),
			'ui_hint_color=' . esc_attr( empty_coalesce( str_replace( '#', '', get_option( 'rooom_viewer_annotation_marker_color' ) ), '' ) ),
			'ui_progress_bg=' . esc_attr( add_boolean_url_parameter( 'rooom_viewer_ui_progress_bg', 'yes' ) ),
			'ui_progress_color=' . esc_attr( empty_coalesce( str_replace( '#', '', get_option( 'rooom_viewer_ui_progress_color' ) ), '00aeb3' ) ),
			'ui_progress_logo=' . esc_url( $product_page ? $post_meta['_rooom_viewer_logo'][0] : get_value_if_non_empty( get_option( 'rooom_viewer_logo' ), 'https://static.rooom.com/product-viewer/statics/logo-icon.png' ) ),
			'ui_zoom=' . esc_attr( add_boolean_url_parameter( 'rooom_viewer_ui_zoom', 'yes' ) ),
			'ui_info=0',
		);

		$all_params = array_merge( $general, $environment, $animations, $annotations, $augmented_reality, $camera, $ui );
		$iframe     = '
        <iframe
            src="https://viewer.rooom.com/product/' . esc_attr( $viewer_key ) . '?' . join( '&', $all_params ) . '"
            title="rooom-3D-product-viewer"
            width="100%" frameborder="0"
            height="' . $viewer_height . '"
            allowvr="yes" 
            allow="vr; xr; accelerometer; magnetometer; gyroscope; autoplay;" 
            allowfullscreen
            mozallowfullscreen="true" 
            webkitallowfullscreen="true">
        </iframe>';

		return $iframe;
	}
}
/**
 * Adds 0 or 1 as URL parameter
 *
 * @param string $option Option to retrieve the value for.
 * @param string $string_default default boolean value to use if no value is set in the database.
 * @return int 0 or 1.
 */
function add_boolean_url_parameter( $option, $string_default = 'no' ) {
	$numerical_default = 'yes' === $string_default ? '1' : '0';
	return empty_or_zero_coalesce(
		yes_to_number_string(
			get_value_if_non_empty( get_option( $option ), $string_default )
		),
		$numerical_default
	);
}

/**
 * Add AR icon on products with Rooom Viewer enabled
 *
 * @param mixed $img WooCommerce tabs array.
 * @return array $tabs WooCommerce tabs array with new rooom product viewer tab.
 */
function rooom_add_ar_icon_to_gallery_thumbnail( $img ) {
	$post_id   = get_the_ID();
	$post_meta = get_post_meta( $post_id );

	/* Default values */
	if ( ! isset( $post_meta ) ) {
		$post_meta = array();
	}

	if ( ! is_rooom_viewer_enabled( $post_meta ) || ! has_post_thumbnail( $post_id ) ) {
		return $img;
	}

	echo '<img style="width: 30px; position: absolute; right: 0; top: 0; margin: 10px;" src="' . esc_attr( Rooom_Product_Viewer::rooom_plugin_dir() ) . '/assets/rooom-icon-3D-scan.png" />';

	return $img;
}

add_filter( 'woocommerce_before_shop_loop_item', 'rooom_add_ar_icon_to_gallery_thumbnail' );

/**
 * ************************
 * Replacing WoooCommerce Loop Product Thumbs
 * ************************
 */

/**
 * Remove woocommerce hooked action (method woocommerce_template_loop_product_thumbnail
 * on woocommerce_before_shop_loop_item_title hook)
 */
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
/**
 * Add our own action to the woocommerce_before_shop_loop_item_title
 * hook with the same priority that woocommerce uses.
 */
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

/**
 * WooCommerce Loop Product Thumbs
 */
if ( ! function_exists( 'woocommerce_template_loop_product_thumbnail' ) ) {
	/**
	 * Echo thumbnail HTML
	 */
	function woocommerce_template_loop_product_thumbnail() {
		echo wp_kses_post( woocommerce_get_product_thumbnail() );
	}
}

/**
 * WooCommerce Product Thumbnail
 */
if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {

	/**
	 * If product viewer is active, replace gallery thumbnail with product viewer preview image.
	 *
	 * @param string $size size of the thumbnail.
	 * @param int    $placeholder_width width of the placeholder.
	 * @param int    $placeholder_height height of the placeholder.
	 * @return string
	 */
	function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0 ) {
		global $post, $woocommerce;
		$post_meta = get_post_meta( $post->ID );

		/* NOTE: those are PHP 7 ternary operators. Change to classic if/else if you need PHP 5.x support. */
		$placeholder_width = ! $placeholder_width ?
		wc_get_image_size( 'shop_catalog_image_width' )['width'] :
		$placeholder_width;

		$placeholder_height = ! $placeholder_height ?
		wc_get_image_size( 'shop_catalog_image_height' )['height'] :
		$placeholder_height;

		/**
		 * Added a div around the <img> that will be generated
		 */
		$output = '<div>';

		if ( is_rooom_viewer_enabled( $post_meta ) && isset( $post_meta['_rooom_viewer_replace_image'] ) ) {
			$post_meta['_rooom_viewer_replace_image'] = array( get_value_if_non_empty( $post_meta['_rooom_viewer_replace_image'][0], 'no' ) );
		} else {
			$post_meta['_rooom_viewer_replace_image'] = array( 'no' );
		}

		$post_meta['_rooom_viewer_product_id'] = empty_coalesce(
			get_arr_key_if_set( $post_meta, '_rooom_viewer_product_id' ),
			array( '-1' )
		);

		if ( 'yes' === $post_meta['_rooom_viewer_replace_image'][0] ) {
					$thumbnail = get_the_post_thumbnail( $post->ID, $size );
					$d         = new DOMDocument();
					$d->loadHTML( $thumbnail );

					/* root -> html -> body -> img */
					$img    = $d->documentElement->firstChild->firstChild; // phpcs:ignore
					$srcset = $img->getAttribute( 'srcset' );

					$srcset_arr = explode( ' ', $srcset );

					$image = 'https://viewer.rooom.com/product/vwr/' . esc_attr( $post_meta['_rooom_viewer_product_id'][0] ) . '/preview?transparent=1';

					$new_srcset = array();

					$srcset_arr_count = count( $srcset_arr );
			for ( $i = 0; $i < $srcset_arr_count; $i = $i + 2 ) {
				$url  = $srcset_arr[ $i ];
				$size = $srcset_arr[ $i + 1 ];
				$size = str_replace( ',', '', $size );
				$size = str_replace( 'w', '', $size );
				$url  = $image . '&size=' . $size;
				array_push( $new_srcset, $url, $size . 'w,' );
			}

				$img->setAttribute( 'srcset', '' );
				$img->setAttribute( 'style', "background-image: url('" . $image . "'); background-position: center; background-size: cover;" );

				$output .= $img->ownerDocument->saveXML( $img ); // phpcs:ignore
		} else {
			/**
			 * This outputs the <img> or placeholder image.
			 * it's a lot better to use get_the_post_thumbnail() that hardcoding a text <img> tag
			 * as WordPress wil add many classes, srcset and stuff.
			 */
			$output .= has_post_thumbnail() ?
				get_the_post_thumbnail( $post->ID, $size ) :
				'<img src="' . wc_placeholder_img_src() . '" alt="Placeholder" width="' . esc_attr( $placeholder_width ) . '" height="' . esc_attr( $placeholder_height ) . '" />';
		}

		/**
		 * Close added div .my_new_wrapper
		 */
		$output .= '</div>';

		return $output;
	}
}

if ( ! function_exists( 'rooom_create_iframe_html' ) ) {

	/**
	 * Creates HTML with Iframe for Product image.
	 *
	 * @param string $viewer_product_id ID of the product viewer to show.
	 * @param string $viewer_height Height of the product viewer. Default: 100%. Will then fill parent elements aspect ratio of 16 : 9.
	 * @return string HTML for product image.
	 */
	function rooom_create_iframe_html( $viewer_product_id, $viewer_height = '100%' ) {

		$thumb_rooom = 'https://viewer.rooom.com/vwr/' . $viewer_product_id . '/preview?size=512';

		$html = '<div data-thumb="' . Rooom_Product_Viewer::rooom_plugin_dir() . '/assets/pixel.png" data-thumb_bg="' . $thumb_rooom . '" data-thumb-alt="Rooom Product Viewer" class="woocommerce-product-gallery__image rooom_product_viewer">' . rooom_create_iframe_link( $viewer_product_id, $viewer_height ) . '</div>';
		return wp_kses( $html, rooom_allowed_tags( 'iframe' ) );
	}
}

/**
 * Adds Iframe Thumbnail and iframe code as a product image
*/
if ( ! function_exists( 'rooom_show_iframe_as_product_image' ) ) {

	/**
	 * Output the product image before the single product summary.
	 */
	function rooom_show_iframe_as_product_image() {
		$post_id = get_the_ID();
		if ( ! has_post_thumbnail( $post_id ) ) {   // Don't show the iframe as gallery image if there is no main product image.
			return;                                 // Otherwise the iframe will appear as an ugly gallery iframe.
		}
		$post_meta = get_post_meta( $post_id );

		if ( ! isset( $post_meta ) ) {
			$post_meta = array();
		}

		if ( ! is_rooom_viewer_enabled( $post_meta ) ) {
			return;
		}

		$viewer_product_id = $post_meta['_rooom_viewer_product_id'][0];

		$html = rooom_create_iframe_html( $viewer_product_id, '500' );

		echo wp_kses( $html, rooom_allowed_tags( 'iframe' ) );
	}
}
add_action( 'woocommerce_product_thumbnails', 'rooom_show_iframe_as_product_image' );

/**
 * Add shortcode for displaying the 3D product viewer on content pages.
 *
 * @param array $atts Attributes written to the shortcode.
 * @param array $content Content of the shortcode (null).
 * @param mixed $name Name of the shortcode (here: rooom-3D-product-viewer).
 *
 * @return mixed null|HTML for displaying the product viewer iframe
 */
function rooom_3d_product_viewer_shortcode( $atts = array(), $content = null, $name = '' ) {

	$atts        = array_change_key_case( (array) $atts, CASE_LOWER );
	$viewer_atts = shortcode_atts(
		array(
			'viewer_key' => null,
			'height'     => '100%',
		),
		$atts,
		$name
	);

	// end function if no viewer key provided to prevent 404 Iframe.
	if ( null === $viewer_atts['viewer_key'] ) {
		return;
	}

	$viewer_key    = $viewer_atts['viewer_key'];
	$viewer_height = $viewer_atts['height'];

	// create HTML for iframe with viewer key.
	$iframe_html = rooom_create_iframe_html( $viewer_key, $viewer_height );

	// Output needs to be returned.
	return $iframe_html;
}
add_shortcode( 'rooom-3D-product-viewer', 'rooom_3d_product_viewer_shortcode', 10, 3 );
