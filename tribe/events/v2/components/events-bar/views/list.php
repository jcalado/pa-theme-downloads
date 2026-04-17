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
		<li class="tribe-events-c-view-selector__list-item dropdown tribe-events">
			<a title="PDF" href="#" data-bs-toggle="dropdown" class="tribe-events-c-view-selector__list-item-link dropdown-toggle" role="button" aria-expanded="false">
				<span class="tribe-events-c-view-selector__list-item-icon">
					<svg class="tribe-common-c-svgicon tribe-events-c-view-selector__list-item-icon-svg" aria-hidden="true" viewBox="0 0 19 19" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M3 1.5h8.5L16 6v11a.5.5 0 0 1-.5.5h-12A.5.5 0 0 1 3 17V1.5zm8 1v4h4" class="tribe-common-c-svgicon__svg-stroke" fill="none" stroke="currentColor"></path>
					</svg>
				</span>
				<span class="tribe-events-c-view-selector__list-item-text">PDF</span>
			</a>
			<ul role="menu" class="dropdown-menu p-4">
				<li class="nav-item menu-item"><a class="tribe-events-c-view-selector__list-item-link" href="https://s3.eu-central-003.backblazeb2.com/upasd-recursos/comunicacao/calendarios/2026/Datas%20e%20Plano%20Ac%CC%A7a%CC%83o%20UPASD%20%202026.pdf">Atividades</a></li>
				<li class="nav-item menu-item"><a class="tribe-events-c-view-selector__list-item-link" href="https://s3.eu-central-003.backblazeb2.com/upasd-recursos/comunicacao/calendarios/2026/Datas%20Sugestivas%20UPASD%202026.pdf">Datas Sugestivas</a></li>
				<li class="nav-item menu-item"><a class="tribe-events-c-view-selector__list-item-link" href="https://s3.eu-central-003.backblazeb2.com/upasd-recursos/comunicacao/calendarios/2026/RTP.pdf">RTP 2 / RTP Antena 1</a></li>
				<li class="nav-item menu-item"><a class="tribe-events-c-view-selector__list-item-link" href="https://s3.eu-central-003.backblazeb2.com/upasd-recursos/ministerial/calendarios/2026/Ora%C3%A7%C3%A3o.pdf">Oração</a></li>
			</ul>
		</li>
	</ul>
</div>