<?php
/*
 * Render the output for single products
 *
 * @author Bradley Davis
 * @package Product Features For WooCommerce
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif;

class Pffwc_Output {

	/**
	 * The Constructor.
	 * @since 1.0
	 */
	public function __construct() {
	//	$this->init();
		$this->pffwc_output_location();
	}

	/**
	 * Init.
	 * @since 1.0
	 */
	public function init() {
		//$test = get_theme_mod( 'pffwc_image_width' );
	}

	/**
	 * Output location - Single Product.
	 * @since 1.0
	 */
	public function pffwc_output_location() {
		// Location to add the product key(s)
		$pffwc_render_location_setting = get_theme_mod( 'pffwc_render_location', 'pffwc_after_short_desc' );

		switch ( $pffwc_render_location_setting ) :
			case 'pffwc_after_gallery' :
				add_action( 'woocommerce_before_single_product_summary', array( $this, 'pffwc_output_single_product'), 21 );
				break;
			case 'pffwc_after_heading' :
				add_action( 'woocommerce_single_product_summary', array( $this, 'pffwc_output_single_product' ), 6 );
				break;
			case 'pffwc_after_price' :
				add_action( 'woocommerce_single_product_summary', array( $this, 'pffwc_output_single_product' ), 11 );
				break;
			case 'pffwc_after_short_desc' :
				add_action( 'woocommerce_single_product_summary', array( $this, 'pffwc_output_single_product' ), 21 );
				break;
			case 'pffwc_after_add_cart' :
				add_action( 'woocommerce_single_product_summary', array( $this, 'pffwc_output_single_product' ), 31 );
				break;
			case 'pffwc_after_product_meta' :
				add_action( 'woocommerce_single_product_summary', array( $this, 'pffwc_output_single_product' ),  41 );
				break;
		endswitch;
	}

	/**
	 * Render output - Single Product
	 * @since 1.0
	 */
	public function pffwc_output_single_product() {
		// Get the product key(s) ID for the product
		$pffwc_product_key = get_post_meta( get_the_ID(), '_pffwc_product_key_values', true );

		// If product keys are assigned to product output
		if ( '' != $pffwc_product_key ) :

			$pffwc_render = '<div class="pffwc-wrapper">';

				foreach ( $pffwc_product_key as $keyId => $valueId ) :
					$pffwc_object = get_post( $valueId );
					$pffwc_object_title = $pffwc_object->post_title;
					$pffwc_tooltip = get_post_meta( $valueId, '_pffwc_textarea_meta_value_key', true );
					$pffwc_field_description = get_post_meta( $valueId, '_pffwc_text_field_meta_value_key', true );
					$pffwc_key_icon = ( '' != get_the_post_thumbnail( $valueId, 'product_key_thumb' ) ? get_the_post_thumbnail( $valueId, 'product_key_thumb' ) : $pffwc_object_title );
					//Output the product keys
					$pffwc_render .= '<div class="pffwc-item"><a class="pffwc-tooltip" href="#" data-html="true" data-tooltip="' . $pffwc_object_title . ' - ' . $pffwc_tooltip . '">' . $pffwc_key_icon . '</div></a>';
				endforeach;

			$pffwc_render .= '</div>';

			echo $pffwc_render;

		endif;
	}
}

/**
 * Instantiate the class.
 * @since 1.0
 */
$pffwc_ouput = new Pffwc_Output();