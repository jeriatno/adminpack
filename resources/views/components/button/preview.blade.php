@if (isset($attachment))
    <br>
    <a href="{{ assets($attachment) }}" class="btn btn-default" target="_blank">
        <i class="fa fa-eye"></i> &nbsp;<span style="font-size: .9em">Preview Attachment</span>
    </a>
@else
    <input type="file" value="" class="form-control" disabled>
    <small class="text-muted">No file available for download.</small>
@endif
