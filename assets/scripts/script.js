import * as ModalReport from './_pa-modal-report';
import * as SliderPosts from './_pa-slider-posts';
import * as SliderRelatedPosts from './_pa-slider-related-posts';

function onload() {
  ModalReport.pa_modal_report();
  SliderPosts.pa_slider_posts();
	SliderRelatedPosts.pa_slider_related_posts();
}

document.addEventListener('DOMContentLoaded', onload, false);
