<span class="icon-container" data-toggle="tooltip"
      title="{{ $title }}">
    @if(isset($withModal))
        <a href="javascript:void(0)" id="getModalReminder">
            <i class='fa fa-history'></i>
        </a>
    @else
        <i class='fa fa-history'></i>
    @endif
</span>

@if(isset($withModal))
    <div class="modal fade" id="modalReminder" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">List of upcoming Reminders &nbsp</h4>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body row" style="max-height: 600px; overflow-y: auto;">
                    <div class="col-md-12">
                        <div id="reminderContainer" class="reminderContainer col-md-12">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

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
        @if(isset($reminderLink))
            $('#getModalReminder').click(function () {
                let url = "{{ $reminderLink }}"
                $("#modalReminder").modal("show");

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (response) {
                        $('#reminderContainer').html(response.data)
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            });
        @endif
    </script>
@endpush



