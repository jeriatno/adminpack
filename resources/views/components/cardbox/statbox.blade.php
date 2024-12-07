<div class="info-box bg-gradient-info">
    <div class="info-box-content">
        <div class="d-flex justify-content-between align-items-center">
            <span class="info-box-text">{{ $stat_label1 }}</span>
            <span class="info-box-number">{{ $stat_value1 }}</span>
        </div>
        <hr style="margin:0">
        <div class="d-flex justify-content-between align-items-center">
            <span class="info-box-text">{{ $stat_label2 }}</span>
            <span class="info-box-number">{{ $stat_value2 }}</span>
        </div>
    </div>
    <div class="info-box-footer">
        <a href="{{ $stat_link ?? '#' }}" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

@push('after_styles')
    <style>
        .d-flex {
            display: flex;
        }

        .align-items-center {
            align-items: center;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .info-box {
            border-radius: 1rem !important;
            min-height: 55px !important;
        }

        .info-box-icon {
            border-top-left-radius: 1rem !important;
            border-bottom-left-radius: 1rem !important;
            height: 55px;
            width: 50px;
            font-size: 25px;
            line-height: 60px;
        }

        .info-box-content {
            padding: 15px 15px;
            margin-left: 10px !important;
        }

        .info-box-footer {
            padding: 5px 5px;
            padding-left: 25px !important;
            background-color: #26c6ef;
        }

        .info-box-footer>a {
            color: #ffffff;
        }

        .info-box-icon, .info-box-text, .info-box-number {
            color: #ffffff;
        }
    </style>
@endpush
