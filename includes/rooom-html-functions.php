<?php
/**
 * Provides functions to write clean html tags.
 *
 * @package rooom 3D Product Viewer
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Custom function for writing clean HTML Code
 *
 * @param string $tag      HTML tag to build.
 * @param array  $attrs    HTML attributes to add to the tag.
 * @param string $content  Content inside the tag (optional).
 * @param array  $opts     Says if the tag should either not have opening or closing tags (optional).
 * @return string   HTML build out of the input.
 */
function tag( $tag, $attrs, $content = '', $opts = array() ) {
	$attrs_str = '';
	foreach ( $attrs as $key => $value ) {
		if ( null === $value ) {
			continue;
		}
		$attrs_str .= " $key=\"" . esc_attr( $value ) . '"';
	}
	$content_str = $content;
	if ( is_array( $content ) ) {
		$content_tmp = (object) array( 'a_flat' => array() );
		array_walk_recursive(
			$content,
			function ( &$v, $k, &$t ) {
				$t->a_flat[] = $v;
			},
			$content_tmp
		);
		$content_str = implode( '', $content_tmp->a_flat );
	}
	$open_tag_str = '<' . $tag . $attrs_str . '>';
	if ( array_key_exists( 'dont_open', $opts ) && $opts['dont_open'] ) {
		$open_tag_str = '';
	}
	$close_tag_str = '</' . $tag . '>';
	if ( array_key_exists( 'dont_close', $opts ) && $opts['dont_close'] ) {
		$close_tag_str = '';
	}
	return $open_tag_str . $content_str . $close_tag_str;
}

/**
 * Creates an opening HTML tag.
 *
 * @param string $tag      HTML tag to build.
 * @param array  $attrs    HTML attributes to add to the tag.
 * @return string   HTML build out of the input.
 */
function tag_open( $tag, $attrs = array() ) {
	return tag( $tag, $attrs, '', array( 'dont_close' => true ) );
}

/**
 * Creates a closing HTML tag.
 *
 * @param string $tag      HTML tag to build.
 * @param array  $attrs    HTML attributes to add to the tag.
 * @return string   HTML build out of the input.
 */
function tag_close( $tag, $attrs = array() ) {
	return tag( $tag, $attrs, '', array( 'dont_open' => true ) );
}


/**
 * Creates number input field for admin settings
 *
 * @param string $name        Name of the option.
 * @param string $description Description of the option. Will be output next to or under the input field.
 * @param int    $default     Default value of the option.
 * @param float  $step        Value of the HTML step attribute of the input field.
 * @param int    $min         Minimum value of the input field.
 * @return array   Array with the tag and attributes of the setings field.
 */
function admin_input_number( $name = '', $description, $default = '', $step = '1', $min = '-1' ) {

	$default     = esc_attr( $default );
	$value       = get_option( $name ) !== '' ? get_option( $name ) : $default;
	$name        = esc_attr( $name );
	$description = esc_attr( $description );
	$min         = esc_attr( $min );
	$return_tag  = array(
		tag(
			'input',
			array(
				'type'        => 'number',
				'name'        => $name,
				'class'       => 'input-f-w',
				'placeholder' => $value,
				'value'       => $value,
				'style'       => 'width: 170px',
				'step'        => $step,
				'min'         => $min,
			)
		),
	);

	if ( $description ) {
		array_push( $return_tag, tag( 'code', array(), $description ) );
	}

	return $return_tag;
}

/**
 * Creates boolean input field/checkbox for admin settings
 *
 * @param string    $name        Name of the option.
 * @param string    $description Description of the option. Will be output next to or under the input field.
 * @param bool|null $default     Default value of the option.
 * @return array   Array with the tag and attributes of the setings field.
 */
function admin_input_boolean( $name = '', $description = '', $default = null ) {
	$name        = esc_attr( $name );
	$description = esc_attr( $description );
	$default     = esc_attr( $default );
	return tag(
		'label',
		array( 'for' => $name ),
		array(
			tag(
				'input',
				array(
					'type'    => 'checkbox',
					'name'    => $name,
					'id'      => $name,
					'value'   => 'yes',
					'checked' => checked( 'yes', get_value_if_non_empty( get_option( $name ), $default ), false ) ? 'checked' : null,
				)
			),
			$description,
		)
	);
}

/**
 * Creates boolean input field/checkbox for admin settings
 *
 * @param string $name        Name of the option.
 * @param string $description Description of the option. Will be output next to or under the input field.
 * @param string $default     Default value of the option.
 * @return array   Array with the tag and attributes of the setings field.
 */
function admin_input_color_picker( $name = '', $description, $default = '' ) {
	$value       = get_option( $name ) ? get_option( $name ) : '#' . $default;
	$name        = esc_attr( $name );
	$description = esc_attr( $description );
	$default     = esc_attr( $default );

	$return_tag = array(
		tag(
			'input',
			array(
				'type'  => 'text',
				'name'  => $name,
				'class' => 'cpa-color-picker',
				'value' => $value,
			)
		),
	);

	if ( $description ) {
		array_push( $return_tag, tag( 'code', array(), $description ) );
	}

	return $return_tag;
}

/**
 * Creates boolean input field/checkbox for admin settings
 *
 * @param string $name        Name of the option.
 * @param string $description Description of the option. Will be output next to or under the input field.
 * @param string $default     Default value of the option.
 * @return array   Array with the tag and attributes of the setings field.
 */
function admin_input_string( $name = '', $description, $default = '' ) {
	$value       = get_option( $name ) ? get_option( $name ) : $default;
	$name        = esc_attr( $name );
	$value       = esc_url( $value );
	$description = esc_attr( $description );
	$default     = esc_attr( $default );

	return array(
		tag(
			'input',
			array(
				'type'        => 'text',
				'name'        => $name,
				'placeholder' => $value,
				'value'       => $value,
			)
		),
		tag( 'p', array(), $description ),
	);
}

/**
 * Creates boolean input field/checkbox for admin settings
 *
 * @param string $name        Name of the option.
 * @param string $description Description of the option. Will be output next to or under the input field (optional).
 * @param array  $options     Array with options to select from in the dropdown field.
 * @param string $default     Default value of the option (optional).
 * @return array   Array with the tag and attributes of the setings field.
 */
function admin_input_dropdown( $name, $description = '', $options, $default = '' ) {
	$value       = get_option( $name ) ? get_option( $name ) : $default;
	$name        = esc_attr( $name );
	$description = esc_attr( $description );
	$default     = esc_attr( $default );

	$options_string = '';

	foreach ( $options as $option_name => $option_value ) {

		$option_attrs_array = array(
			'name'  => $option_name,
			'value' => $option_value,
		);

			// put current or default value as selected value.
		if ( $value === $option_value ) {
			$option_attrs_array['selected'] = 'selected';
		}
		$options_string .= tag( 'option', $option_attrs_array, $option_name );
	}

	return tag(
		'label',
		array( 'for' => $name ),
		array(
			tag(
				'select',
				array(
					'name'  => $name,
					'value' => $value,
				),
				$options_string
			),
			$description,
		)
	);
}

/**
 *  Returns allowed HTML tags for putting out the iframe on the single product page
 *
 * @param string $tag  HTML Tag that is filtered and printed (optional).
 * @return array $tags Allowed tags and attributes for the given tag
 */
function rooom_allowed_tags( $tag = '' ) {
	global $allowedposttags;

	$tags = $allowedposttags;

	if ( 'iframe' === $tag ) {
		$tags['iframe'] = array(
			'src'                   => true,
			'title'                 => true,
			'frameborder'           => true,
			'width'                 => true,
			'height'                => true,
			'allowvr'               => true,
			'allow'                 => true,
			'allowfullscreen'       => true,
			'mozallowfullscreen'    => true,
			'webkitallowfullscreen' => true,
		);
	} else {
		$tags['input'] = array(
			'value'       => true,
			'checked'     => true,
			'style'       => true,
			'placeholder' => true,
			'class'       => true,
			'name'        => true,
			'type'        => true,
			'id'          => true,
			'step'        => true,
			'min'         => true,
		);

		$tags['button'] = array(
			'value' => true,
			'class' => true,
			'name'  => true,
			'style' => true,
			'type'  => true,
			'id'    => true,
		);

		$tags['select'] = array(
			'value' => true,
			'class' => true,
			'name'  => true,
			'style' => true,
			'id'    => true,
		);
		$tags['option'] = array(
			'value'    => true,
			'class'    => true,
			'name'     => true,
			'style'    => true,
			'id'       => true,
			'selected' => true,

		);
	}

	return $tags;
}
