<button type="button"
        id="{{ $buttonId }}"
        @if(isset($withModal))
            data-toggle="modal" data-target="#{{ $modalId }}"
        @endif
        @if(isset($withOnclick))
            onclick="btnComplete({{ $entryKey }})"
        @endif
        @if(isset($isHide))
            style="display: none"
        @endif
        class="btn btn-sm btn-success rounded">
    <i class="fa fa-check-circle"></i> {{ $buttonText ?? 'Complete' }}
</button>
