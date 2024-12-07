<button type="button"
        id="{{ $buttonId }}"
        {{ $disabled ?? '' }}
        class="btn btn-sm btn-primary btn-rounded {{ $buttonClass ?? '' }}">
    <i class="fa fa-save"></i>&nbsp; {{ $buttonText ?? 'Submit' }}
</button>

@push('after_scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(function () {
            $("#{{ $buttonId }}").click(function () {
                swal({
                    text: 'Are you sure to submit this response?',
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
                        $("#{{ $formId }}").submit();
                    }
                })
            });
        })
    </script>
@endpush

