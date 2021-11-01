<?php 
$posts = get_posts(array(
	'numberposts'	=> -1,
	'post_type'		=> 'sliders',
	'post_status'	=> 'publish'
));

if(!empty($posts)):
?>
<div class="pa-slider-principal">
	<div class="pa-glide-principal">
		<div class="glide__track" data-glide-el="track">
			<div class="glide__slides">
			<?php 
				foreach($posts as $post):
				
					if (get_field('slider_button_color')){
						$button_color = get_field('slider_button_color');
					} else {
						$button_color = '#afffff';
					}
			?>
				<div class="pa_slide_item glide__slide" data-img-cell="<?php the_field('slider_img_mobile'); ?>" style="background-image: url('<?php the_field('slider_img_desktop'); ?>');">
					<div class="container">
						<div class="row align-items-end align-items-xl-center">
							<div class="col col-xl-6 d-flex flex-column align-items-center align-items-xl-start justify-content-center mb-5 pb-5 mb-xl-0 pb-xl-0">
								<small class="h6"><?php the_field('slider_text_01'); ?></small>
								<h1 class="display-3 text-center text-md-start my-2"><?php the_field('slider_text_02'); ?></h1>
								<p class="pt-2 mb-3 pb-3 d-none d-xl-block"><?php the_field('slider_text_03'); ?></p>
								<a href="<?php the_field('slider_button_url'); ?>" class="btn btn-primary mt-2 align-self-xl-start" style="background-color: <?php the_field('slider_button_color'); ?>; color: <?php the_field('slider_button_text_color'); ?> !important;"><?php the_field('slider_button_text'); ?></a>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>	
			</div>
		</div>
		<div class=" pa-slider-controle d-flex justify-content-center justify-content-xl-end align-items-center mb-5">
			<div class=" mx-2 pa-slider-bullet" data-glide-el="controls[nav]">
				<?php 
					$i = 0;
					foreach($posts as $post) { 
				?>
					<i class="fas fa-circle fa-lg mx-2" data-glide-dir="=<?= $i; ?>"></i>
				<?php 
					$i++;
				} 
				?>
			</div>
		</div>
	</div>
</div>

<?php endif; ?>