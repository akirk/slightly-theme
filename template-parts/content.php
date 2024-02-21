<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package slightly
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row no-pad">
      
        <?php if ( is_single() ) : ?>
            <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 no-pad">
                <header class="entry-header">
                    <?php
                        the_title( '<h1 class="entry-title">', '</h1>' );

                    if ( 'post' === get_post_type() ) : ?>
                    <div class="entry-meta">
                        <?php slightly_posted_on(); ?>
                    </div><!-- .entry-meta -->
                    <?php
                    endif; ?>
                </header><!-- .entry-header -->
                <div class="entry-content">

<?php
    $slightly_thumb_id = get_post_thumbnail_id($post->ID);
    $feat_image = wp_get_attachment_url( $slightly_thumb_id );
    $alt = get_post_meta($slightly_thumb_id, '_wp_attachment_image_alt', true); ?>
<?php if( $feat_image ) : ?>
    <img src="<?php echo esc_url ( $feat_image ); ?>" alt="<?php echo esc_attr( $alt ); ?>" class="featured-image">
<?php endif; ?>
                    
                    <?php
                        the_content( sprintf(
                            /* translators: %s: Name of current post. */
                            wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'slightly' ), array( 'span' => array( 'class' => array() ) ) ),
                            the_title( '<span class="screen-reader-text">"', '"</span>', false )
                        ) );

                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'slightly' ),
                            'after'  => '</div>',
                        ) );
                    ?>
                </div><!-- .entry-content -->
                <footer class="entry-footer">
                    <?php slightly_entry_footer(); ?>
                </footer><!-- .entry-footer -->
            </div>
        <?php else : ?>

        <div class="col-xs-12 col-sm-11 no-pad">
            <header class="entry-header">
                <?php
                    the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

                if ( 'post' === get_post_type() ) : ?>
                <div class="entry-meta">
                    <a href=" <?php echo esc_url( get_permalink() ) ?> "><?php slightly_posted_on(); ?></a>
                </div><!-- .entry-meta -->
                <?php
                endif; ?>
            </header><!-- .entry-header -->
            <div class="entry-content">
                
            <?php
                $slightly_thumb_id = get_post_thumbnail_id($post->ID);
                $feat_image = wp_get_attachment_url( $slightly_thumb_id );
                $alt = get_post_meta($slightly_thumb_id, '_wp_attachment_image_alt', true); ?>
            <?php if( $feat_image ) : ?>
                <img src="<?php echo esc_url ( $feat_image ); ?>" alt="<?php echo esc_attr( $alt ); ?>" class="featured-image">
            <?php endif; ?>
                
            <?php
                    the_content( sprintf(
                        /* translators: %s: Name of current post. */
                        wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'slightly' ), array( 'span' => array( 'class' => array() ) ) ),
                        the_title( '<span class="screen-reader-text">"', '"</span>', false )
                    ) );

                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'slightly' ),
                        'after'  => '</div>',
                    ) );
                ?>
            </div><!-- .entry-content -->
        <footer class="entry-footer">
            <?php slightly_entry_footer(); ?>
        </footer><!-- .entry-footer -->
            
        </div>

        </a>
        
        <?php endif; ?>
        
        
    </div><!-- end .row-->
</article><!-- #post-## -->
