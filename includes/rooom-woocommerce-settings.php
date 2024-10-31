<?php
/**
 * Adds settings tab and product viewer settings to WooCommerce Edit Product page.
 *
 * @package rooom 3D Product Viewer
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Adds tab to single product data settings field.
 *
 * @since 1.0.0
 *
 * @param array $tabs WooCommerce tabs array.
 * @return array $tabs WooCommerce tabs array with new rooom product viewer tab.
 */
function custom_product_tabs( $tabs ) {

	$tabs['rooom_viewer'] = array(
		'label'  => __( 'rooom 3D Product Viewer', 'rooom-3d-product-viewer' ),
		'target' => 'rooom_viewer_options',
		'class'  => array( 'show_if_simple', 'show_if_variable' ),
	);

	return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'custom_product_tabs' );


/**
 * Contents of the Rooom Viewer options product tab.
 */
function rooom_viewer_options_product_tab_content() {

	global $post;

	/* Note the 'id' attribute needs to match the 'target' parameter set above */
	?>
	<div id='rooom_viewer_options' class='panel woocommerce_options_panel'>
				<div class='options_group'>
	<?php

	woocommerce_wp_checkbox(
		array(
			'id'    => '_rooom_viewer_enabled',
			'label' => __( 'Enable the rooom 3D Product Viewer for this product', 'rooom-3d-product-viewer' ),
		)
	);

	woocommerce_wp_text_input(
		array(
			'id'          => '_rooom_viewer_product_id',
			'label'       => __( 'Viewer ID', 'rooom-3d-product-viewer' ),
			'desc_tip'    => 'true',
			'description' => __( 'Enter the Product ID for the asset you created in rooom.com.', 'rooom-3d-product-viewer' ),
			'type'        => 'text',
		)
	);

	woocommerce_wp_text_input(
		array(
			'id'    => '_rooom_viewer_bg_color',
			'label' => __( 'Background Color', 'rooom-3d-product-viewer' ),
			'class' => 'cpa-color-picker',
			'type'  => 'text',
		)
	);

	woocommerce_wp_text_input(
		array(
			'id'          => '_rooom_viewer_logo',
			'label'       => __( 'Logo', 'rooom-3d-product-viewer' ),
			'desc_tip'    => 'true',
			'description' => __( 'Enter the Logo url to show while loading your asset.', 'rooom-3d-product-viewer' ),
			'type'        => 'text',
		)
	);

	woocommerce_wp_checkbox(
		array(
			'id'          => '_rooom_viewer_skybox',
			'label'       => __( 'Skybox', 'rooom-3d-product-viewer' ),
			'description' => __( 'Activate box around object.', 'rooom-3d-product-viewer' ),
		)
	);

	woocommerce_wp_checkbox(
		array(
			'id'          => '_rooom_viewer_transparent',
			'label'       => __( 'Transparent', 'rooom-3d-product-viewer' ),
			'description' => __( 'Make background transparent', 'rooom-3d-product-viewer' ),
		)
	);
	woocommerce_wp_checkbox(
		array(
			'id'          => '_rooom_viewer_mirror',
			'label'       => __( 'Mirror', 'rooom-3d-product-viewer' ),
			'description' => __( 'Enable mirror under the product.', 'rooom-3d-product-viewer' ),
		)
	);

	wp_nonce_field( 'rooom_nonce_action', 'rooom_nonce_field' );
	?>
</div>

</div>
	<?php

}


add_filter( 'woocommerce_product_data_panels', 'rooom_viewer_options_product_tab_content' );


/**
 * Save the rooom 3D Product Viewer Fields to post meta.
 *
 * @since 1.0.0
 *
 * @param array $post_id ID of the product the viewer belongs to.
 */
function save_rooom_viewer_option_fields( $post_id ) {

	$nonce = ( array_key_exists( 'rooom_nonce_field', $_POST ) ) ? sanitize_text_field( wp_unslash( $_POST['rooom_nonce_field'] ) ) : null;
	if ( ! wp_verify_nonce( $nonce, 'rooom_nonce_action' ) ) {
		die( 'Security check' );
	}

	$rooom_viewer_enabled = isset( $_POST['_rooom_viewer_enabled'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, '_rooom_viewer_enabled', $rooom_viewer_enabled );

	$rooom_viewer_replace_image = isset( $_POST['_rooom_viewer_replace_image'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, '_rooom_viewer_replace_image', $rooom_viewer_replace_image );

	if ( isset( $_POST['_rooom_viewer_product_id'] ) ) :
		update_post_meta( $post_id, '_rooom_viewer_product_id', sanitize_text_field( wp_unslash( $_POST['_rooom_viewer_product_id'] ) ) );
		endif;
	if ( isset( $_POST['_rooom_viewer_bg_color'] ) ) :
		update_post_meta( $post_id, '_rooom_viewer_bg_color', sanitize_text_field( wp_unslash( $_POST['_rooom_viewer_bg_color'] ) ) );
		endif;
	if ( isset( $_POST['_rooom_viewer_logo'] ) ) :
		update_post_meta( $post_id, '_rooom_viewer_logo', esc_url_raw( wp_unslash( $_POST['_rooom_viewer_logo'] ) ) );
		endif;

	$rooom_viewer_skybox = isset( $_POST['_rooom_viewer_skybox'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, '_rooom_viewer_skybox', $rooom_viewer_skybox );

	$rooom_viewer_transparent = isset( $_POST['_rooom_viewer_transparent'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, '_rooom_viewer_transparent', $rooom_viewer_transparent );

	$rooom_viewer_mirror = isset( $_POST['_rooom_viewer_mirror'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, '_rooom_viewer_mirror', $rooom_viewer_mirror );
}
add_action( 'woocommerce_process_product_meta_simple', 'save_rooom_viewer_option_fields' );
add_action( 'woocommerce_process_product_meta_variable', 'save_rooom_viewer_option_fields' );
