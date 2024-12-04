<div id="headerMain" class="d-none">
    <header id="header" class="navbar navbar-expand-lg navbar-fixed navbar-height navbar-flush navbar-container navbar-bordered header-style">
        <div class="navbar-nav-wrap">
            <div class="navbar-brand-wrapper">
                {{-- @php($shop_logo=\App\Models\BusinessSetting::where(['key'=>'shop_logo'])->first()->value) --}}
                {{-- <a class="navbar-brand" href="{{route('admin.dashboard')}}" aria-label="">
                    <img class="navbar-brand-logo"
                         src="{{onErrorImage($shop_logo,asset('storage/app/public/shop').'/' . $shop_logo,asset('public/assets/admin/img/160x160/img2.jpg') ,'shop/')}}" alt="{{\App\CPU\translate('Logo')}}">
                </a> --}}
            </div>

            <div class="navbar-nav-wrap-content-left">
                <button type="button" class="js-navbar-vertical-aside-toggle-invoker navcloser mr-3">
                    <i class="tio-first-page navbar-vertical-aside-toggle-short-align" data-toggle="tooltip"
                       data-placement="right" title="collapse"></i>
                    <i class="tio-last-page navbar-vertical-aside-toggle-full-align"
                       data-template='<div class="tooltip d-none d-sm-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                       data-toggle="tooltip" data-placement="right" title="expand"></i>
                </button>
            </div>
            <div class="navbar-nav-wrap-content-right">
                <ul class="navbar-nav align-items-center flex-row">
                    <li class="nav-item">
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker navbar-dropdown-account-wrapper" href="javascript:;"
                               data-hs-unfold-options='{
                                     "target": "#accountNavbarDropdown",
                                     "type": "css-animation"
                                   }'>
                                <div class="avatar avatar-sm avatar-circle">
                                    <img class="avatar-img"
                                         src="
                                         {{ asset('assets/admin/img/logo.png') }}
                                         {{-- {{auth('admin')->user()->image_fullpath}} --}}
                                         "
                                         alt="img-desc">
                                    <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                                </div>
                            </a>

                            <div id="accountNavbarDropdown"
                                 class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu navbar-dropdown-account">
                                <div class="dropdown-item-text">
                                    <div class="media align-items-center">
                                        <div class="avatar avatar-sm avatar-circle mr-2">
                                            <img class="avatar-img"
                                                 src="
                                                 {{-- {{auth('admin')->user()->image_fullpath}} --}}
                                                 "
                                                 alt="
                                                 {{-- {{\App\CPU\translate('image_description')}} --}}
                                                 ">
                                        </div>
                                        <div class="media-body">
                                            <span class="card-title h5">
                                                {{auth('admin')->user()->name}}
                                            </span>
                                            <span class="card-text">
                                                {{auth('admin')->user()->email}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="
                                {{-- {{route('admin.settings')}} --}}
                                ">
                                    <span class="text-truncate pr-2"
                                          title="settings
                                          {{-- {{\App\CPU\translate('settings')}} --}}
                                          ">
                                          {{-- {{\App\CPU\translate('settings')}} --}}
                                        </span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('admin.logout') }}" id="logoutLink">
                                    <span class="text-truncate pr-2" title="Sign out">
                                        sign_out
                                    </span>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>
</div>
<div id="headerFluid" class="d-none"></div>
<div id="headerDouble" class="d-none"></div>

@push('script_2')
{{-- <script>
    "use strict";

    $(document).on('click', '#logoutLink', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Do you want to logout ?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonColor: '#FC6A57',
            cancelButtonColor: '#363636',
            confirmButtonText: `{{\App\CPU\translate('Yes')}}`,
            denyButtonText: `Don\'t Logout `,
        }).then((result) => {
            if (result.value) {
                window.location.href = '{{route('admin.auth.logout')}}';
            } else {
                Swal.fire('{{\App\CPU\translate('Canceled')}}', '', '{{\App\CPU\translate('info')}}');
            }
        });
    });
</script> --}}
@endpush
