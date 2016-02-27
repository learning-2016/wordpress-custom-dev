<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package ABARIS
 */
	get_header(); 

	if ( isset($abaris) ) {
		if( isset($abaris['homepage_blocks']['enabled']['slider']) && isset($abaris['slides']) ) {
			$slides = $abaris['slides'];
			$output = '';
			if( count($slides) >= 1) {

				$output .= '<div class="flex-container">';
				$output .= '<div class="container">';
				$output .= '<div class="row">';
				$output .= '<div class="flexslider">';
				$output .= '<div class="bg-bottom"></div>';					
				$output .= '<ul class="slides">';

				foreach($slides as $slide) {
					$output .= '<li>';

					$output .= '<div class="flex-image"><img src="' . esc_url( $slide['image'] ) . '" alt="" ></div>';
					if ( $slide['description'] != '' ) {
						$output .= '<div class="flex-caption">' . $slide['description'] . '</div>';
					}
					$output .= '</li>';
				}

				$output .= '</ul>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div><!-- .flexslider -->';
				$output .= '</div><!-- .flex-container -->';
			}
			echo $output;
			
		}
					
		if( isset( $abaris['homepage_blocks']['enabled']['services'] ) ) {
			$output = '';
				$output = '<div class="services">';
				$output .= '<div class="container">';
				$output .= '<div class="row">';
					if( isset( $abaris['service-icon-1'] ) && isset( $abaris['service-description-1'] ) ) {
						$output .= '<div class="span4" id="service1">';
						$output .= '<h3><i class="' . esc_attr( $abaris['service-icon-1'] ) . '"></i></h3>';
						$output .= '<div class="service">' . $abaris['service-description-1'] . '</div>';
						$output .= '</div><!-- .span4 -->';
					}

					if( isset( $abaris['service-icon-2'] ) && isset( $abaris['service-description-2'] ) ) {
						$output .= '<div class="span4" id="service2">';
						$output .= '<h3><i class="' . esc_attr( $abaris['service-icon-2'] ) . '"></i></h3>';
						$output .= '<div class="service">' . $abaris['service-description-2'] . '</div>';
						$output .= '</div><!-- .span4 -->';
					}

					if( isset( $abaris['service-icon-3'] ) && isset( $abaris['service-description-3'] ) ) {
						$output .= '<div class="span4" id="service3">';
						$output .= '<h3><i class="' . esc_attr( $abaris['service-icon-3'] ) . '"></i></h3>';
						$output .= '<div class="service">' . $abaris['service-description-3'] . '</div>';
						$output .= '</div><!-- .span4 -->';
					}

				$output .= '</div><!-- .row -->';
				$output .= '</div><!-- .container -->';
				$output .= '</div><!-- .services -->';

			echo $output;
		}
		?>
		<div id="content" class="site-content container">
			<div class="row">
				
				<div id="primary" class="content-area span12">
					<main id="main" class="site-main" role="main">
				<?php
					if( isset( $abaris['homepage_blocks']['enabled'] )) {
						$enabled = $abaris['homepage_blocks']['enabled'];
						foreach ($enabled as $key => $value) {
							switch ($key) {
								case 'features':
									$features = isset( $abaris['features'] ) ? $abaris['features'] : '';
								?>
								<div class="row">
									<div class="feature-wrap">
										<div class="span6" id="whyus">
											<div class="feature2">
												<?php echo isset( $abaris['features'] ) ? $abaris['features'] : '' ?>
											</div>
										</div>

										<div class="span6" id="skills">
										<?php
											$output = '';
											if ( isset( $abaris['skill-heading'] ) ) {
												$output .= '<h2><i class="el el-tags"></i>' . $abaris['skill-heading'] . '</h2>';
											}

											for ($i=1;$i<6;$i++) {
												$skill = "skill-{$i}";
												$percentage = "percentage-{$i}";
												$icon = "skill-icon-{$i}";
												if( isset( $skill ) && isset( $abaris[$icon] ) && isset( $abaris[$percentage] ) && isset( $abaris[$skill] ) ) {
													$output .= '<div class="skill-container"><i class="' . esc_attr( $abaris[$icon] ) . '"></i>';
													$output .= '<div class="skill">';
													$output .= '<div class="skill-percentage percent' . esc_attr( $abaris[$percentage] ) .' start"><span class="circle"></span></div>';
													$output .= '<div class="skill-content">'  . $abaris[$skill] .' ' . $abaris[$percentage] . '%</div>';
													$output .= '</div>';
													$output .= '</div>';
												}
											}

											echo $output;
											?>
										</div> <!-- .span6 skills -->
										<br class="clear"/>
									</div> <!-- .features-wrap -->
								</div> <!-- .row -->
								
								<div class="divider div2"><span></span></div>

								<?php
									break;
								case 'recent_posts' :
								?>
									<div class="row">
										<div class="span12">
											<h2><i class="el el-tags"></i><?php _e('From the Blog','abaris'); ?></h2>
											<?php abaris_recent_posts(); ?>
										</div><!-- .span12 -->
									</div><!-- .row -->
								<?php
								break;
								case 'default':
									while ( have_posts() ) : the_post();
										the_content();
									endwhile;
								break;
							}
						}
					}
				?>
					</main><!-- #main -->
				</div><!-- #primary -->
<?php
	} else {

		if( isset($abaris_home) && $abaris_home['slides'] ) {
			$slides = $abaris_home['slides'];
			$output = '';
			if( count($slides) >= 1) {

				$output .= '<div class="flex-container">';
				$output .= '<div class="container">';
				$output .= '<div class="row">';
				$output .= '<div class="flexslider">';
				$output .= '<div class="bg-bottom"></div>';					
				$output .= '<ul class="slides">';

				foreach($slides as $slide) {
					$output .= '<li>';

					$output .= '<div class="flex-image"><img src="' . esc_url( $slide['image'] ) . '" alt="" ></div>';
					if ( $slide['description'] != '' ) {
						$output .= '<div class="flex-caption">' . $slide['description'] . '</div>';
					}
					$output .= '</li>';
				}

				$output .= '</ul>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div><!-- .flexslider -->';
				$output .= '</div><!-- .flex-container -->';
			}
			echo $output;
			
		}

		if( isset( $abaris_home['services'] ) ) {
			$output = '';
				$output = '<div class="services">';
				$output .= '<div class="container">';
				$output .= '<div class="row">';
				foreach ($abaris_home['services'] as $service) {
					if( isset( $service['icon'] ) && isset( $service['description'] ) ) {
						$output .= '<div class="span4" id="service1">';
						$output .= '<h3><i class="' . esc_attr( $service['icon'] ) . '"></i></h3>';
						$output .= '<div class="service">' . $service['description'] . '</div>';
						$output .= '</div><!-- .span4 -->';
					}
				}
				$output .= '</div><!-- .row -->';
				$output .= '</div><!-- .container -->';
				$output .= '</div><!-- .services -->';

			echo $output;
		}
		?>
		<div id="content" class="site-content container">
			<div class="row">
				<div id="primary" class="content-area span12">
					<main id="main" class="site-main" role="main">
					<?php if( isset($abaris_home['features']) ) : ?>
						<div class="row">
							<div class="feature-wrap">
								<div class="span6" id="whyus">
									<div class="feature2">
										<?php echo $abaris_home['features']; ?>
									</div>
								</div>
					<?php endif; ?>
								<div class="span6" id="skills">
								<?php
									$output = '';
									if ( isset( $abaris_home['skill-heading'] ) ) {
										$output .= '<h2><i class="el el-tags"></i>' . esc_html( $abaris_home['skill-heading'] ) . '</h2>';
									}

									for ($i=1;$i<6;$i++) {
										$skill = "skill-{$i}";
										$percentage = "percentage-{$i}";
										$icon = "skill-icon-{$i}";
										if( isset( $skill ) && isset( $abaris_home[$icon] ) && isset( $abaris_home[$percentage] ) && isset( $abaris_home[$skill] ) ) {
											$output .= '<div class="skill-container"><i class="' . esc_attr( $abaris_home[$icon] ) . '"></i>';
											$output .= '<div class="skill">';
											$output .= '<div class="skill-percentage percent' . esc_attr( $abaris_home[$percentage] ) .' start"><span class="circle"></span></div>';
											$output .= '<div class="skill-content">'  . $abaris_home[$skill] .' ' . $abaris_home[$percentage] . '%</div>';
											$output .= '</div>';
											$output .= '</div>';
										}
									}

									echo $output;
									?>
								</div> <!-- .span6 skills -->
								<br class="clear"/>
							</div> <!-- .features-wrap -->
						</div> <!-- .row -->
						
						<div class="divider div2"><span></span></div>
						<div class="row">
							<div class="span12">
								<h2><i class="el el-tags"></i><?php _e('From the Blog','abaris'); ?></h2>
								<?php abaris_recent_posts(); ?>
							</div><!-- .span12 -->
						</div><!-- .row -->
					<?php
						while ( have_posts() ) : the_post();
							the_content();
						endwhile;
					?>
					</main><!-- #main -->
				</div><!-- #primary -->
	<?php		
	}
		get_footer(); 
?>