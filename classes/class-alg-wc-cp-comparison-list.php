<?php
/**
 * Compare products for WooCommerce - Comparison list
 *
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Comparison_list' ) ) {

	class Alg_WC_CP_Comparison_list {

		public static $add_product_response    = false;
		public static $remove_product_response = false;

		/**
		 * Adds a product to comparison list.
		 *
		 * @param array $args
		 * @return array|bool
		 */
		public static function add_product_to_comparison_list( $args = array() ) {
			$args = wp_parse_args( $args, array(
				Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID => null,  // integer
			) );
			$product_id = filter_var( $args[ Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID ], FILTER_VALIDATE_INT );
			if ( ! is_numeric( $product_id ) || get_post_type( $product_id ) != 'product' ) {
				self::$add_product_response=false;
				return false;
			}

			$compare_list = self::get_list();
			array_push( $compare_list, $product_id );
			$compare_list = array_unique( $compare_list );
			self::set_list( $compare_list );
			self::$add_product_response = $compare_list;
			return $compare_list;
		}

		/**
		 * Gets comparison list fields
		 *
		 * @param bool $getWcAttributes     Gets WooCommerce attributes too
		 * @param bool $reorder_based_on_db Reorder fields based on database
		 * @return array
		 */
		public static function get_fields( $getWcAttributes = true, $reorder_based_on_db = true ) {
			// Default fields
			$default_fields = array(
				'the-product'     => __( 'Product', 'compare-products-for-woocommerce' ),
				'price'       => __( 'Price', 'compare-products-for-woocommerce' ),
				'weight'      => __( 'Weight', 'compare-products-for-woocommerce' ),
			);

			// Other fields
			$fields = array(
				'add-to-cart' => __( 'Add to cart button', 'compare-products-for-woocommerce' ),
				'description' => __( 'Description', 'compare-products-for-woocommerce' ),
				'stock'       => __( 'Availability', 'compare-products-for-woocommerce' ),
				'dimensions'  => __( 'Dimensions', 'compare-products-for-woocommerce' ),
			);
			$fields = array_merge( $default_fields, $fields );

			// WooCommerce attributes
			if ( $getWcAttributes ) {
				$attributes_pretty = self::get_woocommerce_fields();
				$fields = array_merge( $fields, $attributes_pretty );
			}

			// Reorder options if needed
			if( $reorder_based_on_db ){
				$db_fields = get_option( Alg_WC_CP_Settings_Comparison_List::OPTION_COLUMNS );
				if ( ! empty( $db_fields ) ) {
					$fields = array_merge( array_flip( $db_fields ), $fields );
				}
			}

			return $fields;
		}

		/**
		 * Gets only the WooCommerce attributes that will be in Comparison List
		 *
		 * @return array
		 */
		public static function get_woocommerce_fields(){
			// WooCommere attributes
			$attributes        = wc_get_attribute_taxonomies();
			$attributes_pretty = array();
			foreach ( $attributes as $attribute ) {
				$attributes_pretty[ wc_attribute_taxonomy_name( $attribute->attribute_name ) ] = $attribute->attribute_label;
			}
			return $attributes_pretty;
		}

		/**
		 * Removes a product from compare list.
		 *
		 * @param array $args
		 * @return array|bool
		 */
		public static function remove_product_from_comparison_list( $args = array() ) {
			$args = wp_parse_args( $args, array(
				Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID => null,  // integer
			) );
			$product_id = filter_var( $args[ Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID ], FILTER_VALIDATE_INT );
			if ( ! is_numeric( $product_id ) || get_post_type( $product_id ) != 'product' ) {
				self::$remove_product_response=false;
				return false;
			}

			$compare_list = self::get_list();
			$index        = array_search( $product_id, $compare_list );
			unset( $compare_list[ $index ] );
			self::$remove_product_response=$compare_list;
			self::set_list( $compare_list );
		}

		/**
		 * Creates a link pointing to comparison list
		 *
		 */
		public static function create_comparison_list_link( $args = array() ) {
			$args = wp_parse_args( $args, array(
				'link_label' => __( 'View Compare Products', 'compare-products-for-woocommerce' ),
			) );

			if ( true === filter_var( get_option( Alg_WC_CP_Settings_Comparison_List::OPTION_USE_MODAL, true ), FILTER_VALIDATE_BOOLEAN ) ) {
				global $wp;
				if ( is_shop() ) {
					$original_link = get_post_type_archive_link( 'product' );
				} else {
					$original_link = get_permalink( get_the_ID() );
				}

				$final_link = add_query_arg( array(
					Alg_WC_CP_Query_Vars::MODAL => 'open',
				), $original_link );
			} else {
				$original_link = get_permalink( Alg_WC_CP_Comparison_list::get_comparison_list_page_id() );
				$final_link    = $original_link;
			}

			return sprintf(
				"<a class='vacsp-open-modal button wc-forward' href='%s'>%s</a>",
				$final_link,
				$args['link_label']
			);
		}

		/**
		 * Manages query vars
		 *
		 */
		public static function handle_query_vars($vars){
			$vars[] = Alg_WC_CP_Query_Vars::MODAL;
			return $vars;
		}

		/**
		 * Show notification to user after comparing
		 *
		 * @param $compare_response
		 */
		public static function show_notification_after_comparing( $args ) {
			$page_id = Alg_WC_CP_Comparison_list::get_comparison_list_page_id();

			if ( self::$add_product_response !== false ) {
				$product           = new WC_Product( $args[ Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID ] );
				$message           = sprintf( __( "%s was successfully added to comparison list.", 'compare-products-for-woocommerce' ), "<strong>{$product->get_title()}</strong>" );
				$compare_list_link = self::create_comparison_list_link();
				if ( ! empty( $page_id ) ) {
					Alg_WC_CP_Woocommerce::add_notice("{$message}{$compare_list_link}", 'success');
				} else {
					Alg_WC_CP_Woocommerce::add_notice( "{$message}", 'success' );
				}

			} else if ( self::$remove_product_response !== false ) {
				$product           = new WC_Product( $args[ Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID ] );
				$message           = sprintf( __( "%s was successfully removed from comparison list.", 'compare-products-for-woocommerce' ), "<strong>{$product->get_title()}</strong>" );
				$compare_list_link = self::create_comparison_list_link();
				if ( ! empty( $page_id ) ) {
					Alg_WC_CP_Woocommerce::add_notice( "{$message}{$compare_list_link}", 'success' );
				} else {
					Alg_WC_CP_Woocommerce::add_notice( "{$message}", 'success' );
				}
			} else {
				Alg_WC_CP_Woocommerce::add_notice( __( 'Sorry, Some error occurred. Please, try again later.', 'compare-products-for-woocommerce' ), 'error' );
			}
		}

		/**
		 * Sets the compare list
		 *
		 * @return array
		 */
		public static function set_list( $list = array() ) {
			$compare_list = isset( $_SESSION[ Alg_WC_CP_Session::VAR_COMPARE_LIST ] ) ? $_SESSION[ Alg_WC_CP_Session::VAR_COMPARE_LIST ] : array();
			$_SESSION[ Alg_WC_CP_Session::VAR_COMPARE_LIST ] = $list;
			return $compare_list;
		}

		/**
		 * Gets all products that are in the comparison list
		 *
		 * @return array
		 */
		public static function get_list(){
			$compare_list = isset( $_SESSION[ Alg_WC_CP_Session::VAR_COMPARE_LIST ] ) ? $_SESSION[ Alg_WC_CP_Session::VAR_COMPARE_LIST ] : array();
			return $compare_list;
		}

		/**
		 * Creates a comparison list page
		 *
		 * Create comparison list page with a shortcode used for displaying items.
		 * This page is only created if it doesn't exist
		 *
		 */
		public static function create_page() {
			$previous_page_id = self::get_comparison_list_page_id();
			$previous_page    = null;
			if ( $previous_page_id !== false ) {
				$previous_page = get_post( $previous_page_id );
			}

			if ( $previous_page == null ) {
				$post = array(
					'post_title'     => __( 'Comparison list', 'compare-products-for-woocommerce' ),
					'post_type'      => 'page',
					'post_content'   => '[alg_wc_cp_table]',
					'post_status'    => 'publish',
					'post_author'    => 1,
					'comment_status' => 'closed'
				);
				// Insert the post into the database.
				$page_id = wp_insert_post( $post );
				self::set_comparison_list_page_id( $page_id );
			}
		}

		/**
		 * Set comparison list page id
		 *
		 * @param $page_id
		 * @return bool
		 */
		public static function set_comparison_list_page_id( $page_id ) {
			return update_option( 'alg_wc_cp_page_id', $page_id );
		}

		/**
		 * Get comparison list page id
		 *
		 * @return mixed|void
		 */
		public static function get_comparison_list_page_id() {
			return get_option( 'alg_wc_cp_page_id' );
		}

		/**
		 * Deletes the comparison list page
		 *
		 */
		public static function delete_page() {
			$previous_page_id = self::get_comparison_list_page_id();
			$previous_page    = null;
			if ( $previous_page_id !== false ) {
				$previous_page = get_post( $previous_page_id );
			}

			if ( $previous_page != null ) {
				wp_delete_post( $previous_page_id, true );
			}
		}

		/**
		 * Creates compare list.
		 *
		 */
		public static function create_comparison_list( $args = array() ){
			$args = wp_parse_args( $args, array(
				'use_modal' => true,
			) );

			$compare_list = Alg_WC_CP_Comparison_list::get_list();

			$the_query = null;
			if ( ! empty( $compare_list ) ) {
				$the_query = new WP_Query( array(
					'post_type'      => 'product',
					'posts_per_page' => - 1,
					'post__in'       => $compare_list,
					'orderby'        => 'post__in',
					'order'          => 'asc',
				) );
			}

			$fields = array(
				'image'       => __( 'Image', 'compare-products-for-woocommerce' ),
				'price'       => __( 'Price', 'compare-products-for-woocommerce' ),
				'add-to-cart' => __( 'Add to cart button', 'compare-products-for-woocommerce' ),
				'description' => __( 'Description', 'compare-products-for-woocommerce' ),
				'stock'       => __( 'Availability', 'compare-products-for-woocommerce' ),
				'weight'      => __( 'Weight', 'compare-products-for-woocommerce' ),
				'dimensions'  => __( 'Dimensions', 'compare-products-for-woocommerce' ),
			);

			$fields = get_option( Alg_WC_CP_Settings_Comparison_List::OPTION_COLUMNS );
			$params = array(
				'the_query'  => $the_query,
				'show_image' => filter_var( get_option( Alg_WC_CP_Settings_Comparison_List::OPTION_FIELD_IMAGE, false ), FILTER_VALIDATE_BOOLEAN ),
				'show_title' => filter_var( get_option( Alg_WC_CP_Settings_Comparison_List::OPTION_FIELD_TITLE, false ), FILTER_VALIDATE_BOOLEAN ),
				'fields'     => array_flip( $fields ),
				'list_class' => array('alg-wc-cp-list'),
			);
			$params = array_merge( $params, $args );
			return alg_wc_cp_locate_template( 'comparison-list.php', $params );
		}

		/**
		 * Show compare list
		 *
		 * @param $response
		 */
		public static function show_comparison_list() {

			$compare_list_label          = __( "Compare Products", "compare-products-for-woocommerce" );
			$compare_list_subtitle_label = __( "Compare your items", "compare-products-for-woocommerce" );

			$js=
			"
				jQuery(document).ready(function($){
					var isModalCreated=false;
					function openModal(){
						if(!isModalCreated){
							$('#iziModal').iziModal({
						        title: '{$compare_list_label}',
						        subtitle:'{$compare_list_subtitle_label}',
						        icon:'fa fa-exchange-alt',
						        headerColor: '#666666',
						        zindex:999999,
						        history:false,
						        fullscreen: true,
						        padding:18,
							    autoOpen: 1,
						    });
					        isModalCreated=true;
						}else{
							$('#iziModal').iziModal('open');
						}
					}
					$('.alg-wc-cp-open-modal').on('click',function(e){
						e.preventDefault();
						openModal();
					});
					openModal();
				});

			";

			wp_add_inline_script( 'alg-wc-cp-izimodal', $js );
		}

		/**
		 * Returns class name
		 *
		 * @return type
		 */
		public static function get_class_name() {
			return get_called_class();
		}

	}

};