<?php
/**
 * @package ABARIS
 */
global $abaris;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title( '<i class="el el-tags"></i>', '' ); ?></a></h1>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php if( isset($abaris['featured-image'] ) && $abaris['featured-image'] ) : ?>
			<div class="thumb">
				<?php 
					if( has_post_thumbnail() && ! post_password_required() ) : 
						the_post_thumbnail(); 
					else :
						echo '<img src="' . ABARIS_CHILD_URL . '/images/no-image.png" />';
					endif;
				?>
			</div>
		<?php endif; ?>
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'abaris' ) ); ?>
		<?php //the_content( '',false,'' ); ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'abaris' ),
				'after'  => '</div>',
			) );
		?>
		<br class="clear" />
	</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<span class="posted-on"><?php abaris_post_date(); ?></span>
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
		<?php edit_post_link( __( '<span class="edit-link"><i class="el el-file-edit"></i> Edit</span>', 'abaris' ), '', '' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->