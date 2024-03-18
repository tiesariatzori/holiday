<div class="modal" id="vacation-modal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark bg-gradient">
                <h5 class="modal-title text-white">Vacation Plan</h5>
                <button type="button" class="btn-close text-white close-modal" data-bs-dismiss="#vacation-modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('panel.vacation.form', ['ajax' => true])
            </div>
        </div>
    </div>
</div>

<div class="modal" id="vacation-show" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark bg-gradient">
                <h5 class="modal-title text-white">Show Vacation Plan</h5>
                <button type="button" class="btn-close text-white close-modal" data-bs-dismiss="#vacation-show"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('panel.vacation.form', ['ajax' => true])
            </div>
        </div>
    </div>
</div>
