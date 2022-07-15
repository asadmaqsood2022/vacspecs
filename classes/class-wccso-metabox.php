<?php
/**
 * WCCSO_Metabox.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'WCCSO_Metabox' ) ) {

	class WCCSO_Metabox {

		protected static $instance = null;

		public $admin_field_id = 'wccso_metabox';

		/**
		 * Constructor
		 */
		function __construct() {
			$value = $this->admin_field_id;
			add_action( "woocommerce_admin_field_{$value}", array( $this, 'add_meta_box' ), 10, 2 );
		}

		/**
		 * @return Current_Class_Name
		 */
		public static function get_instance() {
			if ( ! isset( static::$instance ) ) {
				static::$instance = new static;
			}

			return static::$instance;
		}

		/**
		 * Gets the style for the metabox
		 */
		public function get_inline_style() {
			$style = '
			<style>
				.wccso-admin-accordion .details-container{
					display:none;
					margin-top:10px;
					margin-bottom:15px;
					background:#f9f9f9;
					padding:13px;
				}
				.wccso-admin-accordion .desc_container{
					color:#999;
				}
				.wccso-admin-accordion .accordion-item .trigger{
					color:#0073aa;
					cursor:pointer;
				}
				.wccso-admin-accordion .img-container img{
					border:4px solid #ddd;
					margin-top:10px;
					max-width:100%;
				}
				.wccso-admin-accordion .accordion-item .trigger:hover{
				text-decoration: underline;
				}
				.wccso-admin-accordion .item:not(.accordion-item):before{
					width:8px;
					height:8px;
					content:" ";
					display:inline-block;
					background:#000;
					margin-right:8px;
				}
				.wccso-admin-accordion .accordion-item:before{
					content:" ";
					width: 0;
					height: 0;
					border-left: 5px solid transparent;
					border-right: 5px solid transparent;
					border-top: 9px solid #0073aa;
					display:inline-block;
					margin-right:7px;
					transition:all 0.3s ease-in-out;
					transform: rotate(-90deg);
				}
				.wccso-admin-accordion .accordion-item.active:before{
				transform: rotate(0deg);
					transform-origin: 50% 50%;
				}
				.wccso-admin-accordion-title{
					margin-top:23px;
				}
				.wccso-call-to-action{
					margin:17px 0 15px 0 !important;
				}
			</style>
			';

			return $style;
		}

		/**
		 * Gets the inline js for the metabox
		 */
		public function get_inline_js() {
			$js = "
			 <script>
				jQuery(document).ready(function($){
					$('.wccso-admin-accordion .accordion-item .trigger').on('click',function(){
						if($(this).parent().hasClass('active')){
							$(this).parent().removeClass('active');
							$(this).parent().find('.details-container').slideUp();
						}else{
							$('.wccso-admin-accordion .accordion-item .details-container').slideUp();
							$('.wccso-admin-accordion .accordion-item').removeClass('active');
							$(this).parent().addClass('active');
							$(this).parent().find('.details-container').slideDown();
						}
					})
				})
			</script>
			";

			return $js;
		}

		/**
		 * Gets the button
		 */
		private function get_call_to_action( $value ) {
			$call_to_action = isset( $value['call_to_action'] ) ? $value['call_to_action'] : false;
			if ( ! $call_to_action ) {
				return '';
			}

			$args = wp_parse_args( $call_to_action, array(
				'href'   => '',
				'label'  => 'Check it',
				'href'   => '',
				'target' => '_blank',
				'class'  => 'button-primary',
			) );

			if ( empty( $args['href'] ) ) {
				return '';
			}

			return sprintf( "<a target='%s' class='%s wccso-call-to-action' href='%s'>%s</a>", esc_attr( $args['target'] ), esc_attr( $args['class'] ), esc_url( $args['href'] ), esc_html( $args['label'] ) );
		}

		/**
		 * Gets the html for the accordion
		 */
		private function get_accordion( $value ) {
			$accordion = isset( $value['accordion'] ) ? $value['accordion'] : false;

			if ( ! $accordion ) {
				return '';
			}

			$items = ! empty( $accordion['items'] ) ? $accordion['items'] : false;
			if ( ! $items ) {
				return '';
			}

			$title = ! empty( $accordion['title'] ) ? $accordion['title'] : '';

			$final_items = " <ul class='wccso-admin-accordion' > ";
			foreach ( $items as $item ) {
				$li_class = 'item';
				if ( ! empty( $item['hidden_content'] ) ) {
					$li_class    .= ' accordion-item';
					$trigger     = ! empty( $item['trigger'] ) ? '<span class="trigger">' . esc_html( $item['trigger'] ) . '</span>' : '';
					$final_items .= " <li class='" . esc_attr( $li_class ) . "' >{$trigger}<div class='details-container' > " . esc_html( $item['hidden_content'] ) . " </div></li > ";
				} else {
					$trigger     = ! empty( $item['trigger'] ) ? '<span class="trigger">' . esc_html( $item['trigger'] ) . '</span>' : '';
					$img         = ! empty( $item['img_src'] ) ? '<div class="img-container"><img src="' . esc_attr( $item['img_src'] ) . '"></div>' : '';
					$description = ! empty( $item['description'] ) ? '<div class="desc_container">' . $item['description'] . '</div>' : '';
					if ( ! empty( $img ) || ! empty( $description ) ) {
						$li_class .= ' accordion-item';
					}
					$final_items .= " <li class='" . esc_attr( $li_class ) . "' >{$trigger}<div class='details-container' >{$description}{$img}</div ></li> ";
				}
			}
			$final_items .= '</ul>';

			return "
			<div class='wccso-admin-accordion-title' >
				<strong>{$title}</strong >
			</div>
			{$final_items}
			";
		}

		/**
		 * Creates meta box
		 */
		public function add_meta_box( $value ) {
			// Doesn't show metabox if enable = false
			if ( isset($value['enabled']) && $value['enabled']==false) {
					return;
			}
			if ( isset($value['enable']) && $value['enable']==false) {
					return;
			}

			$option_description    = isset( $value['description'] ) ? '<p>' . $value['description'] : '' . '</p>';
			$option_accordion      = $this->get_accordion( $value );
			$option_call_to_action = $this->get_call_to_action( $value );
			$option_accordion_str  = ! empty( $option_accordion ) ? $option_accordion : '';
			$option_title          = $value['title'];
			$option_id             = esc_attr( $value['id'] );

			echo '<tr><th scope="row" class="titledesc">' . $option_title . '</th><td>
			<div id="poststuff">
				<div id="' . $option_id . '" class="postbox">
					<div class="inside">
						' . $option_description . $option_accordion_str . $option_call_to_action. '
					</div>
				</div>
			</div></td></tr>
			';

			$style = $this->get_inline_style();
			$js    = $this->get_inline_js();
			echo $style . $js;
		}
	}
}
