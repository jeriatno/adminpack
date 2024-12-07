@extends('backpack::layout_guest')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <style type="text/css">
        @media (max-width: 500px) {
            .hide-logo {
                display: none;
            }
        }

        .hide-logo {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        .content-wrapper {
            background: linear-gradient(118deg, #c8d7e3, #77aad4) !important;
        }

        .main-footer {
            padding: 0px !important;
        }

        .row {
            margin: 0px;
        }

        .content {
            padding: 0px !important;
        }

        input {
            font-size: 2rem;
            width: 4.3rem;
            height: 5rem;
            text-align: center;
        }

        input:focus {
            border: 2px solid #328ccd;
            outline: none;
        }

        input:focus {
            animation-name: zoom;
            animation-duration: 500ms;
        }

        @keyframes zoom {
            from {

            }
            to {
                transform: scale(1);
            }
        }

        .digits {
            text-align: center;
        }

        .alert {
            padding: 20px;
            color: white;
            display: none;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: #4b4b4b;
        }

        .expired {
            text-align: center;
            color: darkred;
            font-weight: bold;
            margin-bottom: -10px;
        }
    </style>

    <div class="alert" id="alert">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        <strong id="alert-status"></strong> <span id="alert-message"></span>
    </div>
    <div class="row" style="display: flex;
align-items: center;
height: calc(var(--vh, 1vh) * 100);
justify-content: center; width: 100%">
        <div class="col-md-4">
            <div class="box">
                <div class="box-body" style="padding: 0px">
                    <div class="card bg-authentication rounded-0 mb-0">
                        <div class="col-lg-12 p-t-0">
                            <div class="card rounded-0 mb-0">
                                <div class="card-header">
                                    <div class="card-title">
                                        <center>
                                            <img width="300px" src="{{ asset('logo.png') }}" style="object-fit:
                                            contain;width: 180px;height: 100px"/>
                                        </center>
                                    </div>
                                </div>

                                <div class="card-content" style="padding: 5px 25px 30px 25px">
                                    <div class="card-body">
                                        <div>
                                            <div>
                                                <section class="p-b-15">For added security, you'll need to
                                                    verify your identity. We've sent a verification code to
                                                    <strong>{{ $otp->email }}</strong>
                                                </section>
                                                <div role="group" class="form-group gl-form-group is-valid"
                                                     id="__BVID__31">
                                                    <div class="digits">
                                                        <input type="text" maxlength="1" id="digit1" required/>
                                                        <input type="text" maxlength="1" id="digit2" required/>
                                                        <input type="text" maxlength="1" id="digit3" required/>
                                                        <input type="text" maxlength="1" id="digit4" required/>
                                                        <input type="text" maxlength="1" id="digit5" required/>
                                                        <input type="text" maxlength="1" id="digit6" required/>
                                                    </div>
                                                    <div style="text-align: center;">
                                                        <span id="err_otp_input" style="color: red"></span>
                                                    </div>
                                                </div>
                                                <section class="gl-mt-5">
                                                    <button type="button" onclick="verifyOtp()"
                                                            class="btn btn-primary btn-md btn-block gl-button">
                                                        <span class="gl-button-text">Verify code</span>
                                                    </button>
                                                    <span class="btn btn-block expired" id="expired"></span>
                                                    <button type="button"
                                                            class="btn btn-link btn-block"
                                                            onclick="resendCode()">
                                                        <span>Resend code</span>
                                                    </button>
                                                </section>

                                                <input type="hidden" value="{{ $otp->email }}" id="email" name="email">
                                                <input type="hidden" value="{{ $otp->password }}" id="password"
                                                       name="password">
                                            </div>
                                            <div class="p-t-10">
                                                If you've lost access to the email associated to this account or
                                                having trouble with the code, <a
                                                    href="mailto:ridho.maryonda@metrodata.co.id?subject=Forgot%20Email%20"
                                                    rel="noopener noreferrer">please contact the administrator.</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <input type="hidden" value="{{ $otp->email }}" id="email">
        <input type="hidden" value="{{ $email_response->status }}" id="email_response_status">
        <input type="hidden" value="{{ $email_response->message }}" id="email_response_message">
        <input type="hidden" value="{{ $email_response->expired_time }}" id="expired_time">
    </div>
@endsection

@push('after_scripts')
    <script>
        document.querySelector("input").focus();
        document.querySelector(".digits").addEventListener("input", function ({target, data}) {
            // Exclude non-numeric characters (if a value has been entered)
            data && (target.value = data.replace(/[^0-9]/g, ''));

            const hasValue = target.value !== "";
            const hasSibling = target.nextElementSibling;
            const hasSiblingInput = hasSibling && target.nextElementSibling.nodeName === "INPUT";

            if (hasValue && hasSiblingInput) {
                target.nextElementSibling.focus();
            }
        });

        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;

        let setTimer = () => {
            const created_otp = document.getElementById("expired_time").value
            const countDownDate = new Date(created_otp).getTime();
            const x = setInterval(function () {
                const now = new Date().getTime();
                const distance = countDownDate - now;
                // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                // var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                if (minutes < 10) {
                    minutes = "0" + minutes
                }
                if (seconds < 10) {
                    seconds = "0" + seconds
                }
                document.getElementById("expired").innerHTML = "OTP expired in " + minutes + ":" + seconds;

                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("expired").innerHTML = "OTP is expired.";
                }
            }, 1000);
        }

        let verifyOtp = () => {
            const digit1 = document.getElementById("digit1").value;
            const digit2 = document.getElementById("digit2").value;
            const digit3 = document.getElementById("digit3").value;
            const digit4 = document.getElementById("digit4").value;
            const digit5 = document.getElementById("digit5").value;
            const digit6 = document.getElementById("digit6").value;

            if (digit1 === "" || digit2 === "" || digit3 === "" || digit4 === "" || digit5 === "" || digit6 === "") {
                document.getElementById("err_otp_input").innerText = "Please fill otp fields.."
            } else {
                document.getElementById("err_otp_input").innerText = "";

                const otp_number = digit1 + digit2 + digit3 + digit4 + digit5 + digit6;
                console.log(otp_number, email, password);

                $.ajax({
                    url: "{{ backpack_url('/verify-otp') }}",
                    method: "POST",
                    data: {
                        otp_number: digit1 + digit2 + digit3 + digit4 + digit5 + digit6,
                        email: email,
                        password: password
                    },
                    success: function (res) {
                        if (typeof res.status === 'undefined') {
                            window.location.href = '/admin/login';
                        } else if (res.status === 'Success') {
                            window.location.href = '/admin/login';
                        } else{
                            document.getElementById("expired_time").value = res.expired_time;
                            setAlertMessage(res.status, res.message);
                            setTimer();
                        }
                    }
                });
            }
        }

        let resendCode = () => {
            $.ajax({
                url: "{{ backpack_url('/resend-otp') }}",
                method: "GET",
                data: {
                    email: email,
                },
                success: function (res) {
                    document.getElementById("expired_time").value = res.expired_time;
                    setAlertMessage(res.status, res.message);
                    setTimer();
                }
            });
        }

        let setAlertMessage = (status, message) => {
            document.getElementById("alert-status").innerText = status;
            document.getElementById("alert-message").innerText = message;
            document.getElementById("alert").style.display = 'block';
            setTimeout(function () {
                document.getElementById("alert").style.display = 'none';
            }, 5000);
            if (status === "Success") {
                document.getElementById("alert").style.backgroundColor = '#04AA6D';
            } else {
                document.getElementById("alert").style.backgroundColor = '#F44336';
            }
        }

        const emailResponseStatus = document.getElementById("email_response_status").value;
        const emailResponseMessage = document.getElementById("email_response_message").value;
        setAlertMessage(emailResponseStatus, emailResponseMessage);
        setTimer();
    </script>
@endpush
