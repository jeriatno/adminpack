<button type="button"
        id="{{ $buttonId }}"
        @if(isset($withModal))
            data-toggle="modal" data-target="#{{ $modalId }}"
        @endif
        @if(isset($withOnclick))
            onclick="btnReject({{ $entryKey }}, '{{ $entryParam }}')"
        @endif
        class="btn btn-sm btn-danger rounded {{ $buttonClass ?? '' }}">
    <i class="fa fa-thumbs-down"></i> {{ $buttonText ?? 'Reject' }}
</button>
