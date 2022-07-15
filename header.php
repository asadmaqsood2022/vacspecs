<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>

    <!-- Preconnect+Preload Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <!-- pregetch dns common scripts -->
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">
    <link rel="dns-prefetch" href="https://www.google-analytics.com">
    <link rel="dns-prefetch" href="https://cdn.calltrk.com">
    <link rel="dns-prefetch" href="https://js.calltrk.com">

    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <link rel="preload" href="<?php echo get_stylesheet_directory_uri(); ?>/css/fonts/standard-icons/icomoon.ttf" as="font" type="font/ttf" crossorigin="">

    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php do_action( 'wp_body_open' ); ?>

    <!-- header starts here -->
    <header class="header">
        <div class="top-bar">
            <div class="container">
                <div class="left">
                    <p> <?php the_field('top_bar_covid_title','option') ?></p>
                </div>
                <div class="right">
                    <span> <a href="<?php the_field('resource_link','option') ?>"><?php the_field('resource_title','option') ?></a></span>
            <?php if( have_rows('social_media_icons', 'options') ): 
                     while ( have_rows('social_media_icons', 'options') ) : the_row(); ?>
                        <?php $img = get_sub_field( "icon" ); ?>
                    <span><a href="<?php the_sub_field('social_link'); ?>" target="_blank">
                        <img src="<?php echo $img['url'] ?>" alt="<?php echo $img['alt'] ?>" title="<?php echo $img['alt'] ?>"></a>
                    </span>
                    <?php  endwhile; endif; ?>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="header-content">
                <nav class="navbar navbar-light">
                    <div class="logo">
                        <?php echo inet_custom_logo(); ?>
                        
                    </div>
                    <div class="search-box">
                        <div class="form-group has-search">
                            <?php get_product_search_form(); ?>
                        </div>
                    </div>
					<div class="contact-box">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/phone-alt-solid.svg">
						<div class="contact-info">
							<div>Local: <a href="tel:4032275511">403-227-5511</a></div>
							<div>Toll-Free: <a href="tel:18882275511">1-888-227-5511</a></div>
						</div>
				    </div>
					<div class="card-options">
                        <a href="/my-account/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/user.png"></a>

                        <!-- <?php
                          $user = wp_get_current_user();
                          if ( $user ) : ?>
                           <img src="<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>" />
                        <?php endif; ?> -->
						<a href="/wishlist/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Heart.svg"></a>
						<a href="javascript:void(0)" class="cart-image show-cart"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/shopping-cart-solid.svg">
                            <span class="cart-number">
                                <?php
                                    $cartcount = WC()->cart->get_cart_contents_count();
                                    if ($cartcount > 0) { echo $cartcount; } else {?>
                                        <style>
                                        .cart-number {

                                        display:none !important;
                                        }
                                        </style>
                                <?php  }
                                ?> 
                                
                            </span>
                        </a>    
					</div>
                    <?php if ( has_nav_menu( 'mobile-nav') ) : ?>
                    <div class="mobile-nav-toggle"><i class="icon-menu"></i></div>
                    <div class="mobile-nav-container">
                        <div class="close" style="padding: 10px 15px 10px 0; text-align:right">
                            <span>Close <i class="icon-x" style="cursor:pointer;"></i></span>
                        </div>
                        <nav id="mobile-nav">
                            <?php
                          wp_nav_menu(
                            array(
                            'theme_location' => 'desktop-nav',
                            'menu_class'     => 'mobile-nav ',
                            'items_wrap'   => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                            'container'    => false
                            )
                          );
                        ?>
                        </nav>
                    </div>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>