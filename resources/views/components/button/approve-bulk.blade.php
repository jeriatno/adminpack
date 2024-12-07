<a href="javascript:void(0)"
   @if(isset($withOnclick))
        onclick="bulkApproveEntries(this)"
    @endif
   name="action"
   class="btn btn-success bulk-button" id="{{ $buttonId ?? '' }}">
    <span class="fa fa-thumbs-up" role="presentation" aria-hidden="true"></span> &nbsp;
    <span>{{ $buttonText ?? 'Generate' }}</span>
</a>
