export function pa_modal_report() {
  const modal = document.getElementById('pa-modal-report');
  const modal_callback = document.getElementById('pa-modal-report-callback');
	const form = document.getElementById('form-report');
  const report_permalink = document.getElementById('report-permalink');
  let request = null;
  let data = null;

  if(!form || !modal || !modal_callback)
    return;

  const pa_manage_form = (sending) => {
    const button = form.querySelector('.form-report__button');
  
    if(!button)
      return;
  
    button.toggleAttribute('disabled', sending);
    button.querySelector('.form-report__spinner')?.classList.toggle('visually-hidden', !sending);
    button.querySelector('.form-report__sending')?.classList.toggle('visually-hidden', !sending);
    button.querySelector('.form-report__text')?.classList.toggle('visually-hidden', sending);
  };

  const pa_report_token = () => {
    return window.grecaptcha.execute(window.recaptcha.site_key ? window.recaptcha.site_key : '', {action: 'submit'});
  };

  const pa_send_report = (data) => {
    const request = new XMLHttpRequest();
    data.action = 'send_report';
  
    request.responseType = 'json';
    request.open('POST', window.pa.url, true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    request.send(Object.keys(data).map(key => key + '=' + data[key]).join('&'));
  
    return request;
  };

  const send = () => {
    request = pa_send_report(data);
    request.onloadend = (request) => { 
      if(request.target.readyState !== 4 || request.target.status !== 200)
        return;

      this.request = null;
      pa_manage_form(false);

      modal_callback.classList.toggle('error', request.target.status !== 200 || !request.target.response.success);
      modal_callback.classList.toggle('success', request.target.status === 200 && request.target.response.success);
  
      window.bootstrap.Modal.getOrCreateInstance(modal).hide();
      window.bootstrap.Modal.getOrCreateInstance(modal_callback).show();
    };
  };
  
  modal.addEventListener('show.bs.modal', (event) => {
    request?.abort();
    form.reset();
    form.classList.remove('was-validated');  
    pa_manage_form(false);
      
    if(report_permalink)
      report_permalink.value = event.relatedTarget.getAttribute('data-bs-permalink');
  });

  form.addEventListener('submit', (event) => {
    event.preventDefault();
    event.stopPropagation();

    form.classList.add('was-validated');

    if(!form.checkValidity())
      return;

    pa_manage_form(form, true);
    
    data = Object.fromEntries(new FormData(form));

    if(window.grecaptcha) {
      pa_report_token().then((token) => {
        data.token = token;
  
        send();
      });
    }
    else
      send();
  }, false);
}
