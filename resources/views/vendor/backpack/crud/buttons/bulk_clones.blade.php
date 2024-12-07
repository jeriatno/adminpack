<a href="javascript:void(0)"
   onclick="btnBulkCloneEntries(this)"
   name="action"
   class="btn btn-default bulk-button" id="duplicate-button">
    <span class="fa fa-copy" role="presentation" aria-hidden="true"></span> &nbsp;
    <span>Duplicate</span>
</a>

@push('after_scripts') @if (request()->ajax())
    @endpush
@endif

<script>
    function btnBulkCloneEntries(button) {
        if (typeof crud.checkedItems === 'undefined' || crud.checkedItems.length == 0) {
            new PNotify({
                title: "{{ trans('backpack::crud.bulk_no_entries_selected_title') }}",
                text: "{{ trans('backpack::crud.bulk_no_entries_selected_message') }}",
                type: "warning"
            });

            return;
        }

        var message = ("Are you sure you want to duplicate the checked entries?").replace(":number", crud.checkedItems.length);

        // show confirm message
        if (confirm(message) == true) {
            var ajax_calls = [];
            var create_route = "{{ url($crud->route) }}/bulk-clones";

            // submit an AJAX delete call
            $.ajax({
                url: create_route,
                type: 'POST',
                data: {
                    entries: crud.checkedItems,
                },
                beforeSend: function (xhr, settings) {
                    button.disabled = true;
                    $.LoadingOverlay("show");
                },
                success: function (result) {
                    $.LoadingOverlay("hide");

                    new PNotify({
                        title: result.status,
                        text: result.message,
                        type: result.status
                    });

                    button.disabled = false;
                    crud.checkedItems = [];
                    crud.table.ajax.reload(null, false);
                    // location.reload();
                },
                error: function (result) {
                    $.LoadingOverlay("hide");
                    button.disabled = false;

                    // Show an alert with the result
                    new PNotify({
                        title: "Failed!",
                        text: result.message ?? '504 Gateway Time-out',
                        type: "warning"
                    });
                }
            });
        }
    }
</script>

@if (!request()->ajax())
    @endpush
@endif
