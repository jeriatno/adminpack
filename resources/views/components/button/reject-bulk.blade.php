<a href="javascript:void(0)"
   @if(isset($withOnclick))
        onclick="bulkRejectEntries(this)"
    @endif
   name="action"
   class="btn btn-danger bulk-button" id="{{ $buttonId ?? '' }}">
    <span class="fa fa-thumbs-down" role="presentation" aria-hidden="true"></span> &nbsp;
    <span>{{ $buttonText ?? 'Generate' }}</span>
</a>
