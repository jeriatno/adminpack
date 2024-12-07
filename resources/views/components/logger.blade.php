<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th width="20%">Information</th>
        <th width="40%">Body</th>
        <th width="40%">Response</th>
    </tr>
    </thead>
    <tbody>
    @foreach($logs as $log)
        <tr>
            <td>
                <div class="list-group">
                    <div href="#" class="list-group-item active">
                        <strong class="list-group-item-heading">Description</strong>
                        <p class="list-group-item-text text-muted" style="word-wrap: break-word; white-space:pre-wrap;">{{ $log->description }}</p>
                    </div>
                    <div href="#" class="list-group-item">
                        <strong class="list-group-item-heading">Endpoint</strong>
                        <p class="list-group-item-text text-muted" style="word-wrap: break-word; white-space:pre-wrap;">{{ $log->uri }}</p>
                    </div>
                    <div href="#" class="list-group-item">
                        <strong class="list-group-item-heading">Method Type</strong>
                        <p class="list-group-item-text text-muted"> {{ $log->method }}</p>
                    </div>
                    <div href="#" class="list-group-item">
                        <strong class="list-group-item-heading">Status Code</strong>
                        <p class="list-group-item-text text-muted"> {{ $log->status }}</p>
                    </div>
                    <div href="#" class="list-group-item">
                        <strong class="list-group-item-heading">Action By</strong>
                        <p class="list-group-item-text text-muted">{{ $log->actionBy->name ?? 'System' }}</p>
                    </div>
                    <div href="#" class="list-group-item">
                        <strong class="list-group-item-heading">Action At</strong>
                        <p class="list-group-item-text text-muted">{{ $log->created_at }}</p>
                    </div>
                </div>
            </td>
            <td>
                <textarea class="form-control" rows="21" readonly style="width: 100%">{{ $log->body }}</textarea>
            </td>
            <td>
                <textarea class="form-control" rows="21" readonly style="width: 100%">{{ $log->response }}</textarea>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@push('after_styles')
<style>
    .card.bg-purple {
        background-color: #2a2573 !important;
    }

    .list-group {
        width: 20rem;
    }
    .list-group-item {
        padding: 0.75rem 1.25rem 0rem;
    }
</style>
@endpush
