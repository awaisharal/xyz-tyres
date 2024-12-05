<div id="sidebarMain" class="d-none">
    <aside
        class="aside-back js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container text-capitalize">
            <div class="navbar-vertical-footer-offset">
                <div class="navbar-brand-wrapper justify-content-between nav-brand-back side-logo">
                    {{-- @php($shop_logo = \App\Models\BusinessSetting::where(['key' => 'shop_logo'])->first()->value) --}}
                    <a class="navbar-brand" href="
                    {{-- {{ route('admin.dashboard') }} --}}
                     "
                        aria-label="
                        {{-- {{ \App\CPU\translate('Front') }} --}}
                         ">
                        <img class="navbar-brand-logo"
                            src="{{ asset('assets/admin/img/logo.png') }}"
                            {{-- // onErrorImage($shop_logo, asset('storage/app/public/shop') . '/' . $shop_logo, --}}
                             {{-- asset('assets/admin/img/logo.png')" --}}
                            alt="logo" style="width: 250px">
                    </a>
                    <button type="button"
                        class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                        <i class="tio-clear tio-lg"></i>
                    </button>
                </div>

                <div class="navbar-vertical-content">
                    <ul class="navbar-nav navbar-nav-lg nav-tabs">
                        <li class="nav-item">
                            <small class="nav-subtitle">Dashboard</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{ Request::is('admin') ? 'show' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link" href="
                            {{ route('admin.dashboard') }}"
                                title="dashboards">
                                <i class="tio-home-vs-1-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    dashboard
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <small class="nav-subtitle">Menue</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        <li class="nav-item {{ Request::is('admin/customer/list') ? 'active' : '' }}">
                            <a class="nav-link " href="
                            {{ route('admin.customer.list') }}
                             "
                                title="
                                list_of_customers
                                {{-- {{ \App\CPU\translate('list_of_customers') }} --}}
                                 ">
                                <span class="tio-user-outlined nav-icon"></span>
                                <span
                                    class="text-truncate">Customers</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/shopkeeper/list') ? 'active' : '' }}">
                            <a class="nav-link" href="
                            {{ route('admin.shopkeeper.list') }}
                             "
                                title="List bookings">
                                {{-- <span class="tio-add-event nav-icon"></span> --}}
                                <span class="tio-shop nav-icon"></span>
                                <span class="text-truncate">Shop Keepers </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/appointment/list') ? 'active' : '' }}">
                            <a class="nav-link" href="
                            {{ route('admin.appointment.list') }}
                             "
                                title="List Appointments">
                                {{-- <span class="tio-add-event nav-icon"></span> --}}
                                <span class="tio-shop nav-icon"></span>
                                <span class="text-truncate">Appointments</span>
                            </a>
                        </li>
                        {{-- @if (\App\CPU\Helpers::module_permission_check('customer_section'))
                            <li class="nav-item">
                                <small class="nav-subtitle">Customers & Bookings</small>
                                <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                            </li>
                            <li
                                class="navbar-vertical-aside-has-menu {{ Request::is('admin/customer*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:">
                                    <i class="tio-poi-user nav-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ \App\CPU\translate('customer') }}</span>
                                </a>
                                <ul
                                    class="js-navbar-vertical-aside-submenu nav nav-sub {{ Request::is('admin/customer*') ? 'd-block' : '' }}">
                                    <li class="nav-item {{ Request::is('admin/customer/add') ? 'active' : '' }}">
                                        <a class="nav-link " href="{{ route('admin.customer.add') }}"
                                            title="{{ \App\CPU\translate('add_new_customer') }}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">{{ \App\CPU\translate('add_customer') }}</span>
                                        </a>
                                    </li>

                                    <li class="nav-item {{ Request::is('admin/customer/list') ? 'active' : '' }}">
                                        <a class="nav-link " href="{{ route('admin.customer.list') }}"
                                            title="{{ \App\CPU\translate('list_of_customers') }}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span
                                                class="text-truncate">{{ \App\CPU\translate('customer_list') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li
                                class="navbar-vertical-aside-has-menu {{ Request::is('admin/booking*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:">
                                    <i class="tio-premium-outlined nav-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ \App\CPU\translate('Bookings') }}</span>
                                </a>
                                <ul
                                    class="js-navbar-vertical-aside-submenu nav nav-sub {{ Request::is('admin/booking/*') ? 'd-block' : '' }}">
                                    <li class="nav-item {{ Request::is('admin/booking/list') ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('admin.booking.list') }}"
                                            title="List bookings">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">List</span>
                                        </a>
                                    </li>

                                    <li class="nav-item {{ Request::is('admin/booking/create') ? 'active' : '' }}">
                                        <a class="nav-link " href="{{ route('admin.booking.create') }}"
                                            title="Create Booking">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">Create</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif --}}

                        {{-- <li class="nav-item">
                            <small class="nav-subtitle">Event Logistics</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li> --}}

                        {{-- <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/menu*') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="
                                {{ route('admin.menu.list') }}
                                 ">
                                <i class="tio-menu-hamburger nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    Menu
                                </span>
                            </a>
                        </li> --}}
                        {{-- <li
                            class="navbar-vertical-aside-has-menu {{ Request::is('admin/inventory*') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="
                                {{ route('admin.inventory.list') }}
                                 ">
                                <i class="tio-appstore nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    Inventory
                                </span>
                            </a>
                        </li> --}}
                        {{-- <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/venue*') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="
                                {{ route('admin.venue.list') }}
                                 ">
                                <i class="tio-my-location nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    Venue
                                </span>
                            </a>
                        </li> --}}

                        

                        {{-- @if (\App\CPU\Helpers::module_permission_check('pos_section'))
                        <li class="nav-item">
                            <small
                                class="nav-subtitle">{{\App\CPU\translate('pos_section')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        @php($orders = \App\Models\Order::get()->count())
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/pos*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
                                <i class="tio-shopping nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CPU\translate('POS')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub {{Request::is('admin/pos*')?'d-block':''}}">
                                <li class="nav-item {{Request::is('admin/pos/')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.pos.index')}}"
                                       title="{{\App\CPU\translate('POS')}}" target="_blank">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('pos')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/pos/orders')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.pos.orders')}}"
                                       title="{{\App\CPU\translate('orders')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('orders')}}
                                            <span class="badge badge-success ml-2">{{ $orders }} </span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        <?php
                        // $modules = ['category_section', 'brand_section', 'unit_section', 'product_section', 'stock_section'];
                        ?>
                        @if (collect($modules)->contains(fn($module) => \App\CPU\Helpers::module_permission_check($module)))
                        <li class="nav-item">
                            <small
                                class="nav-subtitle">{{\App\CPU\translate('product_section')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        @endif
                        @if (\App\CPU\Helpers::module_permission_check('category_section'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/category*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
                                <i class="tio-category nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CPU\translate('category')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub {{Request::is('admin/category*')?'d-block':''}}">
                                <li class="nav-item {{Request::is('admin/category/add')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.category.add')}}"
                                       title="{{\App\CPU\translate('add_new_category')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('category')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/category/add-sub-category')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.category.add-sub-category')}}"
                                       title="{{\App\CPU\translate('add_new_sub_category')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('sub_category')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif --}}
                        {{-- @if (\App\CPU\Helpers::module_permission_check('brand_section'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/brand*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.brand.add')}}">
                                <i class="tio-star nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\translate('brand')}}
                                </span>
                            </a>
                        </li>
                        @endif
                        @if (\App\CPU\Helpers::module_permission_check('unit_section'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/unit*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.unit.index')}}">
                                <i class="tio-calculator nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\translate('unit')}}
                                </span>
                            </a>
                        </li>
                        @endif
                        --}}
                        {{-- @if (\App\CPU\Helpers::module_permission_check('stock_section'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/stock*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.stock.stock-limit')}}">
                                <i class="tio-warning nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\translate('stock_limit_products')}}
                                </span>
                            </a>
                        </li>
                        @endif --}}
                        <?php
                        $modules = ['coupon_section', 'account_section'];
                        ?>
                        {{-- @if (collect($modules)->contains(fn($module) => \App\CPU\Helpers::module_permission_check($module)))
                            <li class="nav-item">
                                <small class="nav-subtitle">{{ \App\CPU\translate('business_section') }}</small>
                                <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                            </li>
                        @endif --}}
                        {{-- @if (\App\CPU\Helpers::module_permission_check('coupon_section'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/coupon*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.coupon.add-new')}}">
                                <i class="tio-gift nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CPU\translate('coupons')}}</span>
                            </a>
                        </li>
                        @endif --}}
                        {{-- @if (account_section) --}}
                            {{-- <li
                                class="navbar-vertical-aside-has-menu {{ Request::is('admin/account*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:">
                                    <i class="tio-wallet nav-icon"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        account_management
                                        {{ \App\CPU\translate('account_management') }}
                                    </span>
                                </a>
                                <ul
                                    class="js-navbar-vertical-aside-submenu nav nav-sub {{ Request::is('admin/account*') ? 'd-block' : '' }}">
                                    <li class="nav-item {{ Request::is('admin/account/add') ? 'active' : '' }}">
                                        <a class="nav-link " href="
                                        {{ route('admin.account.add') }}
                                         "
                                            title="
                                            {{ \App\CPU\translate('add_new_account') }}
                                             ">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span
                                                class="text-truncate">
                                                {{ \App\CPU\translate('add_new_account') }}
                                            </span>
                                        </a>
                                    </li> --}}

                                    {{-- <li class="nav-item {{ Request::is('admin/account/list') ? 'active' : '' }}">
                                        <a class="nav-link " href="
                                        {{ route('admin.account.list') }}
                                         "
                                            title="
                                            {{ \App\CPU\translate('account_list') }}
                                             ">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">
                                                {{ \App\CPU\translate('accounts') }}
                                            </span>
                                        </a>
                                    </li> --}}
                                    {{-- <li
                                        class="nav-item {{ Request::is('admin/account/add-expense') ? 'active' : '' }}">
                                        <a class="nav-link " href="
                                        {{ route('admin.account.add-expense') }}
                                         "
                                            title="
                                            {{ \App\CPU\translate('add_new_expense') }}
                                             ">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">
                                                {{ \App\CPU\translate('new_expense') }}
                                            </span>
                                        </a>
                                    </li> --}}
                                    {{-- <li
                                        class="nav-item {{ Request::is('admin/account/add-income') ? 'active' : '' }}">
                                        <a class="nav-link " href="
                                        {{ route('admin.account.add-income') }}
                                         "
                                            title="
                                            {{ \App\CPU\translate('add_new_income') }}
                                             ">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">
                                                {{ \App\CPU\translate('new_income') }}
                                            </span>
                                        </a>
                                    </li> --}}
                                    {{-- <li
                                        class="nav-item {{ Request::is('admin/account/add-transfer') ? 'active' : '' }}">
                                        <a class="nav-link " href="
                                        {{ route('admin.account.add-transfer') }}
                                         "
                                            title="
                                            {{ \App\CPU\translate('add_new_transfer') }}
                                             ">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span
                                                class="text-truncate">
                                                {{ \App\CPU\translate('new_transfer') }}
                                            </span>
                                        </a>
                                    </li> --}}
                                    {{-- <li
                                        class="nav-item {{ Request::is('admin/account/list-transection') ? 'active' : '' }}">
                                        <a class="nav-link " href="
                                        {{ route('admin.account.list-transection') }}
                                         "
                                            title="
                                            {{ \App\CPU\translate('list_of_transection') }}
                                             ">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span
                                                class="text-truncate">
                                                {{ \App\CPU\translate('transection_list') }}
                                            </span>
                                        </a>
                                    </li> --}}

                                {{-- </ul>
                            </li> --}}
                        {{-- @endif --}}
                        {{-- @if (\App\CPU\Helpers::module_permission_check('payment_section')) --}}
                            {{-- <li class="nav-item {{ Request::is('admin/payment/list') ? 'active' : '' }}">
                                <a class="nav-link " href="
                                {{ route('admin.payment.list') }}
                                 "
                                    title="
                                    {{ \App\CPU\translate('list_of_payment') }}
                                     ">
                                    <i class="tio-paypal nav-icon"></i>
                                    <span class="text-truncate">
                                        {{ \App\CPU\translate('Payments') }}
                                    </span>
                                </a>
                            </li> --}}
                        {{-- @endif --}}

                        {{-- @if (\App\CPU\Helpers::module_permission_check('invoice_section')) --}}
                            {{-- <li class="nav-item {{ Request::is('admin/invoice/list') ? 'active' : '' }}">
                                <a class="nav-link " href="
                                {{ route('admin.invoice.list') }}
                                 "
                                    title="
                                    {{ \App\CPU\translate('manage_invoices') }}
                                     ">
                                    <i class="tio-print nav-icon"></i>
                                    <span class="text-truncate">
                                        {{ \App\CPU\translate('Invoices') }}
                                    </span>
                                </a>
                            </li> --}}
                        {{-- @endif --}}
                        {{-- @if (\App\CPU\Helpers::module_permission_check('reports_section')) --}}
                            {{-- <li class="nav-item">
                                <small class="nav-subtitle">
                                    {{ \App\CPU\translate('reports_section') }}
                                </small>
                                <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                            </li> --}}
                            {{-- <li
                                class="navbar-vertical-aside-has-menu {{ Request::is('admin/reports*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:">
                                    <i class="tio-chart-line-up nav-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{ \App\CPU\translate('Reports') }}
                                    </span>
                                </a>
                                <ul
                                    class="js-navbar-vertical-aside-submenu nav nav-sub {{ Request::is('admin/reports*') ? 'd-block' : '' }}">

                                    <li class="nav-item {{ Request::is('admin/reports/sales') ? 'active' : '' }}">
                                        <a class="nav-link " href="
                                        {{ route('admin.reports.sales') }}
                                         "
                                            title="Sale Report">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span
                                                class="text-truncate">Sale Report</span>
                                        </a>
                                    </li>
                                    
                                    <li class="nav-item {{ Request::is('admin/reports/customer') ? 'active' : '' }}">
                                        <a class="nav-link " href="
                                        {{ route('admin.customer') }}
                                         "
                                            title="
                                            {{ \App\CPU\translate('customer_reports') }}
                                             ">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span
                                                class="text-truncate">
                                                {{ \App\CPU\translate('customer_reports') }}
                                            </span>
                                        </a>
                                    </li>

                                    <li class="nav-item {{ Request::is('admin/reports/payment') ? 'active' : '' }}">
                                        <a class="nav-link " href="
                                        {{ route('admin.reports.payment') }}
                                         "
                                            title="
                                            {{ \App\CPU\translate('payment_reports') }}
                                             ">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span
                                                class="text-truncate">
                                                {{ \App\CPU\translate('payment_reports') }}
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{ Request::is('admin/reports/purchases') ? 'active' : '' }}">
                                        <a class="nav-link " href="
                                        {{ route('admin.reports.purchases') }}
                                         "
                                            title="
                                            {{ \App\CPU\translate('purchase_reports') }}
                                             ">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span
                                                class="text-truncate">
                                                {{ \App\CPU\translate('purchase_reports') }}
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{ Request::is('admin/reports/profit-loss') ? 'active' : '' }}">
                                        <a class="nav-link " href="
                                        {{ route('admin.reports.profit-loss') }}
                                         "
                                            title="
                                            {{ \App\CPU\translate('profit_loss') }}
                                             ">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span
                                                class="text-truncate">
                                                {{ \App\CPU\translate('profit_loss') }}
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </li> --}}
                        {{-- @endif --}}

                        {{-- <?php
                        $modules = ['employee_role_section', 'employee_section'];
                        ?>
                        @if (collect($modules)->contains(fn($module) => \App\CPU\Helpers::module_permission_check($module)))
                            <li class="nav-item">
                                <small class="nav-subtitle">{{ \App\CPU\translate('Employee Section') }}</small>
                                <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                            </li>
                            <li
                                class="navbar-vertical-aside-has-menu {{ Request::is('admin/custom-role*') || Request::is('admin/employee*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:">
                                    <i class="tio-poi-user nav-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ \App\CPU\translate('Employee') }}</span>
                                </a>
                                <ul
                                    class="js-navbar-vertical-aside-submenu nav nav-sub {{ Request::is('admin/custom-role*') || Request::is('admin/employee*') ? 'd-block' : '' }}">
                                    @if (\App\CPU\Helpers::module_permission_check('employee_role_section'))
                                        <li class="nav-item {{ Request::is('admin/custom-role*') ? 'active' : '' }}">
                                            <a class="nav-link " href="{{ route('admin.custom-role.create') }}"
                                                title="{{ \App\CPU\translate('Employee_Role_Setup') }}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span
                                                    class="text-truncate">{{ \App\CPU\translate('Employee Role') }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (\App\CPU\Helpers::module_permission_check('employee_section'))
                                        <li class="nav-item {{ Request::is('admin/employee*') ? 'active' : '' }}">
                                            <a class="nav-link " href="{{ route('admin.employee.add-new') }}"
                                                title="{{ \App\CPU\translate('Employee_add') }}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span
                                                    class="text-truncate">{{ \App\CPU\translate('Add Employee') }}</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif --}}

                        {{-- @if (\App\CPU\Helpers::module_permission_check('supplier_section')) --}}
                            {{-- <li class="nav-item">
                                <small class="nav-subtitle">
                                    {{ \App\CPU\translate('supplier_section') }}
                                    supplier
                                </small>
                                <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                            </li> --}}
                            {{-- <li class="nav-item {{ Request::is('admin/supplier/list') ? 'active' : '' }}">
                                <a class="nav-link " href="
                                {{ route('admin.supplier.list') }}
                                 "
                                    title="
                                    {{ \App\CPU\translate('list_of_suppliers') }}
                                     ">
                                    <span class="tio-users-switch nav-icon"></span>
                                    <span
                                        class="text-truncate">
                                        suppliers
                                        {{ \App\CPU\translate('suppliers') }}
                                    </span>
                                </a>
                            </li> --}}
                            {{-- <li class="nav-item {{ Request::is('admin/purchase/list') ? 'active' : '' }}">
                                <a class="nav-link " href="
                                {{ route('admin.purchase.list') }}
                                "
                                    title="
                                    list_of_purchases
                                    {{ \App\CPU\translate('list_of_purchases') }}
                                     ">
                                    <span class="tio-shop nav-icon"></span>
                                    <span
                                        class="text-truncate">
                                        {{ \App\CPU\translate('Purchases') }}
                                        </span>
                                </a>
                            </li> --}}
                            {{-- <li
                                class="navbar-vertical-aside-has-menu {{ Request::is('admin/supplier*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:">
                                    <i class="tio-users-switch nav-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ \App\CPU\translate('supplier') }}</span>
                                </a>
                                <ul
                                    class="js-navbar-vertical-aside-submenu nav nav-sub {{ Request::is('admin/supplier*') ? 'd-block' : '' }}">
                                    <li class="nav-item {{ Request::is('admin/supplier/add') ? 'active' : '' }}">
                                        <a class="nav-link " href="{{ route('admin.supplier.add') }}"
                                            title="{{ \App\CPU\translate('add_new_supplier') }}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span
                                                class="text-truncate">{{ \App\CPU\translate('add_supplier') }}</span>
                                        </a>
                                    </li>

                                    
                                </ul>
                            </li> --}}
                            <!--Reports -->
                        {{-- @endif --}}

                        {{-- @if (\App\CPU\Helpers::module_permission_check('setting_section')) --}}
                            {{-- <li class="nav-item">
                                <small class="nav-subtitle">
                                    Shop_section
                                    {{ \App\CPU\translate('shop_setting_section') }}
                                </small>
                                <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                            </li> --}}
                            {{-- <li
                                class="navbar-vertical-aside-has-menu {{ Request::is('admin/business-settings*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:">
                                    <i class="tio-settings nav-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        settings
                                        {{ \App\CPU\translate('settings') }}
                                    </span>
                                </a>
                                <ul
                                    class="js-navbar-vertical-aside-submenu nav nav-sub {{ Request::is('admin/business-settings*') ? 'd-block' : '' }}">
                                    <li
                                        class="nav-item {{ Request::is('admin/business-settings/shop-setup') ? 'active' : '' }}">
                                        <a class="nav-link "
                                            href="
                                            {{ route('admin.business-settings.shop-setup') }}
                                             ">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">
                                                {{ \App\CPU\translate('shop') }}
                                                {{ \App\CPU\translate('setup') }}
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </li> --}}
                        {{-- @endif --}}
                        <li class="nav-item pt-8">

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </aside>
</div>
