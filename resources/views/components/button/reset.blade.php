<button type="button"
        id="{{ $buttonId ?? 'btnReset' }}"
        {{ $disabled ?? '' }}
        class="btn btn-default {{ $buttonClass ?? '' }}">
    <i class="fa fa-ban"></i>&nbsp; {{ $buttonText ?? 'Reset' }}
</button>

@push('after_scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(function () {
            $("#{{ $buttonId ?? 'btnReset' }}").click(function () {
                swal({
                    text: 'Are you sure to reset this request?',
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
                        $("#{{ $formId }}")[0].reset();
                    }
                })
            });
        })
    </script>
@endpush

