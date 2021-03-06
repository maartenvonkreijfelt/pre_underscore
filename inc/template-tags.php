<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Pre_Underscores
 */

if ( ! function_exists( 'pre_underscores_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function pre_underscores_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s"><span style="display:none">%4$s</span></time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Published  %s', 'post date', 'pre_underscores' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'Written by %s', 'post author', 'pre_underscores' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span> <span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.


		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo ' <span class="comments-link"><span class="extra">Discussion </span>';
			/* translators: %s: post title */
			comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'pre_underscores' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
			echo '</span>';
		}

		edit_post_link(
			sprintf(
			/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'pre_underscores' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			' <span class="edit-link"><span class="extra">Admin </span>',
			'</span>'
		);

	}
endif;

if ( ! function_exists( 'pre_underscores_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function pre_underscores_entry_footer() {
		// Hide tag text for pages.
		if ( 'post' === get_post_type() ) {
			

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'pre_underscores' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'pre_underscores' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}




	}
endif;




if ( ! function_exists( 'pre_underscores_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function pre_underscores_post_thumbnail($size = 'pre_underscores-full-bleed') {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<figure class="featured-image full-bleed">
		<?php the_post_thumbnail($size = 'pre_underscores-full-bleed'); ?>
	</figure><!-- .featured-image full-bleed -->

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
		?>
	</a>

	<?php endif; // End is_singular().
}
endif;

function pre_underscores_the_category_list() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'pre_underscores' ) );
		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			printf( '<span class="cat-links">' . esc_html__( '%1$s', 'pre_underscores' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}
	}
}

/**
 * Post navigation (previous / next post) for single posts.
 */
function pre_underscores_post_navigation() {
	the_post_navigation( array(
		'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'pre_underscores' ) . '</span> ' .
		               '<span class="screen-reader-text">' . __( 'Next post:', 'humescores' ) . '</span> ' .
		               '<span class="post-title">%title</span>',
		'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'humescores' ) . '</span> ' .
		               '<span class="screen-reader-text">' . __( 'Previous post:', 'humescores' ) . '</span> ' .
		               '<span class="post-title">%title</span>',
	) );
}

/**
 * Customize ellipsis at end of excerpts.
 */
function pre_underscores_excerpt_more( $more ) {
	return "…";
}
add_filter( 'excerpt_more', 'pre_underscores_excerpt_more' );

/**
 * Filter excerpt length to 100 words.
 */
function pre_underscores_excerpt_length( $length ) {
	return 100;
}
add_filter( 'excerpt_length', 'pre_underscores_excerpt_length');