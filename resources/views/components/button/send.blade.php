<button type="button"
        id="{{ $buttonId }}"
        @if(isset($withModal))
            data-toggle="modal" data-target="#{{ $modalId }}"
        @endif
        @if(isset($withOnclick))
            onclick="btnSend({{ $entryKey }}, '{{ $entryParam }}')"
        @endif
        class="btn btn-sm btn-primary rounded">
    <i class="fa fa-rocket-launch"></i>
    <span data-toggle="tooltip" title="{{ $buttonTooltip ?? '' }}">
        {{ $buttonText ?? 'Send' }}
    </span>
</button>
