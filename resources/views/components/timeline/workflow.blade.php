@php
    $entry = $entry ?? [];
    $activityLogs = $activityLogs ?? [];
    $completeStatus = $completeStatus ?? null;
    $previewLink = $previewLink ?? null;
    $nextApprover = $nextApprover ?? null;
    $divHeight = $divHeight ?? null;
@endphp

<ul class="timeline" style="height: {{ $divHeight }}; overflow-y: scroll">
    @if(isset($activityLogs))
        @php $i = 0; @endphp

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
                            $workflow = isset($workflowActions[$key]) ? $workflowActions[$key] : null;
                        @endphp

                        @if ($i == 0 && $key == 0)
                            @if ($item->action != $completeStatus)
                                @php
                                    if(str_contains($item->action, 'reject') && $item->action != 'tax_reject') {
                                        $waitingLabel = $workflow[0];
                                        $waitingStatus = $workflow[1];
                                    } else {
                                        $waitingLabel = $workflow;
                                        $waitingStatus = $item->status;
                                    }

                                    $waitingSlug = \Str::slug(str_replace("pending ", "", strtolower(str_replace("pending-", "pending ", $waitingStatus))));
                                @endphp

                                <li>
                                    <i class="fa fa-user bg-secondary"></i>
                                    <div class="timeline-item entry-container alert-warning">
                                        <span class="time text-black"><i class="fa fa-clock-o"></i> -- : -- : --</span>
                                        <div class="entry-details pl-1 py-1">
                                            <div class="entry-name">
                                                @if($waitingStatus == 'PO-principal-submitted')
                                                    <strong>Waiting Requester to submit Customer PO</strong>
                                                @else
                                                    <strong>Waiting {{ is_array($waitingLabel) ? $waitingLabel[0] : $waitingLabel }}</strong>
                                                @endif
                                            </div>
                                            <div class="entry-email">
                                                <div class="timeline-body">
                                                    @if($waitingStatus == 'PO-principal-submitted')
                                                        <a class="text-black" data-toggle="tooltip"
                                                           title="{{ $nextApprover }}"
                                                           href="{{ $previewLink.'/'.$entry->getKey().'?s=requester' }}">
                                                            Pending Requester
                                                        </a>
                                                    @else
                                                        <a class="text-black" data-toggle="tooltip"
                                                           title="{{ $nextApprover }}"
                                                           href="{{ $previewLink.'/'.$entry->getKey().'?s='.$waitingSlug }}">
                                                            {{ ucword(str_replace('-', ' ', $waitingStatus)) }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endif
                        <li>
                            <i class="fa fa-user bg-secondary"></i>
                            <div class="timeline-item entry-container {{ $item->action == $completeStatus ? 'alert-success' : '' }}">
                                <span class="time {{ $item->action == $completeStatus ? 'text-black' : '' }}">
                                    <i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}
                                </span>
                                <div class="entry-details pl-1 py-1">
                                    <div class="entry-name">
                                        <strong>{{ $item->createdBy->name ?? '-' }}</strong>
                                    </div>
                                    <div class="entry-email">
                                        <div class="timeline-body">
                                            <span
                                                class="{{ $item->action == $completeStatus ? 'text-black' : 'text-muted' }}">{{ $item->description }}</span>
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
    </style>
@endpush
