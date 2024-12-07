<button type="button"
        id="{{ $buttonId ?? 'btnSubmit' }}"
        {{ $disabled ?? '' }}
        class="btn btn-primary {{ $buttonClass ?? '' }}">
    <i class="fa fa-save"></i>&nbsp; {{ $buttonText ?? 'Submit' }}
</button>

@push('after_scripts')
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script>
        $(function () {
            $("#{{ $buttonId ?? 'btnSubmit' }}").click(function () {
                swal({
                    text: 'Are you sure to submit this request?',
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

