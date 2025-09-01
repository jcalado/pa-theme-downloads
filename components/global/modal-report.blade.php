@hasfield('report_enabled', 'pa_settings')
  <div id="pa-modal-report" class="pa-modal-report modal fade p-0" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content position-relative">
        <button type="button" class="btn-close position-absolute bg-white p-0" data-bs-dismiss="modal" aria-label="Close">
          <i class="fas fa-times text-primary"></i>
        </button>

        <div class="modal-header justify-content-lg-center border-0">
          <h5 class="modal-title text-primary fw-bold"><?= __('I want to report an error', 'downloads')  ?></h5>
        </div>
        <div class="modal-body pt-0 pb-4">
          <form id="form-report" novalidate>
            <div class="input-group has-validation mb-3">
              <label for="report-title" class="form-label fw-bold"><?= __('Message title', 'downloads')  ?></label>
              <input id="report-title" name="report-title" class="form-control rounded px-3 w-100" type="text" placeholder="<?= __('Enter a title', 'downloads')  ?>" required />
              <div class="invalid-feedback">
                <?= __('Write a title for the message.', 'downloads')  ?>
              </div>
            </div>

            <div class="input-group has-validation mb-3">
              <label for="report-message" class="form-label fw-bold"><?= __('Message', 'downloads')  ?></label>
              <textarea id="report-message" name="report-message" class="form-control rounded px-3 w-100" rows="4" placeholder="<?= __('Write the problem you found', 'downloads')  ?>" required></textarea>

              <div class="invalid-feedback">
                <?= __('Write the message content.', 'downloads')  ?>
              </div>
            </div>

            <input id="report-permalink" name="report-permalink" type="hidden" />
            <input id="report-postid" name="report-postid" type="hidden" />

            <div class="d-flex justify-content-end">
              <button type="submit" class="form-report__button btn btn-primary rounded px-5">
                <span class="form-report__spinner spinner-grow spinner-grow-sm visually-hidden" role="status" aria-hidden="true"></span>
                <span class="form-report__sending visually-hidden"><?= __('Sending...', 'downloads')  ?> </span>
                <span class="form-report__text"><?= __('To send', 'downloads')  ?></span>
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
          <h5 class="modal-title text-primary fw-bold mb-4 pb-1 success"><?= __('Thanks for cooperating', 'downloads')  ?></h5>
          <h5 class="modal-title text-primary fw-bold mb-4 pb-1 error"><?= __('Error', 'downloads')  ?></h5>

          <p class="mb-4 pb-2 px-2 success"><?= __('Your message has been sent successfully!', 'downloads')  ?></p>
          <p class="mb-4 pb-2 px-2 error"><?= __('There was an error in sending', 'downloads')  ?></p>

          <button type="button" class="btn btn-primary rounded w-100" data-bs-dismiss="modal"><?= __('To close', 'downloads')  ?></button>
        </div>
      </div>
    </div>
  </div>
@endfield
