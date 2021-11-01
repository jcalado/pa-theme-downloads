<?php 
	get_header(); 

	if(have_posts())
		the_post();

	require(get_template_directory() . '/components/parent/header.php'); 	
	?>
	<div class="pa-single-projects">
		<article class="pa-single-project xcontainer">
			<div class="row">
				<div class="col">
					<?php the_content(); ?>
				</div>
			</div>
		</article>
		<aside class="pa-widgets mt-5">
			<div class="container">
				<div class="row row-cols-auto">
					<?php 
						if ( is_active_sidebar( 'projeto-'. $post->post_name ) ) {
							dynamic_sidebar( 'projeto-'. $post->post_name);
						 }
					?>
				</div>
			</div>
		</aside>
	</div>

<?php get_footer();?>
