<?php

function pa_lideres_destaque($lideres_id){

	// pconsole($lideres_id);
	// pconsole(empty($lideres_id));

	// var_dump($lideres_id);
	// die;

	if(!empty($lideres_id)){
		lider($lideres_id);
	} else {
		lideres($lideres_id);
	}
	

}


function lider($id){     
	$lider_social = get_field('lider_redes_sociais', $id);
	?>

	<div class="pa-lider-geral row row-cols-auto mb-5">
		<div class="col-12 col-xl-4 text-center mb-4">
			<?php echo get_the_post_thumbnail( $id, 'lider-thumb', array( 'class' => 'pa-lider-thumb rounded-circle mx-auto' ) ); ?>
			<div class="mt-4">
				<ul class="pa-lider-contact list-inline">
				<?php if ($lider_social['lider_facebook']):?>
					<li class="list-inline-item mx-2"><a href="<?= $lider_social['lider_facebook']; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
				<?php endif;
					if ($lider_social['lider_twitter']):
				?>
					<li class="list-inline-item mx-2"><a href="<?= $lider_social['lider_twitter']; ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
				<?php endif;
					if ($lider_social['lider_instagram']):
				?>
					<li class="list-inline-item mx-2"><a href="<?= $lider_social['lider_instagram']; ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
				<?php endif;
					if ($lider_social['lider_email']):
				?>
					<li class="list-inline-item mx-2"><a href="mailto:<?= $lider_social['lider_email']; ?>" target="_blank"><i class="fas fa-envelope"></i></a></li>
				<?php endif; ?>
				</ul>
			</div>
		</div>
		<div class="col col-xl-8">
			<h1 class="h2 fw-bold"><?php echo esc_html(get_the_title($id)); ?></h1>
			<h5 class="mb-4"><?php the_field('lider_cargo', $id); ?></h5>
			<div class="pa-lider-bio">
				<?php the_field('lider_bibliografia', $id); ?>
			</div>
			<?php 
				if (have_rows('lider_equipe', $id)):
					echo "<hr class='my-5'>";
					while(have_rows('lider_equipe', $id)): the_row();
						$img = get_sub_field('lider_equipe_foto', $id);
			?>
						<div class="pa-lider-equipe mb-5 clearfix">
							<img src="<?php echo esc_url($img['sizes']['thumbnail']); ?>" alt="<?php the_sub_field('lider_equipe_nome', $id); ?>" class="pa-lider-thumb rounded-circle float-start me-3 d-none d-xl-block" width="120" height="120">
							<ul class="ml-3 list-unstyled">
								<li><h4 class="mb-0"><?php the_sub_field('lider_equipe_nome', $id); ?></h4></li>
								<li class="mb-2"><em><?php the_sub_field('lider_equipe_cargo', $id); ?></em></li>
								<?php if(get_sub_field('lider_equipe_email', $id)):?><li><a href="mailto:<?php the_sub_field('lider_equipe_email', $id); ?>"><i class="fas fa-envelope me-3"></i><?php the_sub_field('lider_equipe_email', $id); ?></a></li><?php endif; ?>
								<?php if(get_sub_field('lider_equipe_telefone', $id)):?><li><a href="tel:<?php the_sub_field('lider_equipe_telefone', $id); ?>"><i class="fas fa-phone me-3"></i><?php the_sub_field('lider_equipe_telefone', $id); ?></a></li><?php endif; ?>
							</ul>
						</div>

				<?php endwhile; endif; ?>
		</div>
		<hr class="mb-5 w-100">
	</div>
<?php
}


function lideres($lideres_id){
	foreach ($lideres_id as $id): ?>
		<div class="pa-lider-destaque col col-xl-3 my-5 text-center">
			<a href="<?= get_permalink($id); ?>">
			<?= get_the_post_thumbnail($id, array(200, 200), array( 'class' => 'pa-lider-thumb rounded-circle' ) ); ?>
				<p class="mt-4 mb-0 fw-bold"><?= get_the_title($id); ?></p>
				<p class="mb-0 font-italic"><?= get_field('lider_cargo', $id); ?></p>
				<p class="pa-link-perfil mb-0 fw-bold invisible">Ver perfil</p>
			</a>
		</div>
	<?php endforeach; ?>
		<div class="col-12">
			<hr class="mb-5">
		</div>
	<?php
}