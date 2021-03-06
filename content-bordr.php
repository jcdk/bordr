<?php
/**
 * @package Nu Themes
 */
 
global $post;
$post_slug=$post->post_name;
 
?>
<?php if(current_user_can('edit_post')): ?>
  <div class="row"> 
  	<div class="col-xs-12" style="text-align:right;">
	  <div style="margin: 0 0 1em;">
		<a href="/wp-admin/post.php?post=<?php the_ID() ?>&action=edit" class="btn btn-primary">
		  <i class="fa fa-pencil" aria-hidden="true"></i> &nbsp; <?php echo get_post_status() == 'draft' ? 'Edit draft' : 'Edit'; ?>
		</a>
	  </div>
	</div>
  </div>
<?php endif; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'box' ); ?>>
	<header class="entry-header">

		<!-- Begin Gallery -->

		<?php 

		$related_activity = get_field('related_activity');
		$brdr_story = get_field('brdr_story');
		$brdr_image = get_field('brdr_image');

		?>
		<p><img src="<?php echo $brdr_image['url']; ?>" alt="<?php echo $brdr_image['alt']; ?>" class="img-responsive"/></p>
		<a href="<?php the_permalink(); ?>" title="an experience of the <?php the_title_attribute(); ?> border">
		<h1 class="entry-title"><?php the_field('brdr_from'); ?> &raquo; <?php the_field('brdr_to'); ?><br/></h1>
		</a>
		<p class="lead">
			A story from <a href='/activity/<?php echo get_post($related_activity)->post_name; ?>'><?php echo get_post($related_activity)->post_title; ?></a>
		</p>
	</header>

	<div class="clearfix entry-content">
		<?php

			if (get_field('brdr_story')) :
			the_field('brdr_story');
			endif;
			?>

		<div class="row">
			<div class="col-md-6">
			<h2>Experience of this border</h2>
			<?php if (get_field('brdr_invisible_visible') == TRUE) : ?>
				<div class="chart_visible barchart"></div>
				<script>
				$(function() {
					var data = {
					  'totalMin': 0,
					  'totalMax': 100,
					  'totalAverage': 50,
					  'postTotal': <?php the_field('brdr_invisible_visible'); ?>,
					  'leftField': 'Invisble',
					  'rightField': 'Visible'
					}
					var chart = ".chart_visible";
					drawdotchart(data, chart);	
				});
				</script>
			<?php endif; ?>

			<?php if (get_field('brdr_unimportant_important') == TRUE) : ?>
				<div class="chart_important barchart"></div>
				<script>
				$(function() {
					var data = {
					  'totalMin': 0,
					  'totalMax': 100,
					  'totalAverage': 50,
					  'postTotal': <?php the_field('brdr_unimportant_important'); ?>,
					  'leftField': 'Unimportant',
					  'rightField': 'Important'
					}
					var chart = ".chart_important";
					drawdotchart(data, chart);	
				});
				</script>
			<?php endif; ?>

			<?php if (get_field('brdr_negative_positive') == TRUE) : ?>
				<div class="chart_positive barchart"></div>
				<script>
				$(function() {
					var data = {
					  'totalMin': 0,
					  'totalMax': 100,
					  'totalAverage': 50,
					  'postTotal': <?php the_field('brdr_negative_positive'); ?>,
					  'leftField': 'Negative',
					  'rightField': 'Positive'
					}
					var chart = ".chart_positive";
					drawdotchart(data, chart);	
				});
				</script>
			<?php endif; ?>
			</div>
			<div class="col-md-6">
			<?php
			if (get_field('brdr_location')) : ?>
			<h2>Location of border</h2>
			<?php
			$location = get_field('brdr_location');			
			?><img src="https://api.tiles.mapbox.com/v3/deklerk.map-57h1d46y/url-bit.ly%2F18KNEkg(<?php echo $location['lng'];?>,<?php echo $location['lat'];?>)/<?php echo $location['lng'];?>,<?php echo $location['lat'];?>,4/800x400.png" class="img-rounded img-responsive">
			<?php echo $location['address']; 
			endif;
			?>
			</div>
		</div>
		<?php the_excerpt(); ?>
		<footer class="entry-meta entry-footer">
		<h2>Related experiences</h2>
				<div id="masonry" class="row">
					<?php
					$cvalue = get_field('brdr_invisible_visible'); 
					$excludePosts = array();
					$excludePosts[] = get_the_ID();
					if ($cvalue == 100) { $cvalue = 60; $compare = ">"; } 
					else { $cvalue = 40; $compare = "<"; }
					  $second_query = new WP_Query( array(
						  'post_type' => 'bordr',
						  'meta_query' => array(
								'key'		=> 'brdr_invisible_visible',
								'value'		=> $cvalue,
								'compare'	=> $compare,
								'type' => 'numeric'
							),
						  'posts_per_page' => 1,
						  'ignore_sticky_posts' => 1,
						  'orderby' => 'rand',
						  'post__not_in'=>$excludePosts
					   ) );
					//Loop through posts and display...
						if($second_query->have_posts()) {
						 while ($second_query->have_posts() ) : $second_query->the_post(); $image = get_field('brdr_image'); $cat_title = "as visible as"; ?>								
							
							<?php include(locate_template('bordrloop.php')); ?>				
							<?php $excludePosts[] = get_the_ID(); ?>
						
							<?php endwhile; wp_reset_query();
					   } ?>
					<?php
					$cvalue = get_field('brdr_unimportant_important'); 
					if ($cvalue == 100) { $cvalue = 60; $compare = ">"; } 
					else { $cvalue = 40; $compare = "<"; }
					  $second_query = new WP_Query( array(
						  'post_type' => 'bordr',
						  'meta_query' => array(
								'key'		=> 'brdr_unimportant_important',
								'value'		=> $cvalue,
								'compare'	=> $compare,
								'type' => 'numeric'
							),
						  'posts_per_page' => 1,
						  'ignore_sticky_posts' => 1,
						  'orderby' => 'rand',
						  'post__not_in'=>$excludedPosts
					   ) );
					//Loop through posts and display...
						if($second_query->have_posts()) {
						 while ($second_query->have_posts() ) : $second_query->the_post(); $image = get_field('brdr_image'); $cat_title = "as important as"; ?>
								
							<?php include(locate_template('bordrloop.php')); ?>
							<?php $excludePosts[] = get_the_ID(); ?>
													
							<?php endwhile; wp_reset_query();
					   } ?>				
					<?php
					$cvalue = get_field('brdr_negative_positive'); 
					if ($cvalue == 100) { $cvalue = 60; $compare = ">"; } 
					else { $cvalue = 40; $compare = "<"; }
					  $second_query = new WP_Query( array(
						  'post_type' => 'bordr',
						  'meta_query' => array(
								'key'		=> 'brdr_negative_positive',
								'value'		=> $cvalue,
								'compare'	=> $compare,
								'type' => 'numeric'
							),
						  'posts_per_page' => 1,
						  'ignore_sticky_posts' => 1,
						  'orderby' => 'rand',
						  'post__not_in'=>$excludePosts
					   ) );
					//Loop through post and display...
						if($second_query->have_posts()) {
						 while ($second_query->have_posts() ) : $second_query->the_post(); $cat_title = "as positive as"; ?>
								
							<?php include(locate_template('bordrloop.php')); ?>
							<?php $excludePosts[] = get_the_ID(); ?>
						
							<?php endwhile; wp_reset_query();
					   } ?>
				</div>	
	<!-- .entry-content --></div>
			</footer>
<!-- #post-<?php the_ID(); ?> --></article>
