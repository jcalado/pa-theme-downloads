export function pa_modal_report() {
  const modal = document.getElementById('pa-modal-report');
	const form = document.getElementById('form-report');
  const report_permalink = document.getElementById('report-permalink');

  if(modal) {
    modal.addEventListener('show.bs.modal', (event) => {
      if(form) {
        form.reset();
        form.classList.remove('was-validated');  
      }
        
      if(report_permalink)
        report_permalink.value = event.relatedTarget.getAttribute('data-bs-permalink');
    })
  }

  if(form) {
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      event.stopPropagation();
  
      form.classList.add('was-validated');
    }, false);
  }
  
}
