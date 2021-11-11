import * as FormReport from './_pa-form-report';
import * as SliderPosts from './_pa-slider-posts';
import * as SliderRelatedPosts from './_pa-slider-related-posts';

function onload() {
  FormReport.pa_form_report();
  SliderPosts.pa_slider_posts();
	SliderRelatedPosts.pa_slider_related_posts();
}

document.addEventListener('DOMContentLoaded', onload, false);
