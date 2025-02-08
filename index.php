<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package slightly
 */

get_header(); ?>

<?php function slightly_page_featured_image() {
        $id = get_queried_object_id ();
        // Check if the post/page has featured image
        if ( has_post_thumbnail( $id ) ) {
            // Change thumbnail size, but I guess full is what you'll need
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'full' );
            $url = $image[0];
        } else {
            $url = 'undefined';
        }
    return $url;
} ?>

<?php function slightly_page_featured_alt() {
        $id = get_queried_object_id ();
        // Check if the post/page has featured image
        if ( has_post_thumbnail( $id ) ) {
            $alt = get_post_meta(get_post_thumbnail_id( $id ), '_wp_attachment_image_alt', true); 
        } else {
            $alt = 'undefined';
        }
    return $alt;
} ?>

<?php if( false && slightly_page_featured_image() !== 'undefined' && slightly_page_featured_alt() !== 'undefined' ) : ?>
    <div class="pageBannerImage">
        <img src="<?php echo esc_url ( slightly_page_featured_image() ); ?>" alt="<?php echo esc_attr( slightly_page_featured_alt() ); ?>" class="pageBannerImage__image">
    </div>
<?php endif; ?>

<div class="row row--index">
      <?php if( get_theme_mod( 'hide_main_sidebar' ) == '1') { ?>
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
      <?php } else {?>
        <div class="col-xs-12">
      <?php } //end if ?>
			<header class="page-header">
				<h2 class="h1 page-title tagline"><?php echo esc_html ( get_bloginfo( 'description' ) ); ?></h2>
			</header><!-- .page-header -->
    </div>
</div>
  <div class="row">
      <?php if( get_theme_mod( 'hide_main_sidebar' ) == '1') { ?>
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
      <?php } else {?>
        <div class="col-xs-12 col-sm-7">
      <?php } //end if ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

        <?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

            echo '<div class="row no-pad"><div class="col-xs-12 col-sm-11 no-pad">';
			the_posts_navigation();
            echo '</div></div>';

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
        
    </div>
  <?php if( get_theme_mod( 'hide_main_sidebar' ) == '') { ?>
  <div class="col-xs-12 col-sm-4 col-sm-offset-1">
      <?php
get_sidebar(); ?>
      </div>
      
  </div>
  <?php } // end if ?>

<?php
get_footer();
