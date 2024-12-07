@php
    $entry = $entry ?? [];
    $activityLogs = $activityLogs ?? [];
    $completeStatus = $completeStatus ?? null;
    $refId = $refId ?? null;
@endphp

<ul class="timeline" id="timeline">
    @if(isset($activityLogs))
        @php
            $i = 0;
            $lastDate = $activityLogs->keys()->first();
            $firstDate = $activityLogs->keys()->last();
        @endphp

        @foreach ($activityLogs as $date => $logs)
            <li class="time-label">
                <span class="bg-secondary pr-2">
                    <button type="button" onclick="icontoogle('{{ $i }}')"
                            class="btn bg-default btn-xs"
                            data-widget="collapse" data-toggle="collapse"
                            href="#col{{ $i }}" role="button"
                            aria-expanded="false" aria-controls="col{{ $i }}">
                        <i id="icon{{ $i }}"
                           class="fa @if($i == count($activityLogs)-1) fa-plus @else fa-minus @endif"></i>
                    </button>
                    <b class="pl-1">{{ \Carbon\Carbon::parse($date)->format('d F Y') }}</b>
                </span>
            </li>
            <div class="collapse in" id="col{{ $i }}">
                <ul class="timeline">
                    @php $previous = null; $next = null; @endphp
                    @foreach ($logs as $key => $item)
                        @php
                            $complete = in_array($item->action, $completeStatus);
                            $bgSuccess = $complete ? 'bg-success' : '';
                            $textWhite = $complete ? 'text-white' : '';
                        @endphp
                        <li data-id="{{ $entry->id }}"
                            data-itemId="{{ $item->id }}"
                            data-refId="{{ $refId }}"
                            onclick="handleItemClick(this)">
                            <div class="timeline-item entry-container
                                {{ $date == $lastDate && $key == 0 ? 'active' : '' }} {{ $bgSuccess }}">
{{--                                <span class="time {{ $key == 0 ? 'text-black' : '' }}">--}}
{{--                                    <i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($item->answered_at)->format('H:i:s') }}--}}
{{--                                </span>--}}
                                <div class="entry-details py-1 px-2">
                                    <div class="">
                                        <b class="time alert-info text-dark">
                                            <i class="fa fa-clock text-muted"></i> {{ \Carbon\Carbon::parse($item->answered_at)->format('H:i:s') }}
                                            &nbsp;&nbsp; - &nbsp;&nbsp;({{ \Carbon\Carbon::parse($item->response_time)->format('H:i:s') }})
                                        </b>
                                        <div class="mb-1"></div>
                                        <b class="entry-name mt-2 {{ $textWhite }}">{{ ucwords($item->creator_name) ?? '' }} </b>
                                        <span class="badge badge-secondary" style="font-size:.6em;">{{ $item->type }}</span><br>
                                        <small
                                            class="{{ $date == $firstDate && $key == 0 ? 'text-dark' : 'text-muted' }} {{ $textWhite }}">
                                            ({{ $item->creator_email ?? config('app.MAIL_FROM_ADDRESS') }})
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>
            @php $i++ @endphp
        @endforeach
    @endif
</ul>

    <style>
        .entry-container {
            display: flex;
            align-items: center;
            margin-top: 1px !important;
        }

        .entry-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-left: 10px;
            margin-right: 10px;
        }

        .entry-details {
            display: flex;
            flex-direction: column;
        }

        .entry-name {
            font-weight: bold;
        }

        .entry-email {
            font-size: 12px;
        }

        .entry-replied-at {
            margin-top: 1px;
            font-size: 12px;
        }

        .entry-status {
            float: right;
        }

        .custom-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #timeline {
            height: 400px;
            overflow-y: scroll;
        }

        .timeline li {
            margin: 10px 0 0 0 !important;
        }

        .timeline > li > .timeline-item > .time {
            color: #999;
            float: right;
            padding: 10px;
            font-size: 12px;
        }

        .timeline > li > .timeline-item {
            -webkit-box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
            border-radius: 3px;
            margin-top: 0;
            background: #fff;
            color: #444;
            margin-left: 10px !important;
            margin-right: 15px;
            padding: 0;
            position: relative;
        }

         /* Style for hover effect */
         .timeline li:hover {
             /*background-color: #f0f0f0;*/
             cursor: pointer;
         }

        /* Style for click effect */
        .timeline li.active {
            background-color: #e8e8e8;
        }

        .time {
            color: #000000 !important;
            font-size: .9em !important;
        }

        .timeline:before {
            content: none;
            position: absolute;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #ddd;
            left: 31px;
            margin: 0;
            border-radius: 2px;
        }

        .timeline .entry-container.active {
            border-left: 3px solid #347aeb;
        }

        .text-white {
            color: #ffff !important;
        }
    </style>
