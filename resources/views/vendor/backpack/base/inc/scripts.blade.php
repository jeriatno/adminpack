<script type="text/javascript"
        src="{{ asset('vendor/adminlte') }}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- Bootstrap 3.4.1 -->
<script src="{{ asset('vendor/backpack/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte') }}/plugins/pace/pace.min.js"></script>
<script src="{{ asset('vendor/adminlte') }}/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{ asset('vendor/adminlte') }}/dist/js/adminlte.js"></script>
<script type="text/javascript">
    $(document).ajaxStart(function () {
        Pace.restart();
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var activeTab = $('[href="' + location.hash.replace("#", "#tab_") + '"]');
    location.hash && activeTab && activeTab.tab('show');
    $('.nav-tabs a').on('shown.bs.tab', function (e) {
        location.hash = e.target.hash.replace("#tab_", "#");
    });
</script>
