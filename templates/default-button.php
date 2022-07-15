<?php
/**
 * Toggle button template - Default button
 *
 * Button responsible for Comparing products
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php
$id         = get_the_ID();
$action     = $params['btn_data_action'];
$class      = $params['btn_class'];
$label      = $params[ 'btn_label' ];
$icon_class = $params['btn_icon_class'];
$href       = $params['btn_href'];
?>

<div class="vacsp-default-btn-wrapper">
	<a href="<?php echo esc_url($href); ?>" data-item_id="<?php echo $id; ?>" data-action="<?php echo esc_attr( $action );?>" class="<?php echo esc_attr( $class );?>">
		<span class="vacsp-wc-cp-btn-text"><?php echo esc_html( $label ); ?></span>
		<i class="<?php echo esc_attr( $icon_class );?>" aria-hidden="true"></i>
	</a>
</div>
