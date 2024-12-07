<a href="javascript:void(0)"
   @if(isset($withOnclick))
        onclick="bulkEntries(this)"
    @endif
   name="action"
   class="btn btn-success {{ $buttonClass ?? '' }}" id="{{ $buttonId ?? '' }}">
    <span class="fa fa-check-circle" role="presentation" aria-hidden="true"></span> &nbsp;
    <span>{{ $buttonText ?? 'Generate' }}</span>
</a>