<div id="pa-modal-report" class="modal fade p-0" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content position-relative">
      <div class="modal-header justify-content-lg-center border-0">
        <h5 class="modal-title text-primary fw-bold">Quero reportar um erro</h5>

        <button type="button" class="btn-close position-absolute bg-white p-0" data-bs-dismiss="modal" aria-label="Close">
          <i class="fas fa-times text-primary"></i>
        </button>
      </div>
      <div class="modal-body pt-0 pb-4">
        <form id="form-report" class="needs-validation" novalidate>
          <div class="input-group has-validation mb-3">
            <label for="report-title" class="form-label fw-bold">Título da mensagem</label>
            <input id="report-title" class="form-control rounded px-3 w-100" type="email" placeholder="Digite um título" required />

            <div class="invalid-feedback">
              Escreva um título para a mensagem.
            </div>
          </div>

          <div class="input-group has-validation mb-3">
            <label for="report-message" class="form-label fw-bold">Mensagem</label>
            <textarea id="report-message" class="form-control rounded px-3 w-100" rows="4" placeholder="Escreva o problema encontrado" required></textarea>

            <div class="invalid-feedback">
              Escreva o conteúdo da mensagem.
            </div>
          </div>

          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary rounded">Enviar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
