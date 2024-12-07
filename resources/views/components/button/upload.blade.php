<button type="button"
        id="{{ $buttonId }}"
        @if(isset($withModal))
            data-toggle="modal" data-target="#{{ $modalId }}"
        @endif
        @if(isset($withOnclick))
            onclick="btnUpload({{ $entryKey }}, '{{ $entryParam }}')"
        @endif
        class="btn btn-sm btn-dark rounded">
    <i class="fa fa-file-upload"></i> {{ $buttonText ?? 'Upload' }}
</button>
