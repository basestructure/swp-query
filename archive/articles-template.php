<?php
/**
 * Template Name: Articles Archives
 * Description: Used as a page template to show page contents, followed by a loop through a CPT archive 
 */

// Remove the standard pagination, so we don't get two sets
remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

/**
 * Galleries Loop
 * Custom paginated loop
 */
class SWPCustomArchiveLoop {

	public function swp_custom_loop() {

		$args = array(
			'post_type' 		=> 'post', // enter your custom post type
			'orderby' 			=> 'date',
			'order' 			=> 'DESC',
			'posts_per_page'	=> '3', // overrides posts per page in theme settings
			'post_status'    	=> 'publish',
			'paged' 			=> get_query_var( 'paged' ),
		);
		
		global $wp_query;

		$wp_query = new WP_Query( $args );

		if( $wp_query->have_posts() ): 

			while( $wp_query->have_posts() ): $wp_query->the_post(); global $post;
				// ARCHIVE DISPLAY - START EDITING BELOW ---------------------------------- ?>
				
				<h5><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h5>

				<?php // ARCHIVE DISPLAY - STOP EDITING HERE ---------------------------------
			endwhile;

			/* PAGINATION
			 * ---------------------------------------------------------------------------- */
				/* With previous and next pages
				 * -------------- */
				//previous_posts_link(); next_posts_link();
				
				/* Without previous and next pages
				 * -------------- */
				//the_posts_pagination( array( 'mid_size'  => 2 ) );
				
				/* Pagination with Alternative Prev/Next Text
				 * -------------- */
				echo get_the_posts_pagination( array(
				    'mid_size' => 2,
				    'prev_text' => __( '<<', 'textdomain' ),
				    'next_text' => __( '>>', 'textdomain' ),
				) );

				// genesis_posts_nav();
			/* PAGINATION END
			 * ---------------------------------------------------------------------------- */

		endif;

		wp_reset_query();

	}

	// CONSTRUCT
	public function __construct() {

		if( !is_admin() ) {
			add_action( 'genesis_after_entry', array( $this, 'swp_custom_loop' ) );
		}

	}
}

$q = new SWPCustomArchiveLoop();

genesis();