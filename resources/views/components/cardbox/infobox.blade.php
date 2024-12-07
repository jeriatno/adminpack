<div class="info-box {{ $info_theme ?? 'bg-gradient-info' }}">
    <a href="{{ $info_link ?? 'javascript:void(0)' }}" @if (isset($withOnClick)) onclick="clickStatus('{{ $info_label }}')" @endif>
        <span class="info-box-icon"><i class="fa {{ $info_icon }}"></i></span>
        <div class="info-box-content d-flex justify-content-between align-items-center">
            <span class="info-box-text">
                @if(isset($info_title))
                    <small class="info-box-title">{!! $info_title !!}</small><br>
                @endif
                {!! $info_label !!}
            </span>
            <span class="info-box-number" id="{{ $info_number  ?? '' }}">{{ $info_value ?? '0' }}</span>
        </div>
    </a>
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

        @if(isset($info_title))
            .info-box {
                min-height: 70px !important;
            }

            .info-box-icon {
                height: 70px;
                padding-top: 5px;
            }

            .info-box-title {
                font-size: 12px !important;
            }
        @endif

        .info-box-content {
            padding: 15px 15px;
            margin-left: 40px !important;
        }

        .info-box-icon, .info-box-text, .info-box-number {
            color: #ffffff;
        }

        .bg-gradient-primary {
            background-color: #0072C6;
            color: #fff;
            background-image: linear-gradient(30deg, #0072C6, rgba(115, 103, 240, 0.5));
            background-repeat: repeat-x;
        }

        .bg-gradient-warning {
            background-color: #fafafa;
            color: #fff;
            background-image: linear-gradient(30deg, #ff9f43, rgba(255, 159, 67, 0.5));
            background-repeat: repeat-x;
        }

        .bg-gradient-danger {
            background-color: #640064;
            color: #fff;
            background-image: linear-gradient(30deg, #ea5455, rgba(234, 84, 85, 0.5));
            background-repeat: repeat-x;
        }

        .bg-gradient-secondary {
            background-color: #640064;
            color: #fff;
            background-image: linear-gradient(30deg, #b8c2cc, rgba(184, 194, 204, 0.5));
            background-repeat: repeat-x;
        }

        .bg-gradient-success {
            background-color: #0064fa;
            color: #fff;
            background-image: linear-gradient(30deg, #28c76f, rgba(40, 199, 111, 0.5));
            background-repeat: repeat-x;
        }
    </style>
@endpush
