<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package ABARIS
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><i class="el el-tags"></i><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'abaris' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php edit_post_link( __( 'Edit', 'abaris' ), '<footer class="entry-meta"><span class="edit-link"><i class="el el-file-edit"></i> ', '</span></footer>' ); ?>
</article><!-- #post-## -->
