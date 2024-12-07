{{-- Select2 Multiple Backpack CRUD filter --}}

<li filter-name="{{ $filter->name }}"
    filter-type="{{ $filter->type }}"
    class="dropdown {{ Request::get($filter->name)?'active':'' }}">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $filter->label }} <span class="caret"></span></a>
    <div class="dropdown-menu">
        <div class="form-group backpack-filter m-b-0">
            <select id="filter_{{ $filter->name }}" name="filter_{{ $filter->name }}" class="form-control input-sm select2" placeholder="{{ $filter->placeholder }}" multiple>
                <option></option>

                @if (is_array($filter->values) && count($filter->values))
                    @foreach($filter->values as $key => $value)
                        <option value="{{ $key }}"
                                @if($filter->isActive() && json_decode($filter->currentValue) && array_search($key, json_decode($filter->currentValue)) !== false)
                                selected
                            @endif
                        >
                            {{ $value }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</li>

{{-- ########################################### --}}
{{-- Extra CSS and JS for this particular filter --}}

{{-- FILTERS EXTRA CSS  --}}
{{-- push things in the after_styles section --}}

@push('crud_list_styles')
    <!-- include select2 css-->
    <link href="{{ asset('vendor/backpack/select2/select2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/backpack/select2/select2-bootstrap-dick.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .form-inline .select2-container {
            display: inline-block;
        }
        .select2-drop-active {
            border:none;
        }
        .select2-container .select2-choices .select2-search-field input, .select2-container .select2-choice, .select2-container .select2-choices {
            border: none;
        }
        .select2-container-active .select2-choice {
            border: none;
            box-shadow: none;
        }
    </style>
@endpush


{{-- FILTERS EXTRA JS --}}
{{-- push things in the after_scripts section --}}

@push('crud_list_scripts')
    <!-- include select2 js-->
    <script src="{{ asset('vendor/backpack/select2/select2.js') }}"></script>
    <script>
        jQuery(document).ready(function($) {
            // trigger select2 for each untriggered select2 box
            $('.select2').each(function (i, obj) {
                if (!$(obj).data("select2"))
                {
                    $(obj).select2({
                        allowClear: true,
                        closeOnSelect: false
                    });
                }
            });
        });
    </script>

    <script>
        var getParams = function (url) {
            var params = {};
            var parser = document.createElement('a');
            parser.href = url;
            var query = parser.search.substring(1);
            var vars = query.split('&');
            for (var i = 0; i < vars.length; i++) {
                var pair = vars[i].split('=');
                if (pair[0] != "") {
                    params[pair[0]] = decodeURIComponent(pair[1]);
                } else {
                    params = null;
                }
            }
            return params;
        };

        jQuery(document).ready(function($) {
            $("select[name=filter_{{ $filter->name }}]").change(function() {
                var value = '';
                if ($(this).val() !== null) {
                    // clean array from undefined, null, "".
                    var values = $(this).val().filter(function(e){ return e === 0 || e });
                    // stringify only if values is not empty. otherwise it will be '[]'.
                    value = values.length !== 0 ? JSON.stringify(values) : '';
                }

                var parameter = '{{ $filter->name }}';

                // behaviour for ajax table
                var ajax_table = $("#crudTable").DataTable();
                var current_url = ajax_table.ajax.url();
                var new_url = addOrUpdateUriParameter(current_url, parameter, value);

                // replace the datatables ajax url with new_url and reload it
                new_url = normalizeAmpersand(new_url.toString());
                ajax_table.ajax.url(new_url).load();

                // add filter to URL
                crud.updateUrl(new_url);

                // mark this filter as active in the navbar-filters
                if (URI(new_url).hasQuery('{{ $filter->name }}', true)) {
                    $("li[filter-name={{ $filter->name }}]").removeClass('active').addClass('active');
                }
                else
                {
                    $("li[filter-name={{ $filter->name }}]").trigger("filter:clear");
                }

                var param = getParams(new_url);

                filter = [];
                if (param) {
                    for (var key in param) {
                        filter.push(param[key]);
                    }
                    fetch_component();
                }


                @isset($filter->options['parent_url'])
                $.ajax({
                    url: "{{$filter->options['parent_url']}}",
                    data: {
                        id: value,
                        role : '{{$filter->name}}'
                    },
                    success: function (res) {
                        @if(isset($filter->options['parent_component']))
                        $("select[name=filter_{{ $filter->options['parent_component'] }}]").html(null);
                        var option = new Option('', '');
                        $("select[name=filter_{{ $filter->options['parent_component'] }}]").append(option);
                        for (var i = 0; i < res.length; i++) {
                            var option = new Option(res[i].text, res[i].id);
                            option.selected = false;
                            $("select[name=filter_{{ $filter->options['parent_component'] }}]").append(option)
                        }
                        @endif
                    }
                });
                @endisset
            });

            // when the dropdown is opened, autofocus on the select2
            $("li[filter-name={{ $filter->name }}]").on('shown.bs.dropdown', function () {
                $('#filter_{{ $filter->name }}').select2('open');
            });

            // clear filter event (used here and by the Remove all filters button)
            $("li[filter-name={{ $filter->name }}]").on('filter:clear', function(e) {
                // console.log('select2 filter cleared');
                $("li[filter-name={{ $filter->name }}]").removeClass('active');
                $("li[filter-name={{ $filter->name }}] .select2").select2("val", "");

                var value = '';
                if ($("select[name=filter_{{ $filter->name }}]").val() !== null) {
                    // clean array from undefined, null, "".
                    var values = $("select[name=filter_{{ $filter->name }}]").val().filter(function(e){ return e === 0 || e });
                    // stringify only if values is not empty. otherwise it will be '[]'.
                    value = values.length !== 0 ? JSON.stringify(values) : '';
                }
                var ajax_table = $("#crudTable").DataTable();
                var current_url = ajax_table.ajax.url();
                var parameter = '{{ $filter->name }}';
                var new_url = addOrUpdateUriParameter(current_url, parameter, value);

                // replace the datatables ajax url with new_url and reload it
                new_url = normalizeAmpersand(new_url.toString());

                var param = getParams(new_url);
                console.log(param);

                filter = [];
                if (param) {
                    for (var key in param) {
                        filter.push(param[key]);
                    }

                }
                fetch_component();
            });
        });
    </script>
@endpush
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
