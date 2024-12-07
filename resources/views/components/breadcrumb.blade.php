<div class="workflow-breadcrumb {{ $class ?? 'mt-2' }}" style="{{ $style ?? '' }}">
    <strong>{{ isset($blank) ? '' : 'Workflow Status :' }}</strong><br><br>
    <ul>
        {{ $slot }}
    </ul>
</div>

@push('after_styles')
    <style>
        .workflow-breadcrumb {
            display: inline-block;
            width: 100%;
            overflow-x: auto;
            font-size: .7em;
        }

        .workflow-breadcrumb strong {
            font-size: 1.2em !important;
        }

        .workflow-breadcrumb ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
        }

        .workflow-breadcrumb li {
            padding: 5px 10px;
            border-radius: 10px;
            background-color: #e0e0e9;
            margin-right: 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .workflow-breadcrumb li {
            padding: 5px 8px;
            border-radius: 10px;
            background-color: #e0e0e9;
            margin-right: 25px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            position: relative;
        }

        .workflow-breadcrumb li::before {
            content: '>';
            margin-right: 5px;
            color: #555;
            font-size: 12px;
            position: absolute;
            left: -15px;
        }

        .workflow-breadcrumb li:last-child::after {
            content: none;
        }

        .workflow-breadcrumb li:first-child::before {
            content: none;
        }
    </style>
@endpush