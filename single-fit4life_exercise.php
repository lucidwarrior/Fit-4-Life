<?php

get_header();

?>

<div id="main-content">
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">

				<?php while ( have_posts() ) : the_post(); ?>

				<div id="eHeader">
					<h1><?php the_title(); ?></h1>
					<div class="eBlockImage">
						<p><img src="<?php the_field('fit4life_cover_image'); ?>"></p>
					</div>
					<div class="eBlockContents">
						<h3><?php the_field('fit4life_exercise_short_description'); ?></h3>
						<p class="taxList"><?php the_terms( $post->ID, 'fit4life_tax_focus', 'Focus: ', ' / ' ); ?></p>
						<p class="taxList"><?php the_terms( $post->ID, 'fit4life_tax_movement', 'Movements: ', ' / ' ); ?></p>
						<p class="taxList"><?php the_terms( $post->ID, 'fit4life_tax_area', 'Areas: ', ' / ' ); ?></p>
						<p class="taxList"><?php the_terms( $post->ID, 'fit4life_tax_usage', 'Usage: ', ' / ' ); ?></p>
						<div style="padding-top: 30px;">
							<?php $video_object = get_field('fit4life_video_link');
								if( $video_object or have_rows('fit4life_performance_steps')): ?>
								<h3 class="taxList">Instructions</h3>
								<p><?php the_field('fit4life_performance_details'); ?></p>
							<?php endif; ?>
						</div>
					</div>
					<div style="clear:both"></div>
				</div>
				<hr>
				<div>
					<?php the_field('fit4life_video_link'); ?>
				</div>

				<div class="pSteps">
					<!-- loop through performance steps -->
					<?php if( have_rows('fit4life_performance_steps') ): ?>

						<?php while( have_rows('fit4life_performance_steps') ): the_row(); ?>
							<div id="eHeader">
								<div class="eBlockImage">
									<p><img src="<?php the_sub_field('fit4life_performance_step_image'); ?>"></p>
								</div>
								<div class="eBlockContents">
									<h3><?php the_sub_field('fit4life_performance_step_title'); ?></h3>
									<p><?php the_sub_field('fit4life_performance_step_description'); ?></p>
								</div>
								<div style="clear:both"></div>
							</div>
							<hr>
						<?php endwhile; // while( have_rows('fit4life_performance_steps') ): ?>

					<?php endif; // if( have_rows('fit4life_performance_steps') ): ?>

				</div>

				<?php endwhile; ?>

			</div> <!-- #left-area -->

			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php get_footer(); ?>
