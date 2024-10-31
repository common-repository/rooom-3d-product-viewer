<?php
/**
 * Uninstall file for rooom 3D Product Viewer plugin
 *
 * @package Rooom Product Viewer
 * @since 1.0.0
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

	$options = array(
		'rooom_viewer_bg_color',
		'rooom_viewer_logo',
		'rooom_viewer_skybox',
		'rooom_viewer_transparent',
		'rooom_viewer_autospin',
		'rooom_viewer_autostart',
		'rooom_viewer_lang',
		'rooom_viewer_start_ar',
		'rooom_viewer_env_intensity',
		'rooom_viewer_animations',
		'rooom_viewer_animation_play',
		'rooom_viewer_animation_loop',
		'rooom_viewer_annotation_marker_color',
		'rooom_viewer_annotation_marker_size',
		'rooom_viewer_annotation_show',
		'rooom_viewer_annotations',
		'rooom_viewer_annotations_show',
		'rooom_viewer_annotations_type',
		'rooom_viewer_mirror',
		'rooom_viewer_ar_scale',
		'rooom_viewer_ar_placement',
		'rooom_viewer_camera_zoom_auto',
		'rooom_viewer_camera_zoom_max',
		'rooom_viewer_camera_zoom_min',
		'rooom_viewer_camera_zoom_start',
		'rooom_viewer_ui_animations',
		'rooom_viewer_ui_annotations',
		'rooom_viewer_ui_ar',
		'rooom_viewer_ui_controls',
		'rooom_viewer_ui_fullscreen',
		'rooom_viewer_ui_general_controls',
		'rooom_viewer_ui_help',
		'rooom_viewer_ui_hint_color',
		'rooom_viewer_ui_progress_bg',
		'rooom_viewer_ui_progress_color',
		'rooom_viewer_ui_zoom',
	);

	foreach ( $options as $option ) {
		delete_option( $option );
	}

	/**
	 * Remove post meta from products
	 * */

	// query all products with postmeta.
	$args = array(
		'numberposts' => 1,
		'post_type'   => 'product',
	);

	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :

		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			$product_id = get_the_ID();
			delete_metadata( 'post', $product_id, '_rooom_viewer_enabled', null, true );
			delete_metadata( 'post', $product_id, '_rooom_viewer_replace_image', null, true );
			delete_metadata( 'post', $product_id, '_rooom_viewer_product_id', null, true );
			delete_metadata( 'post', $product_id, '_rooom_viewer_bg_color', null, true );
			delete_metadata( 'post', $product_id, '_rooom_viewer_logo', null, true );
			delete_metadata( 'post', $product_id, '_rooom_viewer_skybox', null, true );
			delete_metadata( 'post', $product_id, '_rooom_viewer_transparent', null, true );
			delete_metadata( 'post', $product_id, '_rooom_viewer_mirror', null, true );
		endwhile;
	endif;
