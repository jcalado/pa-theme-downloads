<?php 

	get_header();

	if(have_posts())
		the_post();

	if (get_field('lider_redes_sociais'))
		$lider_social = get_field('lider_redes_sociais');

	require(get_template_directory() . '/components/parent/header.php');


	function getTplPageURL($page_template){
		$url = null;
		$pages = get_pages(array(
			'meta_key' => '_wp_page_template',
			'meta_value' => $page_template
		));
	
		// pconsole($pages);
		if(isset($pages[0])) {
			$url = get_page_link($pages[0]->ID);
		}
		return $url;
	}

?>
<section class="pa-content pa-lideres my-5">
	<div class="container">
		<div class="pa-lider-geral row row-cols-auto mb-5">
			<div class="col-12 col-xl-4 text-center mb-4">
				<?php echo get_the_post_thumbnail( get_the_ID(), array(215,215), array( 'class' => 'pa-lider-thumb rounded-circle mx-auto' ) ); ?>
				<?php if(isset($lider_social)):?>
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
				<?php endif; ?>
			</div>
			<div class="col col-xl-8">
				<h1 class="h2 fw-bold"><?php the_title(); ?></h1>
				<h5 class="mb-4"><?php the_field('lider_cargo'); ?></h5>
				<div class="pa-lider-bio">
					<?php the_field('lider_bibliografia'); ?>
				</div>
				<?php 
					if (have_rows('lider_equipe')):
						echo "<hr class='my-5'>";
						while(have_rows('lider_equipe')): the_row();
							$img = get_sub_field('lider_equipe_foto');
				?>
				<div class="pa-lider-equipe mb-5 clearfix">
					<img src="<?php echo esc_url($img['sizes']['thumbnail']); ?>" alt="<?php the_sub_field('lider_equipe_nome'); ?>" class="pa-lider-thumb rounded-circle float-start me-3 d-none d-xl-block" width="120" height="120">
					<ul class="ml-3 list-unstyled">
						<li><h4 class="mb-0"><?php the_sub_field('lider_equipe_nome'); ?></h4></li>
						<li class="mb-2"><em><?php the_sub_field('lider_equipe_cargo'); ?></em></li>
						<?php if (get_sub_field('lider_equipe_email')): ?><li><a href="mailto:<?php the_sub_field('lider_equipe_email'); ?>"><i class="fas fa-envelope me-3"></i><?php the_sub_field('lider_equipe_email'); ?></a></li><?php endif; ?>
						<?php if (get_sub_field('lider_equipe_telefone')): ?><li><a href="tel:<?php the_sub_field('lider_equipe_telefone'); ?>"><i class="fas fa-phone me-3"></i><?php the_sub_field('lider_equipe_telefone'); ?></a></li><?php endif; ?>
					</ul>
				</div>
					<?php endwhile; endif; ?>

				<div class="pa-linkback text-center text-md-start mt-2">
					
					<a href="<?= getTplPageURL('page-lideres.php') ?>" class="fw-bold text-decoration-none"><i class="fas fa-arrow-left ml-2"></i> Voltar para página de líderes</a>

				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer();?>