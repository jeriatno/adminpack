<div class="stats row">
    @foreach($stats as $stat)
        @php
            $colClass = 'col-lg-' . round((12 / count($stats)));
            $useGradient = $useGradient ?? true;
            $theme = !$useGradient ? $stat['theme'] : str_replace('bg-', 'bg-gradient-', $stat['theme']);
        @endphp
        <div class="{{ $colClass }} col-md-3 col-sm-6 col-12">
            @component('components.cardbox.infobox', [
                'info_theme' => $theme,
                'info_icon' => $stat['icon'],
                'info_label' => $stat['label'],
                'info_number' => $stat['number'],
                'withOnClick' => $stat['onClick'],
            ]) @endcomponent
        </div>
    @endforeach
</div>

@push('after_scripts')

    <script>
        $(document).ready(function () {
            // Reset filters and reload stats
            $("#remove_filters_button").click(function () {
                setTimeout(function () {
                    getData();
                }, 1000);
            });

            // Initial data fetch
            getData();
        });

        // Fetch stats via AJAX
        function getData() {
            $.ajax({
                url: "{{ $statsUrl ?? url(URL::current() . '/stats') }}",
                success: function (res) {
                    const stats = res.data;

                    @foreach($stats as $stat)
                    $('#{{ $stat['number'] }}').html(stats['{{ $stat['number'] }}'] || 0);
                    @endforeach
                }
            });
        }

        // Handle on click events
        function clickStatus(status){
            var value = status;
            var parameter = 'status';

            // behaviour for ajax table
            var ajax_table = $("#crudTable").DataTable();
            var current_url = ajax_table.ajax.url();
            var new_url = addOrUpdateUriParameter(current_url, parameter, value);

            // replace the datatables ajax url with new_url and reload it
            new_url = normalizeAmpersand(new_url.toString());
            ajax_table.ajax.url(new_url).load();

            // add filter to URL
            crud.updateUrl(new_url);
        }

    </script>

@endpush
