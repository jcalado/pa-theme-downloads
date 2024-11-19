<?php
/**
 * View: Events Bar Views List
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/components/events-bar/views/list.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 5.0.0
 *
 * @var array $public_views Array of data of the public views, with the slug as the key.
 */
?>
<div
	class="tribe-events-c-view-selector__content"
	id="tribe-events-view-selector-content"
	data-js="tribe-events-view-selector-list-container"
>
	<ul class="tribe-events-c-view-selector__list">
		<?php foreach ( $public_views as $public_view_slug => $public_view_data ) : ?>
			<?php $this->template(
				'components/events-bar/views/list/item',
				[ 'public_view_slug' => $public_view_slug, 'public_view_data' => $public_view_data ]
			); ?>
		<?php endforeach; ?>
		<li class="dropdown tribe-events">
			<a title="PDF" href="#" data-bs-toggle="dropdown" class="tribe-events-c-view-selector__list-item nav-link dropdown-toggle" role="button" aria-expanded="false">PDF</a>
			<ul role="menu" class="dropdown-menu p-4">
				<li class="nav-item menu-item"><a class="tribe-events-c-view-selector__list-item-link" href="https://s3.eu-central-003.backblazeb2.com/upasd-recursos/comunicacao/calendarios/2023/atividades_upasd_2024.pdf">Atividades 2024</a></li>
				<li class="nav-item menu-item"><a class="tribe-events-c-view-selector__list-item-link" href="https://upasd-recursos.s3.eu-central-003.backblazeb2.com/comunicacao/calendarios/2025/Atividades_2025.pdf">Atividades 2025</a></li>
				<li class="nav-item menu-item"><a class="tribe-events-c-view-selector__list-item-link" href="https://upasd-recursos.s3.eu-central-003.backblazeb2.com/comunicacao/calendarios/2025/Sugestoes_2025.pdf">Datas Sugestivas 2025</a></li>
				<li class="nav-item menu-item"><a class="tribe-events-c-view-selector__list-item-link" href="https://upasd-recursos.s3.eu-central-003.backblazeb2.com/comunicacao/calendarios/2024/Programas%20RTP%202%20e%20Antena%201%20%202024.pdf">Emissões RTP2 / Antena 1</a></li>
				<li class="nav-item menu-item"><a class="tribe-events-c-view-selector__list-item-link" href="https://s3.eu-central-003.backblazeb2.com/upasd-recursos/tesouraria/calendario-de-ofertas/2024/calendario_de_ofertas_2024.pdf">Ofertas</a></li>
				<li class="nav-item menu-item"><a class="tribe-events-c-view-selector__list-item-link" href="https://s3.eu-central-003.backblazeb2.com/upasd-recursos/comunicacao/calendarios/2024/calendario_oracao_2024.pdf">Oração</a></li>
			</ul>
		</li>
	</ul>
</div>