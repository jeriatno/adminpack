{{--<a href="javascript:void(0)"--}}
{{--   @if(isset($withOnclick))--}}
{{--        onclick="bulkDownloadEntries(this)"--}}
{{--    @endif--}}
{{--   name="action"--}}
{{--   class="btn btn-default bulk-button" id="{{ $buttonId ?? '' }}">--}}
{{--    <span class="fa fa-file-export" role="presentation" aria-hidden="true"></span> &nbsp;--}}
{{--    <span>{{ $buttonText ?? 'Download' }}</span>--}}
{{--</a>--}}

<div class="btn-group">

    <button type="button"
            class="btn btn-default bulk-button"
            id="{{ $buttonId ?? '' }}"
            @if(isset($withOnclick))
                onclick="bulkDownloadEntries(this)"
            @endif
    >
        <span class="fa fa-file-export" role="presentation" aria-hidden="true"></span> &nbsp;
        <span data-value="save_and_back">{{ $buttonText ?? 'Download' }}</span>
    </button>

    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aira-expanded="false" aria-expanded="true">
        <span class="caret"></span>
        <span class="sr-only">▼</span>
    </button>

    <ul class="dropdown-menu">
        <li><a href="{{ $fileDownloaded ?? 'javascript:void(0);' }}" data-value="save_and_edit" id="file_downloaded" target="_blank">
                <span class="fa fa-file" role="presentation" aria-hidden="true"></span> &nbsp;Download File</a>
        </li>
    </ul>

</div>
