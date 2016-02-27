<?php
/**
 * @package ABARIS
 */
global $abaris;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title( '<i class="el el-tags"></i>','' ); ?></h1>

		<div class="entry-meta">
			<?php abaris_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if( isset( $abaris['single-featured-image'] ) && $abaris['single-featured-image'] ) : ?>
			<?php if( has_post_thumbnail() ) : ?>
				<div class="post-thumb">
					<?php the_post_thumbnail(); ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'abaris' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'abaris' ) );
				if ( $categories_list && abaris_categorized_blog() ) :
			?>
			<span class="cat-links">
				<i class="el el-list-alt"></i>
				<?php printf( __( ' %1$s', 'abaris' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'abaris' ) );
				if ( $tags_list ) :
			?>
			<span class="tags-links">
				<i class="el el-tags"></i>
				<?php printf( __( ' %1$s', 'abaris' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

	</footer><!-- .entry-meta -->
</article><!-- #post-## -->