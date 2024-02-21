<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package slightly
 */

get_header(); ?>

  <div class="row row--index">
    <div class="col-xs-12">

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', get_post_format() );

			$prev_post = get_adjacent_post(false, '', true);
			$current_post = get_post();

			if(!empty($prev_post)) {
				global $post;
				while ( ! $prev_post->post_title ) {
					$post = $prev_post;
					$prev_post = get_adjacent_post(false, '', true);
				}
				$post = $current_post;


            echo '<div class="row no-pad"><div class="col-xs-12 col-md-10 col-md-offset-1 no-pad"><div class="read-next"><span>Read this next</span><h2><a href="' . esc_url( get_permalink($prev_post->ID) ) . '" title="' . esc_attr( $prev_post->post_title ) . '">' . esc_html( $prev_post->post_title ) . '</a></h2></div></div></div>'; }
        
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
                echo '<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 no-pad">';
				comments_template();
                echo '</div>';
			endif;
		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->
    </div>

    </div>

<?php
get_footer();
