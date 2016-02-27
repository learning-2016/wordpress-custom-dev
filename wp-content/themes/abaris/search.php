<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package ABARIS
 */

get_header(); ?>
<div class="row">

	<?php if( isset( $abaris['layout'] ) && $abaris['layout'] == 2 ) : ?>
		<?php get_sidebar(); ?>
	<?php endif; ?>

	<section id="primary" class="content-area two-thirds column span9">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'abaris' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'search' ); ?>

			<?php endwhile; ?>

			<?php 
				if( $abaris['pagenavi'] && function_exists( 'abaris_pagination' ) ) : 
					abaris_pagination();
				else :
					abaris_posts_nav();
				endif; 
			?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>
		<h3><?php //_e( 'Can\'t find what you\'re looking for? Search again!', 'abaris' ); ?></h3>
		<?php //get_search_form(); ?>

		</main><!-- #main -->
	</section><!-- #primary -->

	<?php if( isset( $abaris['layout'] ) && $abaris['layout'] == 3 ) : ?>
		<?php get_sidebar(); ?>
	<?php endif; ?>

	<?php if( ! isset( $abaris['layout'] ) ) : ?>
		<?php get_sidebar(); ?>
	<?php endif; ?>
	
<?php get_footer(); ?>