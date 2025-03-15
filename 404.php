<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package slightly
 */

add_filter( 'get_search_query', function( $query ) {
	if ( is_404() ) {
		$query = urldecode( get_query_var( 'pagename' ) );
	}
	return $query;
} );
get_header(); ?>

<div class="row row--index">
      <?php if( get_theme_mod( 'hide_main_sidebar' ) == '1') { ?>
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
      <?php } else {?>
        <div class="col-xs-12">
      <?php } //end if ?>
        <header class="page-header">
            <h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'slightly' ); ?></h1>
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

			<section class="error-404 not-found">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'slightly' ); ?></p>

					<?php
						get_search_form();
					?>
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->
      </div>
    <?php if( get_theme_mod( 'hide_main_sidebar' ) == '') { ?>
    <div class="col-xs-12 col-sm-4 col-sm-offset-1">
        <?php
        get_sidebar(); ?>
    </div>
    <?php } // end if ?>
</div>

<?php
get_footer();
