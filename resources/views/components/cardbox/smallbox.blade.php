<div class="small-box {{ $color ?? '' }}">
    <div class="inner">
        <h3 id="summary_{{ $status ?? '' }}"></h3>
        <strong id="total_{{ $status ?? '' }}"></strong><br>
        <span class="label">{{ $label }}</span>
    </div>
    <div class="icon">
        <i class="{{ $icon ?? '' }}"></i>
    </div>
    <a href="{{ $link ?? '#' }}" class="small-box-footer">
        More info <i class="fa fa-arrow-circle-right"></i></a>
</div>

@push('after_styles')
    <style>
        .small-box {
            border-radius: 10px;
            position: relative;
            display: block;
            margin-bottom: 20px;
            box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        }

        .small-box .label {
            font-size:1.5em;
            font-weight: bold;
        }

        .small-box .icon {
            -webkit-transition: all .3s linear;
            -o-transition: all .3s linear;
            transition: all .3s linear;
            position: absolute;
            top: -10px;
            right: 10px;
            z-index: 0;
            font-size: 80px;
            color: rgba(0, 0, 0, 0.15);
        }
    </style>
@endpush
