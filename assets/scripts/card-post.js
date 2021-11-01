class CardPost extends window.Slim {

  constructor() {
    super();

    if(!this.post)
        return;

    this.parseExcerpt();
  }

  parseExcerpt() {
    if(!this.post.hasOwnProperty('excerpt'))
        return;

    this.post.excerpt.rendered = this.post.excerpt.rendered.replace(/(<([^>]+)>)/gi, '');
    this.post.excerpt.rendered = this.post.excerpt.rendered.replace('[&hellip;]', '');
  }

}
  
CardPost.useShadow = false;
CardPost.template = /*html*/ `
    <div class="pa-blog-item mb-3 border-0">
        <a href="{{ this.post.link }}" title="{{ this.post.title.rendered }}">
            <div class="row">
                <div class="{{ this.post.featured_media_url['pa-block-render'] ? 'col-5 col-md-4' : 'd-none' }}">
                    <div class="ratio ratio-16x9">
                        <figure class="figure m-xl-0">
                            <img *if="{{ this.post.featured_media_url['pa-block-render'] }}" src="{{ this.post.featured_media_url['pa-block-render'] }}" class="figure-img img-fluid rounded m-0 h-100 w-100" alt="{{ this.post.title.rendered }}" />

                            <figcaption *if="{{ this.post.terms.editorial }}" class="pa-img-tag figure-caption text-uppercase rounded-right d-none d-md-table-cell">{{ this.post.terms.editorial }}</figcaption>
                        </figure>	
                    </div>
                </div>

                <div class="col">
                    <div class="{{ this.post.featured_media_url['pa-block-render'] ? 'card-body p-0' : 'card-body ps-4 pe-0 py-4 border-start border-5 pa-border' }}">
                        <span *if="{{ this.post.terms.format }}" class="pa-tag text-uppercase d-none d-xl-table-cell rounded">{{ this.post.terms.format }}</span>

                        <h3 class="fw-bold h6 mt-xl-2 pa-truncate-4">{{ this.post.title.rendered }}</h3>

                        <p *if="{{ this.post.excerpt.rendered }}" class="d-none d-xl-block m-0 pa-truncate-3">{{ this.post.excerpt.rendered }}</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
`;
  
customElements.define('card-post', CardPost);
