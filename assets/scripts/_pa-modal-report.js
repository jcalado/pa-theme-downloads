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

      if(!form.checkValidity())
        return;

      window.grecaptcha.ready(() => {
        window.grecaptcha
          .execute('6LfdTS0dAAAAAMZRMBNJqSAvv7hnC7KGWmRffpY3', {action: 'submit'})
          .then((token) => {
            var data = Object.fromEntries(new FormData(form));
            data.token = token;
            pa_send_report(data);
            // Add your logic to submit to your backend server here.
        });
      });
    }, false);
  }
}

function pa_send_report(data) {
  const request = new XMLHttpRequest();
  data.action = 'send_report';

  request.responseType = 'json';
  request.open('POST', window.pa.url, true);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

  request.onreadystatechange = () => { 
    console.log(request.response);
    // if(request.readyState !== 4 || 
    //   request.status !== 200 ||
    //   !request.response.success)
    //   return;

    // if(request.response.score >= 0.5)
    //   console.log(request.response);
  };

  request.send(Object.keys(data).map(key => key + '=' + data[key]).join('&'));
}
