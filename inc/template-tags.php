<?php
/**
 * Custom template tags for this theme
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

if ( ! function_exists( 'lightspeed_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function lightspeed_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);

		printf(
			'<span class="posted-on">%1$s %2$s</span>',
			'<i class="icon-clock"></i>',
			$time_string
		);
	}
endif;

if ( ! function_exists( 'lightspeed_posted_by' ) ) :
	/**
	 * Prints HTML with meta information about theme author.
	 */
	function lightspeed_posted_by() {
		printf(
			/* translators: 1: icon. 2: post author, only visible to screen readers. 3: author link. */
			'<span class="byline"><i class="icon-pencil"></i> %1$s </span>',
			esc_html( get_the_author() )
		);
	}
endif;

if ( ! function_exists( 'lightspeed_comment_count' ) ) :
	/**
	 * Prints HTML with the comment count for the current post.
	 */
	function lightspeed_comment_count() {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';

			/* translators: %s: Name of current post. Only visible to screen readers. */
			comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'lightspeed' ), get_the_title() ) );

			echo '</span>';
		}
	}
endif;

if ( ! function_exists( 'lightspeed_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function lightspeed_entry_footer() {

		// Hide author, post date, category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			
			lightspeed_posted_by();
			lightspeed_posted_on();

			/* translators: used between list items, there is a space after the comma. */
			$categories_list = get_the_category_list( __( ', ', 'lightspeed' ) );
			if ( $categories_list ) {
				
				
				printf(
					/* translators: 1: icon. 2: posted in label, only visible to screen readers. 3: list of categories. */
					'<br>Posted in: <span class="cat-links">%1$s %2$s</span>',
					'<i class="icon-pushpin"></i>',
					$categories_list
				); // WPCS: XSS OK.
				
			}

			/* translators: used between list items, there is a space after the comma. */
			$tags_list = get_the_tag_list( '', __( ', ', 'lightspeed' ) );
			if ( $tags_list ) {
				printf(
					/* translators: 1: icon. 2: posted in label, only visible to screen readers. 3: list of tags. */
					'<br>Tagged: <span class="tags-links">%1$s %2$s</span>',
					'<i class="icon-price-tag"></i>',
					$tags_list
				); // WPCS: XSS OK.
			}
		}

		// Comment count.
		if ( ! is_singular() ) {
			lightspeed_comment_count();
		}

		
	}
endif;

if ( ! function_exists( 'lightspeed_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function lightspeed_post_thumbnail() {
		
		if ( ! lightspeed_can_show_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			the_post_thumbnail();
		
		else :
			?>
			<a class="post-thumbnail-inner" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php the_post_thumbnail( 'post-thumbnail' ); ?>
			</a>
			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'lightspeed_comment_avatar' ) ) :
	/**
	 * Returns the HTML markup to generate a user avatar.
	 */
	function lightspeed_get_user_avatar_markup( $id_or_email = null ) {

		if ( ! isset( $id_or_email ) ) {
			$id_or_email = get_current_user_id();
		}

		return sprintf( '<div class="comment-user-avatar comment-author vcard">%s</div>', get_avatar( $id_or_email, lightspeed_get_avatar_size() ) );
	}
endif;

if ( ! function_exists( 'lightspeed_discussion_avatars_list' ) ) :
	/**
	 * Displays a list of avatars involved in a discussion for a given post.
	 */
	function lightspeed_discussion_avatars_list( $comment_authors ) {
		if ( empty( $comment_authors ) ) {
			return;
		}
		echo '<ol class="discussion-avatar-list">', "\n";
		foreach ( $comment_authors as $id_or_email ) {
			printf(
				"<li>%s</li>\n",
				lightspeed_get_user_avatar_markup( $id_or_email )
			);
		}
		echo '</ol><!-- .discussion-avatar-list -->', "\n";
	}
endif;

if ( ! function_exists( 'lightspeed_comment_form' ) ) :
	/**
	 * Documentation for function.
	 */
	function lightspeed_comment_form( $order ) {
		if ( true === $order || strtolower( $order ) === strtolower( get_option( 'comment_order', 'asc' ) ) ) {

			comment_form(
				array(
					'logged_in_as' => null,
					'title_reply'  => null,
				)
			);
		}
	}
endif;

if ( ! function_exists( 'lightspeed_the_posts_navigation' ) ) :
	/**
	 * Documentation for function.
	 */
	function lightspeed_the_posts_navigation() {
		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => sprintf(
					'%s <span class="nav-prev-text">%s</span>',
					'<i class="icon-circle-right"></i>',
					__( 'Newer posts', 'lightspeed' )
				),
				'next_text' => sprintf(
					'<span class="nav-next-text">%s</span> %s',
					__( 'Older posts', 'lightspeed' ),
					'<i class="icon-circle-left"></i>'
				),
			)
		);
	}
endif;


