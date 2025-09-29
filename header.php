<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package slightly
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
<?php
	
if ( $post ) {
    $slightly_thumb_id = get_post_thumbnail_id($post->ID);
    $feat_image = wp_get_attachment_url( $slightly_thumb_id );
    $alt = get_post_meta($slightly_thumb_id, '_wp_attachment_image_alt', true);
    if ( $feat_image ) {
	    ?><meta property="og:image" content="<?php echo esc_url ( $feat_image ); ?>" /><?php
    }
}
?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'slightly' ); ?></a>


	<header id="masthead" class="site-header" role="banner">
  <div class="row">
    <div class="col-xs-12 site-header-col">
		<div class="site-branding">
			<?php
            $custom_logo_id = get_theme_mod( 'custom_logo' );
            $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
            $home_url = home_url( '/' );
            if ( has_custom_logo() ) {
                    echo '<a href="'. esc_url ( $home_url ) . '">';
                    echo '<img src="'. esc_url( $logo[0] ) .'">';
                    echo '</a>';
            } else {
                if ( is_front_page() || is_home() ) : ?>
                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php else : ?>
                    <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                <?php
                endif;
            }
			 ?>
		</div><!-- .site-branding -->
		<nav id="site-navigation" class="main-navigation" role="navigation">
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'slightly' ); ?></button>
			<?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu' ) ); ?>
		</nav><!-- #site-navigation -->
      </div>
    </div>
	</header><!-- #masthead -->


	<div id="content" class="site-content">
