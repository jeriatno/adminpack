<button type="button"
        id="{{ $buttonId }}"
        @if(isset($withModal))
            data-toggle="modal" data-target="#{{ $modalId }}"
        @endif
        @if(isset($withOnclick))
            onclick="btnPrint({{ $entryKey }})"
        @endif
        @if(isset($isHide))
            style="display: none"
        @endif
        class="btn btn-sm btn-dark rounded">
    <i class="fa fa-print"></i> {{ $buttonText ?? 'Print' }}
</button>
