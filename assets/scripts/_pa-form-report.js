export function pa_form_report() {
	const form = document.getElementById('form-report');

  if(!form)
		return;

  form.addEventListener('submit', function(event) {
    if(!form.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
    }

    form.classList.add('was-validated');
  }, false);
}
