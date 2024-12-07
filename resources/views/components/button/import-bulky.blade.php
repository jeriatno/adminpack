<button type="button" class="btn btn-dark" data-toggle="modal" data-target="#modalImportFile">
    <i class="fa fa-upload"></i> {{ $title ?? 'Import New' }}
</button>

@section('before_scripts')
    <div class="modal fade" id="modalImportFile" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form id="formImport" method="post" action="{{ $importRoute ?? 'javascript:void(0)' }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $modalTitle ?? 'Import a File' }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group required">
                            <label for="">{{ $label ?? '' }}</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>

                        {{ $slot }}

                    </div>
                    <div class="modal-footer">
                        <a href="{{ $downloadRoute ?? 'javascript:void(0)' }}" class="btn btn-link pull-left">Download
                            Format</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="btnSubmitImport" type="submit" class="btn btn-primary">Import Now</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('after_scripts')
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#btnSubmitImport').on('click', function (e) {
                e.preventDefault();
                let $btn = $(this);

                swal({
                    text: 'Are you sure to import this file?',
                    icon: 'info',
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: '#347aeb',
                    confirmButtonText: "Yes",
                    closeOnConfirm: false,
                    buttons: ["No", {
                        text: "Yes",
                        closeModal: false,
                    }]
                }).then(function (isConfirm) {
                    if (isConfirm) {
                        $btn.prop('disabled', true);
                        $btn.html('<i class="fa fa-spinner fa-spin"></i> Importing...');

                        // Submit form
                        $('#formImport').submit();
                    }
                });
            });
        });

    </script>
@endpush

