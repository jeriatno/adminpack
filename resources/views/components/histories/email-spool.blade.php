<ul class="list-group">
    @if(count($emailLogs) == 0)
        <li class="list-group-item d-flex align-items-center justify-content-between mb-1 py-2">
            <div class="mb-0">
                <h5 class="text-muted">No histories</h5>
            </div>
        </li>
    @else
        @foreach($emailLogs as $log)
            <li class="list-group-item d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-1 py-2">
                <div class="mb-0">
                    <div class="d-flex">
                        <span class="input-group-text bg-white px-4 border-md border-right-0 mr-2">
                            <i class="fa fa-user text-muted mr-1"></i>
                            <span>({!! $log->sender ?? 'System' !!})</span>
                        </span>
                        <div class="">
                            <span
                                class="font-weight-bold mr-2 text-muted">{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i') }}</span>
                            <span class="text-muted">
                                {{ $log->subject }}
                            </span>
                        </div>

                    </div>
                </div>

                <div class="d-flex mt-2 mt-md-0">
                    <div class="mr-2">
                        <a class="text-muted btn-link show-recipients"
                           onclick="handleShowRecipients(event)"
                           data-logId="{{ $log->id }}"
                           data-subject="{{ $log->subject }}"
                           data-sender="{{ $log->sender }}"
                           data-recipients="{{ json_encode($log->recipients) }}">
                            Show Recipients
                        </a>
                    </div>
                    <div>
                        @if($log->status == \App\Models\GlobalEmailSpool::SENT)
                            <span class="badge badge-success px-1 rounded-pill">Sent</span>
                        @elseif($log->status == \App\Models\GlobalEmailSpool::PENDING)
                            <span class="badge badge-warning px-1 rounded-pill">Pending</span>
                        @else
                            <span class="badge badge-danger px-1 rounded-pill" data-toggle="tooltip"
                                  title="{{ $log->error_msg }}">Fail</span>
                            @if($log->sender == auth()->user()->email || isAdmin())
                                <a class="btn btn-xs btn-default btn-rounded bt-resend px-1"
                                   href="{{ backpack_url('global-email-spool/resend/'.$log->id.'?action='.$log->action_name) }}">Resend</a>
                            @endif
                        @endif
                    </div>
                </div>
            </li>

        @endforeach
    @endif
</ul>

@push('before_styles')
    <div class="modal fade" id="modalRecipients">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Recipient List</h4>
                    <button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row mx-2">
                    <table class="table table-striped table-responsive">
                        <thead>
                        <tr>
                            <th>Subject:</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <span id="logSubject"></span>
                            </td>
                        </tr>
                        </tbody>
                        <thead>
                        <tr>
                            <th>Sender:</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <ul>
                                    <li><span id="logSender"></span></li>
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                        <thead>
                        <tr>
                            <th>To:</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <ul id="recipientsTo"></ul>
                            </td>
                        </tr>
                        </tbody>
                        <thead>
                        <tr>
                            <th>Cc:</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <ul id="recipientsCc"></ul>
                            </td>
                        </tr>
                        </tbody>
                        <thead>
                        <tr>
                            <th>Bcc:</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <ul id="recipientsBcc"></ul>
                            </td>
                        </tr>
                        </tbody>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endpush

@push('after_styles')
    <link rel="stylesheet" href="{{ asset('css/responsive-hack.css') }}">
    <style>
        .mx-2 {
            margin: 10px 20px;
        }

        .btn-rounded {
            border-radius: 20px;
        }
    </style>
@endpush

@push('after_scripts')
    <script>
        function handleShowRecipients(event) {
            event.preventDefault();
            $('#modalRecipients').modal('show');

            let logId = event.currentTarget.getAttribute('data-logId');
            let subject = event.currentTarget.getAttribute('data-subject');
            let sender = event.currentTarget.getAttribute('data-sender');
            let recipientsJson = JSON.parse(event.currentTarget.getAttribute('data-recipients'));

            // Parse the JSON string into an object
            let recipientsObject = JSON.parse(recipientsJson);

            $('#logSubject').text(subject)
            $('#logSender').text(sender)

            let recipientsToHtml = '';
            recipientsObject.to.forEach(function (to) {
                recipientsToHtml += '<li>' + to + '</li>';
            });
            $('#recipientsTo').html(recipientsToHtml);

            let recipientsCcHtml = '';
            recipientsObject.cc.forEach(function (bcc) {
                recipientsCcHtml += '<li>' + bcc + '</li>';
            });
            $('#recipientsCc').html(recipientsCcHtml);

            let recipientsBccHtml = '';
            recipientsObject.bcc.forEach(function (bcc) {
                recipientsBccHtml += '<li>' + bcc + '</li>';
            });
            $('#recipientsBcc').html(recipientsBccHtml);
        }

        $(document).ready(function () {
            $('#modalRecipients .close').click(function () {
                $('#modalRecipients').modal('hide');
            });
        });

    </script>
@endpush

