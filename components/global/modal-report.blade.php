@hasfield('report_enabled', 'option')
  <div id="pa-modal-report" class="pa-modal-report modal fade p-0" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content position-relative">
        <button type="button" class="btn-close position-absolute bg-white p-0" data-bs-dismiss="modal" aria-label="Close">
          <i class="fas fa-times text-primary"></i>
        </button>

        <div class="modal-header justify-content-lg-center border-0">
          <h5 class="modal-title text-primary fw-bold">Quero reportar um erro</h5>
        </div>
        <div class="modal-body pt-0 pb-4">
          <form id="form-report" novalidate>
            <div class="input-group has-validation mb-3">
              <label for="report-title" class="form-label fw-bold">Título da mensagem</label>
              <input id="report-title" name="report-title" class="form-control rounded px-3 w-100" type="text" placeholder="Digite um título" required />

              <div class="invalid-feedback">
                Escreva um título para a mensagem.
              </div>
            </div>

            <div class="input-group has-validation mb-3">
              <label for="report-message" class="form-label fw-bold">Mensagem</label>
              <textarea id="report-message" name="report-message" class="form-control rounded px-3 w-100" rows="4" placeholder="Escreva o problema encontrado" required></textarea>

              <div class="invalid-feedback">
                Escreva o conteúdo da mensagem.
              </div>
            </div>

            <input id="report-permalink" name="report-permalink" type="hidden" />

            <div class="d-flex justify-content-end">
              <button type="submit" class="form-report__button btn btn-primary rounded">
                <span class="form-report__spinner spinner-grow spinner-grow-sm visually-hidden" role="status" aria-hidden="true"></span>
                <span class="form-report__sending visually-hidden">Enviando...</span>
                <span class="form-report__text">Enviar</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div id="pa-modal-report-callback" class="pa-modal-report modal fade p-0" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content position-relative px-4">
        <button type="button" class="btn-close position-absolute bg-white p-0" data-bs-dismiss="modal" aria-label="Close">
          <i class="fas fa-times text-primary"></i>
        </button>

        <div class="modal-body d-flex flex-column align-items-center justify-content-center text-center px-5">
          <h5 class="modal-title text-primary fw-bold mb-4 pb-1 success">Obrigado por colaborar</h5>
          <h5 class="modal-title text-primary fw-bold mb-4 pb-1 error">Erro</h5>

          <p class="mb-4 pb-2 px-2 success">Sua mensagem foi enviada com sucesso!</p>
          <p class="mb-4 pb-2 px-2 error">Houve um erro no envio</p>

          <button type="button" class="btn btn-primary rounded w-100" data-bs-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>
@endfield
