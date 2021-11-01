<?php 

get_header(); 

$args = array(  
	'post_type' => 'projetos',
	'post_status' => 'publish',
);

$loop = new WP_Query( $args ); 



?>
	<?php 
		require(get_template_directory() . '/components/parent/header.php'); 	
	?>
	<div class="pa-archive-projects py-5">
		<div class="container">
			<div class="pa-project-items row row-cols-auto">
			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
				<div class="pa-project-item col-12 col-md-6 mb-4">
					<a href="<?php the_permalink(); ?>">
						<figure class="figure m-xl-0">
							<?php echo get_the_post_thumbnail(get_the_ID(), 'full', array( 'class' => 'img-fluid rounded' )); ?>
							<figcaption class="figure-caption w-100 rounded-bottom ">
								<h3 class="h4 fw-bold pt-3"><?php the_title(); ?></h3>
							</figcaption>
						</figure>
					</a>
				</div>
			<?php endwhile; wp_reset_postdata();  ?>
			</div>
		</div>
	</div>

<?php get_footer();?>
