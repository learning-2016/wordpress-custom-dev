<?php
/**
 * Template Name: Full Width
 *
 */
get_header(); ?>
<div class="row">

	<div id="primary" class="content-area span12">
		<main id="main" class="site-main" role="main">
			
			<?php if ( $abaris['breadcrumb'] && function_exists( 'abaris_breadcrumbs' ) ) : ?>			
				<div id="breadcrumb" role="navigation">
					<?php abaris_breadcrumbs(); ?>
				</div>
			<?php endif; ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>