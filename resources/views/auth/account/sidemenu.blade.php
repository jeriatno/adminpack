<div class="box">
    <div class="box-body box-profile">
        <div class="profile large">
            <div class="user-info">
                <div class="profile-pic"><img id="preview"
                                              src="{{ \Auth::user()->photo  }}"/>
                    <div class="layer">
                        <div class="loader"></div>
                    </div>
                    <a class="image-wrapper" href="#" for="real-input" type="file">
                        <input class="hidden-input" id="real-input" onchange="readURL(this);" type="file" name="image"/>
                        <label class="edit glyphicon glyphicon-pencil" for="real-input" type="file"
                               title="Change picture"></label>
                    </a>
                </div>
                <div class="username">
                    <div class="name"><span class="verified"></span>{{ backpack_auth()->user()->name }}</div>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-pills nav-stacked">

        <li role="presentation"
            @if (Request::route()->getName() == 'backpack.account.info')
            class="active"
            @endif
        ><a href="{{ route('backpack.account.info') }}">{{ trans('backpack::base.update_account_info') }}</a></li>

        <li role="presentation"
            @if (Request::route()->getName() == 'backpack.account.password')
            class="active"
            @endif
        ><a href="{{ route('backpack.account.password') }}">{{ trans('backpack::base.change_password') }}</a></li>

    </ul>
</div>

@push('after_styles')
    <style media="screen">
        .backpack-profile-form .required::after {
            content: ' *';
            color: red;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg) translate(-50%);
            }
            100% {
                transform: rotate(360deg) translate(-50%);
            }
        }

        .loader {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translateY(-50%) translateX(-50%);
            animation: spin 0.35s infinite linear;
            border: 2px solid #707070;
            border-radius: 50%;
            border-top-color: white;
            height: 25px;
            transform-origin: left;
            top: 45%;
            width: 25px;
        }

        .hidden-input {
            left: -999px;
            position: absolute;
        }

        .profile:before, .profile:after {
            content: "";
            display: table;
        }

        .profile:after {
            clear: both;
        }

        .about {
            font-family: Helvetica, "Helvetica Neue", "Tahoma";
            font-size: 12px;
            color: #adadad;
            line-height: 17px;
        }

        .image-wrapper {
            background: rgba(0, 0, 0, 0.2);
            bottom: -50px;
            height: 50px;
            left: 0;
            position: absolute;
            transition: bottom 0.15s linear;
            width: 100%;
        }

        .edit {
            position: relative;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            cursor: pointer;
            font-size: 22px;
            top: 10px;
        }

        .cover {
            height: 300px;
            overflow: hidden;
            position: relative;
            width: 100%;
        }

        .cover img {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            height: 300px;
        }

        .cover .image-wrapper {
            bottom: auto;
            height: 45px;
            left: auto;
            position: absolute;
            right: 0;
            top: 0;
            width: 45px;
        }

        .name {
            font-family: Helvetica, "Helvetica Neue", "Tahoma";
            font-size: 18px;
        }

        .profile-pic {
            margin: auto;
            position: relative;
            border-radius: 50%;
            border: 4px solid white;
            height: 160px;
            overflow: hidden;
            width: 160px;
        }

        .profile-pic img {
            box-sizing: border-box;
            height: 100%;
            left: 50%;
            max-height: 100%;
            position: absolute;
            transform: translateX(-50%);
            transition: all 0.15s ease-out;
            width: auto;
        }

        .profile-pic:hover .image-wrapper {
            bottom: 0;
        }

        .username {
            margin-top: 20px;
            text-align: center;
        }

        .user-info {

            padding: 8px;
            position: relative;
        }

        .user-info:before, .user-info:after {
            content: "";
            display: table;
        }

        .user-info:after {
            clear: both;
        }

        body {
            background-color: #202020;
        }

        .container {
            margin: 40px auto 50px;
            max-width: 960px;
        }

        .layer {
            background-color: rgba(0, 0, 0, 0.25);
            display: none;
            height: 100%;
            left: 0;
            position: absolute;
            top: 0;
            width: 100%;
        }

        .layer.visible {
            display: block;
        }

    </style>
@endpush


@push('after_scripts')
    <script>
        const realInput = document.getElementById('changePicture');

        function readURL(input) {
            if ((validateFileExtension(input, "valid_msg", "pdf/office/image files are only allowed!", new Array("jpg", "pdf", "jpeg", "gif", "png", "doc", "docx", "xls", "xlsx", "ppt", "txt")) == false)) {
                $('#real-input').val('');
                $('#preview')
                    .attr('src', '{{ asset("images/user.png") }}');
                return false;
            } else if (validateSize(input) == 0) {
                $('#real-input').val('');
                $('#preview')
                    .attr('src', '{{ asset("images/user.png") }}');
                return false;
            } else {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#preview')
                            .attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

        }

        function validateSize(file) {
            var FileSize = file.files[0].size / 1024 / 1024;
            if (FileSize > 1) {
                alert('File Lebih Dari 1 MB');
                return 0;
            } else {
                return 1;
            }
        }

        function validateFileExtension(component, msg_id, msg, extns) {
            var flag = 0;
            with (component) {
                var ext = value.substring(value.lastIndexOf('.') + 1);
                for (i = 0; i < extns.length; i++) {
                    if (ext == extns[i]) {
                        flag = 0;
                        break;
                    } else {
                        flag = 1;
                    }
                }
                if (flag != 0) {
                    alert('ekstensi file tidak didukung!');
                    return false;
                } else {
                    return true;
                }
            }
        }
    </script>
@endpush

