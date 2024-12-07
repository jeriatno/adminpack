{{-- Show the errors, if any --}}
@if ($errors->any())
    <div class="callout callout-danger">
        <h5>
            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
            <strong>Error Notification:</strong>
        </h5>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
