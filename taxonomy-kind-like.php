<?php
/**
 * Genesis Sample.
 *
 * This file adds the landing page template to the Genesis Sample Theme.
 *
 * Template Name: Landing
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

// add_filter( 'body_class', 'genesis_sample_add_body_class' );
/**
 * Adds landing page body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Original body classes.
 * @return array Modified body classes.
 */
function genesis_sample_add_body_class( $classes ) {

	$classes[] = 'taxonomy-like-page';
	return $classes;

}

remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
// remove_action('genesis_entry_content', 'genesis_do_post_content');
// add_action( 'genesis_entry_content', 'custom_entry_content' ); // Add custom loop

function custom_entry_content() {
	// WP_Query arguments
			$args = array(
				'cat'			=> $category->term_id,
				'orderby'		=> 'term_order',
			);

			// The Query
			$query = new WP_Query( $args );

			// The Loop
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
			?>
				<p><a href="<?php the_permalink();?>"><?php the_title(); ?></a></p>
			<?php

				} // End while
			} // End if

?>
<section class="response <?php echo empty( $url ) ? 'p-like-of' : 'u-like-of'; ?> h-cite">
<header>
<?php
echo Kind_Taxonomy::get_before_kind( 'like' );
if ( ! $embed ) {
	if ( ! empty( $url ) ) {
		echo sprintf( '<a href="%1s" class="p-name u-url">%2s</a>', $url, $cite['name'] );
	} else {
		echo sprintf( '<span class="p-name">%1s</span>', $cite['name'] );
	}
	if ( $author ) {
		echo ' ' . __( 'by', 'indieweb-post-kinds' ) . ' ' . $author;
	}
	if ( ! empty( $cite['publication'] ) ) {
		echo sprintf( ' <em>(<span class="p-publication">%1s</span>)</em>', $cite['publication'] );
	}
}
?>
</header>
<?php
if ( $cite ) {
	if ( $embed ) {
		echo sprintf( '<blockquote class="e-summary">%1s</blockquote>', $embed );
	} elseif ( array_key_exists( 'summary', $cite ) ) {
		echo sprintf( '<blockquote class="e-summary">%1s</blockquote>', $cite['summary'] );
	}
}

// Close Response
?>
</section>

<?php

}





// Runs the Genesis loop.
genesis();
