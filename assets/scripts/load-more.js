import './card-author';
import './card-post';

class LoadMore extends window.Slim {

  constructor() {
    super();

    this.url = this.attributes.getNamedItem('url')?.nodeValue;

    if(!this.isUrl(this.url))
      return;
    
    this.items = [];
    this.totalPages = 0;
    this.args = (this.args = this.attributes.getNamedItem('args')?.nodeValue).startsWith('?') ? this.args : `?${this.args}`;
    this.method = this.method = this.attributes.getNamedItem('method')?.nodeValue ? this.method.toUpperCase() : 'GET';
    this.nonce = this.attributes.getNamedItem('nonce')?.nodeValue;
    this.url = new URL(`${this.url}${this.args}`);

    if(this.args)
      this.loadMoreData();
  }

  onBeforeCreated() {
    this.template = this.attributes.getNamedItem('template').nodeValue;
    this.template = document.getElementById(this.template);

    this.constructor.template = '<div class="position-relative">';

    if(this.template)
      this.constructor.template += this.template.innerHTML;

    this.constructor.template += '<div class="load-more-trigger position-absolute bottom-0 w-100" style="height: 320px; z-index: -1;"></div></div>';
  }

  registerObserver() {
    this.trigger = this.querySelector('.load-more-trigger');

    this.observer = new IntersectionObserver(
      (entries) => {
        if(entries[0].isIntersecting === true)
          this.loadMoreData();
      }, 
      { threshold: [0] }
    );
    
    this.observer.observe(this.trigger);
  }

  loadMoreData() {
    const request = new XMLHttpRequest();
  
    this.url.searchParams.set('page', this.url.searchParams.has('page') ? parseInt(this.url.searchParams.get('page')) + 1 : 1);

    request.responseType = 'json';
    request.open(this.method, this.method == 'GET' ? this.url.href : `${this.url.origin}${this.url.pathname}`, true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

    if(this.nonce)
      request.setRequestHeader('X-WP-Nonce', this.nonce);

    request.onreadystatechange = () => { 
      if(request.readyState !== 4 || 
        request.status !== 200 ||
        !Array.isArray(request.response))
        return;

      request.response.forEach(item => this.items = [...this.items, item]);

      if(this.totalPages == 0)
        this.totalPages = parseInt(request.getResponseHeader('X-WP-TotalPages'));
      if(!this.observer)
        this.registerObserver();
      if(this.totalPages == parseInt(this.url.searchParams.get('page')))
        this.observer.unobserve(this.trigger);
    };
  
    request.send(this.method != 'GET' ? this.url.search.substring(1) : '');
  }

  isUrl() {
    try { return Boolean(new URL(this.url)); }
    catch(e){ return false; }
  }

}
LoadMore.useShadow = false;

customElements.define('load-more', LoadMore);
