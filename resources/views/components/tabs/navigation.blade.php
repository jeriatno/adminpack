<div class="col-md-12 m-t-10" id="tab-navigation">
    <div class="box">
        <div class="box-header">
            <div class="tab row">
                <div class="col-xs-10">
                    @php
                        $activeIsCollapse = true;
                        $pageUrl = request()->get('p', '');
                        $currentUrl = request()->fullUrl();
                        $lastUrl = pathLast();
                        $firstUrl = pathFirst(isset($links[0]) ? $links[0]['url'] : null);
                    @endphp

                    @foreach($links as $index => $link)
                        @php
                            $currentLink = $link['url'];
                            $isCollapse = $link['isCollapse'] ?? true;
                            parse_str(parse_url($currentLink, PHP_URL_QUERY), $queryParams);
                            $pageLink = $queryParams['p'] ?? '';
                            $lastLink = last(explode('/', parse_url($currentLink, PHP_URL_PATH)));

                            // Determine if the link should be active
                            if ($pageUrl === '') {
                                if (!empty($pageLink)) {
                                    $isActiveLink = '';
                                } else {
                                    if ($lastUrl === $lastLink) {
                                        $isActiveLink = 'active';
                                    } else {
                                        $isActiveLink = '';
                                    }
                                }
                            } else {
                                $isActiveLink = ($pageUrl === $pageLink) ? 'active' : '';
                                if ($isActiveLink === 'active') {
                                    $activeIsCollapse = $isCollapse;
                                }
                            }
                        @endphp

                        <a href="{{ $link['url'] }}">
                            <button class="tablinks {{ $isActiveLink }}" id="{{ $link['id'] }}">
                                <span>{{ $link['label'] }}</span>

                                @if(isset($withNotify))
                                    &nbsp;<span class="notif-badge" id="{{ $link['id'] }}-badge"></span>
                                @endif
                            </button>
                        </a>
                    @endforeach

                </div>
                <div class="col-xs-2 text-right">
                    @if($withReminder && isAdmin())
                        @component('components.notify.email-reminder', [
                            'title' => $reminderInfo,
                            'withModal' => true,
                            'reminderLink' => $reminderLink,
                        ]) @endcomponent
                    @else
                        @php $pullRight = 'pull-right'; @endphp
                    @endif
                    <button type="button" class="btn btn-box-tool collapse-button text-right {{ $pullRight ?? '' }}" data-widget="collapse" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-minus"></i></button>
                </div>
            </div>
        </div>
        <div class="box-body bg-white {{ $activeIsCollapse ? 'collapse' : '' }}">
            <div class="chart" id="chart_container">
                <canvas id="stack_chart_count" height="400"></canvas>
            </div>
        </div>
    </div>
</div>

@push('after_styles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
    <style>
        /* Style the tab */
        #tab-navigation .tab {
            display: flex;
            border-bottom: 1px solid #ccc;
            background-color: #f1f1f1;
            border-radius: 10px !important;
        }

        /* Style the buttons inside the tab */
        #tab-navigation .tab button {
            background-color: inherit;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 17px;
            border-radius: 10px !important;
        }

        /* Change background color of buttons on hover */
        #tab-navigation .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current tablink class */
        #tab-navigation .tab button.active {
            background: linear-gradient(118deg, #0072C6, #0072C6);
            border-bottom: 2px solid #007bff;
            color: white;
        }

        #tab-navigation .box, .box-header {
            background: none !important;
            box-shadow: none !important;;
        }

        #tab-navigation #stack_chart_count {
            height: 400px !important;
        }
    </style>
@endpush

@push('after_scripts')
    <script>
        $(document).ready(function(){
            $('.collapse-button').click(function() {
                var icon = $(this).find('i');
                if (icon.hasClass('fa-plus')) {
                    icon.removeClass('fa-plus');
                    icon.addClass('fa-minus');
                } else {
                    icon.removeClass('fa-minus');
                    icon.addClass('fa-plus');
                }
            });
        });
    </script>
@endpush
