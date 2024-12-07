<div class="modal fade" id="{{ $modalId ?? '' }}">
    <div class="modal-dialog">
        <div class="modal-content {{ $modalClass ?? '' }}">
            @if($modalHeader)
                <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">{{ $modalTitle ?? '' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="modal-body">
                {{ $slot }}
            </div>
            @if($modalFooter)
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="{{ $modalBtnId ?? '' }}" onclick="">{{ $modalBtnLabel }}</button>
                </div>
            @endif
        </div>
    </div>
</div>
