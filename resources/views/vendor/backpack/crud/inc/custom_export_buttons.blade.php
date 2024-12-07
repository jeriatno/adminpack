@if ($crud->exportButtons())
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.bootstrap.min.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.18/pdfmake.min.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.18/vfs_fonts.js" type="text/javascript"></script>
    <script src="//cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js" type="text/javascript"></script>
    <script src="//cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js" type="text/javascript"></script>
    <script src="//cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            function newexportaction(e, dt, button, config) {
                var self = this;
                var oldStart = dt.settings()[0]._iDisplayStart;
                dt.one('preXhr', function (e, s, data) {
                    // Just this once, load all data from the server...
                    data.start = 0;
                    data.length = 2147483647;
                    dt.one('preDraw', function (e, settings) {
                        // Call the original action function
                        if (button[0].className.indexOf('buttons-copy') >= 0) {
                            $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                        } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                            $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                                $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                                $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                        } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                            $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                                $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                                $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                        } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                            $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                                $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                                $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                        } else if (button[0].className.indexOf('buttons-print') >= 0) {
                            $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                        }
                        dt.one('preXhr', function (e, s, data) {
                            // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                            // Set the property to what it was before exporting.
                            settings._iDisplayStart = oldStart;
                            data.start = oldStart;
                        });
                        // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                        setTimeout(dt.ajax.reload, 0);
                        // Prevent rendering of the full data to the DOM
                        return false;
                    });
                });
                // Requery the server with the new one-time export settings
                dt.ajax.reload();
            };
        })
        crud.dataTableConfiguration.buttons = [
            {
                extend: 'collection',
                text: '<i class="fa fa-download"></i> {{ trans('backpack::crud.export.export') }}',
                buttons: [
                    {
                        name: 'excelHtml5',
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [':visible:not(.not-export-col):not(.hidden):not([data-visible-in-export=false])'],
                        },
                        action: function newexportaction(e, dt, button, config) {
                            var self = this;
                            var oldStart = dt.settings()[0]._iDisplayStart;
                            dt.one('preXhr', function (e, s, data) {
                                // Just this once, load all data from the server...
                                data.start = 0;
                                data.length = 2147483647;
                                dt.one('preDraw', function (e, settings) {

                                    $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                                        $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                                        $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);

                                    dt.one('preXhr', function (e, s, data) {
                                        // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                                        // Set the property to what it was before exporting.
                                        settings._iDisplayStart = oldStart;
                                        data.start = oldStart;
                                    });
                                    // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                                    setTimeout(dt.ajax.reload, 0);
                                    // Prevent rendering of the full data to the DOM
                                    return false;
                                });
                            });
                            // Requery the server with the new one-time export settings
                            dt.ajax.reload();
                        }
                    },
                ]
            },
            {
                extend: 'colvis',
                text: '<i class="fa fa-eye-slash"></i> {{ trans('backpack::crud.export.column_visibility') }}',
                columns: ':not(.not-export-col):not([data-visible-in-export=false])'
            }
        ];

        // move the datatable buttons in the top-right corner and make them smaller
        function moveExportButtonsToTopRight() {
            crud.table.buttons().each(function(button) {
                if (button.node.className.indexOf('buttons-columnVisibility') == -1 && button.node.nodeName=='BUTTON')
                {
                    button.node.className = button.node.className + " btn-sm";
                }
            })
            $(".dt-buttons").appendTo($('#datatable_button_stack' ));
            $('.dt-buttons').css('display', 'inline-block');
        }

        crud.addFunctionToDataTablesDrawEventQueue('moveExportButtonsToTopRight');
    </script>
@endif
