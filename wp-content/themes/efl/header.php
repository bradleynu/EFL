<?php
/**
 * The header for our theme
 * @package EFL_Theme
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
}
?>

<header id="masthead" class="hm-header">
    <div class="hm-header__bar">
        <div class="hm-header__container">

            <a class="hm-header__logo" href="<?php echo esc_url( home_url('/') ); ?>" rel="home">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>assets/dist/images/Logo-xs.png" alt="<?php esc_attr(get_bloginfo('name')); ?>">
            </a>

            <nav class="hm-header__nav" aria-label="<?php esc_attr_e('Primary Menu', 'efl'); ?>">
                <?php
                if ( has_nav_menu('menu-1') ) {
                    wp_nav_menu([
                        'theme_location' => 'menu-1',
                        'container'      => false,
                        'menu_class'     => 'hm-menu',
                        'fallback_cb'    => false,
                    ]);
                }
                ?>
            </nav>

            <div class="hm-header__actions">
                <a href="<?php echo esc_url( get_permalink( wc_get_page_id('myaccount') ) ); ?>" class="hm-action-link" aria-label="<?php esc_attr_e('My Account', 'efl'); ?>">
                    <i class="fa fa-user-o"></i>
                    <span class="hm-action-text"><?php esc_html_e('Profile', 'efl'); ?></span>
                </a>
                <a href="/my-lists/" class="hm-action-link" aria-label="<?php esc_attr_e('Wish List', 'efl'); ?>">
                    <i class="fa fa-heart-o"></i>
                    <span class="hm-action-text"><?php esc_html_e('Wish List', 'efl'); ?></span>
                </a>
                 <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="hm-action-link" aria-label="<?php esc_attr_e('Cart', 'efl'); ?>">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="hm-action-text"><?php esc_html_e('Cart', 'efl'); ?></span>
                </a>

                <button class="hm-search__toggle" aria-expanded="false" aria-controls="hm-search" aria-label="<?php esc_attr_e('Toggle Search', 'efl'); ?>">
                    <i class="fa fa-search"></i>
                </button>

                <?php if ( function_exists('pll_the_languages') ) : ?>
                    <div class="hm-lang">
                        <?php pll_the_languages(['show_flags' => 1, 'show_names' => 0, 'hide_if_empty' => 0, 'dropdown' => 1]); ?>
                    </div>
                <?php endif; ?>

                <button class="hm-burger" aria-expanded="false" aria-controls="hm-mobile-nav" aria-label="<?php esc_attr_e('Open Menu', 'efl'); ?>">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </div>

    <div id="hm-search" class="hm-search" hidden>
        <div class="hm-search__container">
            <form role="search" class="form-inline" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <input type="search" class="form-control" name="s" placeholder="<?php esc_attr_e('Search products...', 'efl'); ?>" value="<?php echo get_search_query(); ?>">
                <button class="btn btn-primary" type="submit" aria-label="<?php esc_attr_e('Search', 'efl'); ?>"><i class="fa fa-search"></i></button>
                <input type="hidden" name="post_type" value="product" />
            </form>
        </div>
    </div>
    
    <nav id="hm-mobile-nav" class="hm-mobile-nav" hidden></nav>
</header>