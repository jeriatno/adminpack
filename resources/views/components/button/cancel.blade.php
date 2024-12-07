<button type="button"
        id="{{ $buttonId ?? '' }}"
        @if(isset($withModal))
            data-toggle="modal" data-target="#{{ $modalId }}"
        @endif
        class="btn btn-dark bulk-button {{ $buttonClass ?? '' }}">
    <i class="fa fa-times-circle"></i> {{ $buttonText ?? 'Cancel' }}
</button>

@section('before_styles')
    {{-- Modal Cancel --}}
    <div class="modal fade" id="modalCancel" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ $modalTitle ?? 'Cancel' }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="">Ticket Number</label><br>
                            <input name="ticket_id" id="ticket_id" class="form-control" placeholder="Reference Number"
                                   type="number">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="bulkCancel" onclick="bulkCancel(this)">
                        Cancel Now
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after_scripts')

    <script>
        function bulkCancel(button) {
            if (typeof crud.checkedItems === 'undefined' || crud.checkedItems.length == 0) {
                new PNotify({
                    title: "{{ trans('backpack::crud.bulk_no_entries_selected_title') }}",
                    text: "{{ trans('backpack::crud.bulk_no_entries_selected_message') }}",
                    type: "warning"
                });

                return;
            }

            var message = ("Are you sure you want to cancel the checked entries?").replace(":number", crud.checkedItems.length);
            var button = $(this);

            // show confirm message
            if (confirm(message) == true) {
                // submit an AJAX delete call
                $.ajax({
                    url: "{{ url(URL::current()) }}/bulk-cancel",
                    type: 'POST',
                    data: {
                        entries: crud.checkedItems,
                        ticket_id: $('#ticket_id').val(),
                    },
                    cache: false,
                    headers: {
                        'Cache-Control': 'no-store, no-cache, must-revalidate, max-age=0'
                    },
                    success: function (response) {
                        // Show an alert with the result
                        if (response.status == 'success') {
                            new PNotify({
                                title: "Success!",
                                text: response.message,
                                type: "success"
                            });
                        } else {
                            new PNotify({
                                title: "Failed!",
                                text: response.error,
                                type: "warning"
                            });
                        }

                        crud.checkedItems = [];
                        crud.table.ajax.reload(null, false);
                        $('#ticket_id').val('');
                        $('#modalCancel').modal('hide');
                    },
                    error: function (xhr, status, error) {
                        // Show an alert with the result
                        new PNotify({
                            title: "Error!",
                            text: error,
                            type: "warning"
                        });
                    }
                });
            }
        }
    </script>

@endpush
