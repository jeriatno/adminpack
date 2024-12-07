@php
    $entry = $entry ?? [];
    $activityLogs = $activityLogs ?? [];
    $completeStatus = $completeStatus ?? null;
    $previewLink = $previewLink ?? null;
    $divHeight = $divHeight ?? null;
@endphp

<ul class="timeline" style="height: {{ $divHeight }}; overflow-y: scroll">
    @if(isset($activityLogs))
        @php
            $i = 0;
            $keyFirst = $activityLogs->keys()->first();
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
                        <li>
                            <i class="fa fa-user bg-secondary"></i>
                            <div class="timeline-item entry-container {{ $item->is_primary ? 'bg-warning' : '' }}">
                                <span class="time {{ $item->is_primary ? 'text-black' : '' }}">
                                    <i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }}
                                </span>
                                <div class="entry-details pl-1 py-1">
                                    <div class="entry-name">
                                        <b>{{ ucwords($item->name) ?? '' }} </b>
                                        <small
                                            class="{{ $date == $keyFirst && $key == 0 ? 'text-dark' : 'text-muted' }}">
                                            ({{ $h->sender ?? config('app.MAIL_FROM_ADDRESS') }})
                                        </small>
                                    </div>
                                    <hr style="margin: 4px">
                                    <div class="entry-email">
                                        <span class="{{ $date == $keyFirst && $key == 0 ? 'text-dark' : 'text-muted' }}">
                                            {!! strlen($item->body) > 100 ? substr($item->body, 0, 100) . '...' : $item->body !!}
                                        </span>
                                        <div class="timeline-body">
                                            <small>
                                                <a class="text-muted"
                                                   href="{{ $previewLink.'/'.$entry->getKey().'?s='}}">
                                                    Show more..
                                                </a>
                                            </small>
                                        </div>
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

@push('after_styles')
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
            margin-left: 60px;
            margin-right: 15px;
            padding: 0;
            position: relative;
        }
    </style>
@endpush
