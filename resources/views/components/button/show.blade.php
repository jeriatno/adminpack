<a href="{{ $buttonLink ?? '#' }}"
   id="{{ $buttonId ?? '' }}"
    @if(isset($withModal))
        data-toggle="modal" data-target="#{{ $modalId }}"
    @endif
   @if(isset($withOnclick))
       onclick="btnShow({{ $entryKey }})"
   @endif
   class="btn btn-xs btn-default {{ $buttonClass ?? '' }}">
    <i class="fa fa-eye"></i> {{ $buttonText ?? 'Show' }}
</a>
