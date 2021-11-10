/* Scripsts Slider Videos */
// import Glide from '@glidejs/glide';

export function pa_slider_posts() {
	var nodes = document.querySelectorAll('.pa-glide-posts');

	if(!nodes.length)
		return;

	nodes.forEach(function(node) {
		var glide = new window.Glide(node, {
			type: 'carousel',
			perView: 5,
			startAt: 0,
			gap: 8,
			breakpoints: {
        1199: {
					perView: 4,
				},
        1023: {
					perView: 2,
          peek: {
						before: 0,
						after: 160,
					},
				},
				767: {
					perView: 1,
          peek: {
						before: 0,
						after: 200,
					},
				},
				430: {
					perView: 1,
					peek: {
						before: 0,
						after: 105,
					},
				},
			},
		});

		glide.mount();
	});
}
