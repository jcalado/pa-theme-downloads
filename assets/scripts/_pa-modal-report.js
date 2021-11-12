export function pa_modal_report() {
  const modal = document.getElementById('pa-modal-report');
  const modal_callback = document.getElementById('pa-modal-report-callback');
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

      if(!form.checkValidity())
        return;

      window.grecaptcha.ready(() => {
        window.grecaptcha
          .execute('6LfdTS0dAAAAAMZRMBNJqSAvv7hnC7KGWmRffpY3', {action: 'submit'})
          .then((token) => {
            let data = Object.fromEntries(new FormData(form));
            data.token = token;

            pa_send_report(data, modal, modal_callback);
          });
      });
    }, false);
  }
}

function pa_send_report(data, modal, modal_callback) {
  const request = new XMLHttpRequest();
  data.action = 'send_report';

  request.responseType = 'json';
  request.open('POST', window.pa.url, true);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

  request.onreadystatechange = () => { 
    if(request.readyState !== 4)
      return;
    
    modal_callback.classList.toggle('error', request.status !== 200 || !request.response.success);
    modal_callback.classList.toggle('success', request.status === 200 && request.response.success);

    window.bootstrap.Modal.getOrCreateInstance(modal).hide();
    window.bootstrap.Modal.getOrCreateInstance(modal_callback).show();
  };

  request.send(Object.keys(data).map(key => key + '=' + data[key]).join('&'));
}
