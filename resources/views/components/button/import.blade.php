<button type="button"
        id="{{ $buttonId ?? '' }}"
        @if(isset($withModal))
            data-toggle="modal" data-target="#{{ $modalId }}"
        @endif
        class="btn btn-default {{ $buttonClass ?? '' }}">
    <i class="fa fa-file-import"></i> {{ $buttonText ?? 'Import' }}
</button>