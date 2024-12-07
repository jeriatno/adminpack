<form action="{{ $action ?? '#' }}" method="POST"
      enctype="multipart/form-data"
      id="formComment">
    @csrf
    @if($showLabelComment)
        <label for="">Comment for : <span id="commentFor"></span></label>
    @endif
    <textarea class="form-control" style="border-radius: 0px"
              placeholder="Write your comment here"
              id="ckeditor"
              required="required"
              {{ $isDisabled ? 'disabled' : '' }}
              rows="5" name="comment"></textarea>
    <div class="file-upload">
        <div class="file-select">
            <div class="file-select-name" id="noFile">
                <i class="fa fa-paperclip"></i> Drag and drop / click here..
            </div>
            <input type="file" name="attachment" id="chooseFile" {{ $isDisabled ? 'disabled' : '' }}>
        </div>
    </div>
    <br>
    <button class="btn btn-success btn-sm" id="btnReplyComment"
            {{ $isDisabled ? 'disabled' : '' }}
            @if(isset($useOnclick))  type="button" onclick="entryComment(this)" @endif>
        <i class="fa fa-rocket-launch"></i> {{ $labelBtnReply ?? 'POST REPLY' }}
    </button>
    <button href="" class="btn btn-default btn-sm" {{ $isDisabled ? 'disabled' : '' }} id="btnResetComment">
        <i class="fa fa-ban"></i> {{ $labelBtnReset ?? 'Reset' }}
    </button>
</form>

@if($showLabelHistory)
    <br>
    <h4>
        <span class="text-capitalize">Activity</span>
        <hr style="margin-top: 10px;border-top:1px solid darkgrey">
    </h4>
@endif

@if(isset($showResponse))
    <div id="comments_container" class="mt-1"></div>
@endif

@push('after_styles')
    <style>
        .td-involve {
            color: #766e6b;
        }

        .file-upload {
            display: block;
            text-align: center;
            font-family: Helvetica, Arial, sans-serif;
            font-size: 12px;
        }

        .file-upload .file-select {
            display: block;
            border: 2px solid #dce4ec;
            color: #34495e;
            cursor: pointer;
            height: 30px;
            line-height: 1px;
            text-align: left;
            background: #FFFFFF;
            overflow: hidden;
            position: relative;
        }

        .file-upload .file-select .file-select-button {
            background: #dce4ec;
            padding: 0 10px;
            display: inline-block;
            height: 30px;
            line-height: 17px;
        }

        .file-upload .file-select .file-select-name {
            line-height: 25px;
            display: inline-block;
            padding: 0 10px;
        }

        .file-upload .file-select:hover {
            border-color: #34495e;
            transition: all .2s ease-in-out;
            -moz-transition: all .2s ease-in-out;
            -webkit-transition: all .2s ease-in-out;
            -o-transition: all .2s ease-in-out;
        }

        .file-upload .file-select:hover .file-select-button {
            background: #34495e;
            color: #FFFFFF;
            transition: all .2s ease-in-out;
            -moz-transition: all .2s ease-in-out;
            -webkit-transition: all .2s ease-in-out;
            -o-transition: all .2s ease-in-out;
        }

        .file-upload.active .file-select {
            border-color: #3fa46a;
            transition: all .2s ease-in-out;
            -moz-transition: all .2s ease-in-out;
            -webkit-transition: all .2s ease-in-out;
            -o-transition: all .2s ease-in-out;
        }

        .file-upload.active .file-select .file-select-button {
            background: #3fa46a;
            color: #FFFFFF;
            transition: all .2s ease-in-out;
            -moz-transition: all .2s ease-in-out;
            -webkit-transition: all .2s ease-in-out;
            -o-transition: all .2s ease-in-out;
        }

        .file-upload .file-select input[type=file] {
            z-index: 100;
            cursor: pointer;
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0;
            left: 0;
            opacity: 0;
            filter: alpha(opacity=0);
        }

        .file-upload .file-select.file-select-disabled {
            opacity: 0.65;
        }

        .file-upload .file-select.file-select-disabled:hover {
            cursor: default;
            display: block;
            border: 2px solid #dce4ec;
            color: #34495e;
            cursor: pointer;
            height: 40px;
            line-height: 40px;
            margin-top: 5px;
            text-align: left;
            background: #FFFFFF;
            overflow: hidden;
            position: relative;
        }

        .file-upload .file-select.file-select-disabled:hover .file-select-button {
            background: #dce4ec;
            color: #666666;
            padding: 0 10px;
            display: inline-block;
            height: 40px;
            line-height: 40px;
        }

        .file-upload .file-select.file-select-disabled:hover .file-select-name {
            line-height: 40px;
            display: inline-block;
            padding: 0 10px;
        }

        .is-admin {
            background: rgba(208, 238, 247, 0.5);
        }
    </style>
@endpush

@push('after_scripts')
    <script>
        $('#chooseFile').bind('change', function () {
            var filename = $("#chooseFile").val();
            if (/^\s*$/.test(filename)) {
                $(".file-upload").removeClass('active');
                $("#noFile").text("No file chosen...");
            } else {
                $(".file-upload").addClass('active');
                $("#noFile").text(filename.replace("C:\\fakepath\\", ""));
            }
        });
    </script>
@endpush
