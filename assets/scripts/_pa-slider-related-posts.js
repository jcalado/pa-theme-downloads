/* Scripsts Slider Videos */
// import Glide from '@glidejs/glide';

export function pa_slider_related_posts() {
	var nodes = document.querySelectorAll('.pa-glide-related-posts');

	if(!nodes.length)
		return;

	nodes.forEach(function(node) {
		var glide = new window.Glide(node, {
			type: 'carousel',
			perView: 3,
			startAt: 0,
			gap: 24,
			breakpoints: {
        1023: {
					perView: 2,
          gap: 8,
          peek: {
						before: 0,
						after: 50,
					},
				},
				767: {
					perView: 1,
          gap: 8,
          peek: {
						before: 0,
						after: 300,
					},
				},
				500: {
					perView: 1,
          gap: 8,
          peek: {
						before: 0,
						after: 200,
					},
				},
				430: {
					perView: 1,
					gap: 8,
					peek: {
						before: 0,
						after: 129,
					},
				},
			},
		});

		glide.mount();
	});
}
