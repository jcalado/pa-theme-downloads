@if(is_admin())
	<img class="img-preview" src="{{ get_stylesheet_directory_uri() }}/Blocks/PAContact/preview.png"/>
@else
	<div class="pa-widget col mb-5 col-md-4">
		<div class="pa-w-contact rounded px-3 py-4">
			<div class="d-flex flex-column px-3 py-4">
				<i class="pa-w-contact__icon far fa-file-alt mb-4"></i>

				@notempty($title)
					<h4 class="pa-w-contact__title fw-bold">{!! $title !!}</h4>
				@endnotempty

				@notempty($description)
					<p class="mb-{{ empty($email) && empty($phone) ? '0' : '3' }}">{!! $description !!}</p>
				@endnotempty

				@notempty($email)
					<div class="mt-2">
						<a class="d-inline-flex align-items-center" href="mailto:{{ $email }}"><i class="far fa-envelope" aria-hidden="true"></i>{{ $email }}</a>	
					</div>
				@endnotempty

				@notempty($phone)
					<div class="mt-2">
						<a class="d-inline-flex align-items-center" href="tel:{{ $phone }}"><i class="fas fa-phone-alt" aria-hidden="true"></i>{{ $phone }}</a>
					</div>
				@endnotempty
			</div>
		</div>
	</div>
@endif