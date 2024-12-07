<a href="{{ $buttonLink ?? 'javascript:void(0)' }}"
   id="{{ $buttonId ?? '' }}"
    @if(isset($isHide))
        style="display: none"
    @endif
    @if(isset($withModal))
        data-toggle="modal" data-target="#{{ $modalId }}"
    @endif
   class="btn btn-sm btn-default {{ $buttonClass ?? '' }}">
    <i class="fa {{ $buttonIcon ?? 'fa-user-check' }}"></i> {{ $buttonText ?? 'Assign' }}
</a>
