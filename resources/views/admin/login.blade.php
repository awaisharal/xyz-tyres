
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>admin | login</title>
    <link rel="shortcut icon" href="">
    <link rel="stylesheet" href="{{asset('assets/admin')}}/css/google-fonts.css">
    <link rel="stylesheet" href="{{asset('assets/admin')}}/css/vendor.min.css">
    <link rel="stylesheet" href="{{asset('assets/admin')}}/vendor/icon-set/style.css">
    <link rel="stylesheet" href="{{asset('assets/admin')}}/css/theme.minc619.css?v=1.0">
    <link rel="stylesheet" href="{{asset('assets/admin')}}/css/toastr.css">
    <link rel="stylesheet" href="{{asset('assets/admin')}}/css/auth-page.css">

</head>

<body class="bg-one-auth">
<main id="content" role="main" class="main">

    {{-- @php($shop_logo=\App\Models\BusinessSetting::where(['key'=>'shop_logo'])->first()->value) --}}
    <div class="auth-wrapper">
        <div class="auth-wrapper-right">
            {{-- <label class="badge badge-soft-danger __login-badge color-EC255A">
                {{\App\CPU\translate('Software version')}}: {{ env('SOFTWARE_VERSION') }}
            </label> --}}

            <div class="auth-wrapper-form">

                <form action="{{route('admin.login')}}" method="post">
                @csrf
                    <div class="auth-header">
                        <div class="mb-5">
                            <h2 class="title">Sign In</h2>
                            <div>Welcome Back. Login to your panel</div>
                        </div>
                    </div>
                    <div class="js-form-message form-group">
                <label class="input-label text-capitalize" for="signinSrEmail"> Your email </label>
                        <input type="email" class="form-control form-control-lg" name="email" id="signinSrEmail"
                                tabindex="1" placeholder="email@address.com"
                                aria-label="email@address.com"
                                required
                                data-msg="Please_enter_a_valid_email_address.">
                    </div>

                    <div class="js-form-message form-group">
                        <label class="input-label" for="signupSrPassword" tabindex="0">
                            <span class="d-flex justify-content-between align-items-center">
                                Password
                            </span>
                        </label>
                        <div class="input-group input-group-merge">
                            <input type="password" class="js-toggle-password form-control form-control-lg"
                                    name="password" id="signupSrPassword"
                                    placeholder="8+ characters required"
                                    aria-label="8+ characters required" required
                                    data-msg="Your password is invalid. Please try again."
                                    data-hs-toggle-password-options='{
                                                "target": "#changePassTarget",
                                    "defaultClass": "tio-hidden-outlined",
                                    "showClass": "tio-visible-outlined",
                                    "classChangeTarget": "#changePassIcon"
                                    }'>
                            <div id="changePassTarget" class="input-group-append">
                                <a class="input-group-text" href="javascript:">
                                    <i id="changePassIcon" class="tio-visible-outlined"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-lg btn-block btn-primary mt-5">sign_in</button>
                </form>

                @if(env('APP_MODE')=='demo')
                    <div class="auto-fill-data-copy">
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <div>
                                <span class="d-block"><strong>Email </strong> : admin@admin.com</span>
                                <span class="d-block"><strong>Password </strong> : 12345678</span>
                            </div>
                            <div>
                                <button class="btn action-btn btn--primary m-0 copy_cred"><i class="tio-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif


            </div>

        </div>
    </div>
</main>


<script src="{{asset('public/assets/admin')}}/js/vendor.min.js"></script>

<script src="{{asset('public/assets/admin')}}/js/theme.min.js"></script>
<script src="{{asset('public/assets/admin')}}/js/toastr.js"></script>
{{-- {!! Toastr::message() !!} --}}

@if ($errors->any())
    <script>
        "use strict";
        @foreach($errors->all() as $error)
        toastr.error('{{$error}}', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        @endforeach
    </script>
@endif

<script>
    $(document).on('ready', function(){

        $(".direction-toggle").on("click", function () {
            setDirection(localStorage.getItem("direction"));
        });

        function setDirection(direction) {
            if (direction == "rtl") {
                localStorage.setItem("direction", "ltr");
                $("html").attr('dir', 'ltr');
            $(".direction-toggle").find('span').text('Toggle RTL')
            } else {
                localStorage.setItem("direction", "rtl");
                $("html").attr('dir', 'rtl');
            $(".direction-toggle").find('span').text('Toggle LTR')
            }
        }

        if (localStorage.getItem("direction") == "rtl") {
            $("html").attr('dir', "rtl");
            $(".direction-toggle").find('span').text('Toggle LTR')
        } else {
            $("html").attr('dir', "ltr");
            $(".direction-toggle").find('span').text('Toggle RTL')
        }

    })
</script>
<script src="{{asset('public/assets/admin')}}/js/auth-page.js"></script>

<script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="{{asset('public/assets/admin')}}/vendor/babel-polyfill/polyfill.min.js"><\/script>');
</script>
</body>
</html>
