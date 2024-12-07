<ul class="list-group">
    @if(isset($comments) && count($comments) > 0)
        @foreach($comments as $comment)
            <li class="list-group-item" style="background: none !important; border: none !important;">
                <div class="row box-header with-border bg-white" id="topicComment-{{ $comment['id'] }}">
                    <div class="col-md-11">
                        <div class="border rounded mb-2" style="border-bottom:1px solid #eee; padding-bottom:10px">
                            <strong class="font-weight-bold" style="font-size:1em">
                                Partnumber Description : {{ $comment['partnumber_desc'] }}
                            </strong>
                        </div>
                        <div class="bg-white rounded px-2 shadow">
                            <span class="input-group-text bg-white px-4 border-md border-right-0 mr-2">
                                <i class="fa fa-user text-muted mr-1"></i>
                                <strong>{{ $comment['created_by']['name'] }} ({{ $comment['created_by']['email'] }})</strong>
                                <span class="small text-muted"><i class="fa fa-clock-o mr-1"></i>{{ \Carbon\Carbon::parse($comment['comment_at'])->format('d M Y H:i') }}</span>
                            </span>
                            <div class="text-muted mt-2">
                                {{ ucfirst($comment['comment']) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-link p-0" type="button" data-toggle="collapse" data-target="#replyComment-{{ $comment['id'] }}" aria-expanded="false" aria-controls="replyComment-{{ $comment['id'] }}">
                            <i class="fa fa-chevron-down"></i>
                        </button>
                    </div>
                </div>
                <div class="row collapse in ml-2 box-content" id="replyComment-{{ $comment['id'] }}" style="background-color: #f9f9f9 !important;">
                    <!-- comments -->
                    <ul class="timeline" style="margin: 10px 0">
                        @if(isset($comment['replies']))
                            @foreach($comment['replies'] as $reply)
                                <li class="timeline-item bg-white rounded ml-3 px-2 pt-1 shadow">
                                    <div class="timeline-arrow"></div>
                                    <span class="h5 mb-0">
                                        <i class="fa fa-user text-muted mr-1"></i>
                                        <span>{{ $reply['created_by']['name'] }} ({{ $reply['created_by']['email'] }})</span>
                                        <span class="small text-muted"><i class="fa fa-clock-o mr-1"></i>{{ \Carbon\Carbon::parse($reply['comment_at'])->format('d M Y H:i') }}</span>
                                    </span>
                                    <p class="text-small mt-1 font-weight-light text-muted">
                                        {{ ucfirst($reply['comment']) }}
                                    </p>
                                    @if(isset($reply['attachment_file']))
                                        <div class="box-footer">
                                            <i class="fa fa-paperclip" style="color:#666"></i>
                                            <a target="_blank" href="{{ assets($reply['attachment_path']) }}">
                                                {{ $reply['attachment_file'] }}
                                            </a>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        @endif
                    </ul>

                    @if($showReplyForm)
                        <div class="media-body pl-3 pr-1">
                            <div class="rounded">
                                <input name="comment" id="comment-{{ $comment['id'] }}" class="form-control comment-input"
                                       placeholder="Add a comment..." data-id="{{ $comment['id'] }}"/>
                                <p class="small text-muted mt-1"><b>Pro tip:</b> press <b>Enter</b> to comment
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </li>
        @endforeach
    @else
        <li class="list-group-item d-flex align-items-center justify-content-between mb-1 py-2">
            <div class="mb-0">
                <h5 class="text-muted">No comments</h5>
            </div>
        </li>
    @endif
</ul>

@push('after_styles')
    <style>
        .box-header {
            color: #444;
            display: block;
            padding: 10px;
            position: relative;
        }

        .box-header.with-border {
            border-bottom: 1px solid #f4f4f4;
        }

        .box-header.with-border {
            border-top-right-radius: 10px !important;
            border-top-left-radius: 10px !important;
        }

        .box-content {
            background-color: #f9f9f9 !important;
            border-radius: 0.5rem;
            box-shadow: none !important;
            transition: all .3s ease-in-out;
        }

        .box-footer {
            font-size: .8em !important;
        }
    </style>
@endpush

@push('after_scripts')
    <script>
        @if($showReplyForm)
        // insert comment
        $('.comment-input').on('keydown', function (e) {
            if (e.keyCode == 13 && !e.shiftKey) {
                e.preventDefault();
                let commentText = $(this).val();
                let dataId = $(this).attr('data-id')

                if (commentText.trim() !== '') {
                    $.ajax({
                        type: 'POST',
                        url: '{{ $action }}/' + dataId,
                        data: {
                            comment: commentText
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                location.reload();
                            } else {
                                new PNotify({
                                    title: "Failed!",
                                    text: response.message,
                                    type: "warning"
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            new PNotify({
                                title: "Error!",
                                text: error,
                                type: "warning"
                            });
                        }
                    });
                }

                $('#comment').val('');
            }
            @endif
        });
    </script>

@endpush
