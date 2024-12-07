<button type="button"
        id="{{ $buttonId }}"
        @if(isset($withModal))
            data-toggle="modal" data-target="#{{ $modalId }}"
        @endif
        @if(isset($withOnclick))
            onclick="{{$buttonId}}({{ $entryKey }})"
        @endif
        class="btn btn-sm btn-primary rounded">
    <span data-toggle="tooltip" title="{{ $buttonTooltip ?? '' }}">
        @if(isset($buttonIcon))
            <i class="{{ $buttonIcon }}"></i>
        @endif
        {{ $buttonText ?? 'Approve' }}
    </span>
</button>
