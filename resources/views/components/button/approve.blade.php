<button type="button"
        id="{{ $buttonId }}"
        @if(isset($withModal))
            data-toggle="modal" data-target="#{{ $modalId }}"
        @endif
        @if(isset($withOnclick))
            onclick="btnApprove({{ $entryKey }}, '{{ $entryParam ?? '' }}')"
        @endif
        class="btn btn-sm btn-primary rounded">
    <i class="fa fa-thumbs-up"></i>
    <span data-toggle="tooltip" title="{{ $buttonTooltip ?? '' }}">
        {{ $buttonText ?? 'Approve' }}
    </span>
</button>
