<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo"  style="overflow: visible">
        <a href="{{ route('dashboard.home') }}" class="app-brand-link">
            <span class="app-brand-logo demo" style="overflow: visible">
                <img src=" {{ asset('imgs/logo.png') }}" alt="Logo" width="60">
            </span>
            {{-- <span class="app-brand-text demo menu-text fw-bold">{{ $title }}</span> --}}
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Apps &amp; Pages">العامة</span>
        </li>
        <!-- Page -->
        <li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
            <a href="{{ route('dashboard.home') }}" class="menu-link">
                <i class="fa-solid fa-house me-2"></i>
                <div data-i18n="home">الرئيسية</div>
            </a>
        </li>
        @can('report.view')
        <li class="menu-item {{ request()->is('report/*') || request()->is('report') ? 'active' : '' }}">
            <a href="{{ route('dashboard.report.index') }}" class="menu-link">
                <i class="fa-solid fa-file me-2"></i>
                <div data-i18n="report">التقارير</div>
            </a>
        </li>
        @endcan
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Apps &amp; Pages">الفواتير</span>
        </li>
        @can('view','App\\Models\PurchaseInvoice')
        <li class="menu-item {{ request()->is('purchaseInvoices/*') || request()->is('purchaseInvoices') ? 'active' : '' }}">
            <a href="{{ route('dashboard.purchaseInvoices.index') }}" class="menu-link">
                <i class="fa-solid fa-file-invoice me-2"></i>
                <div data-i18n="purchaseInvoices">فواتير الشراء</div>
            </a>
        </li>
        @endcan
        @can('view','App\\Models\SaleInvoice')
        <li class="menu-item {{ request()->is('saleInvoices/*') || request()->is('saleInvoices') ? 'active' : '' }}">
            <a href="{{ route('dashboard.saleInvoices.index') }}" class="menu-link">
                <i class="fa-solid fa-receipt me-2"></i>
                <div data-i18n="saleInvoices">فواتير البيع</div>
            </a>
        </li>
        @endcan
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Apps &amp; Pages">البيانات</span>
        </li>
        @can('view','App\\Models\Medicine')
        <li class="menu-item {{ request()->is('medicines/*') || request()->is('medicines') ? 'active' : '' }}">
            <a href="{{ route('dashboard.medicines.index') }}" class="menu-link">
                <i class="fa-solid fa-prescription-bottle-alt me-2"></i>
                <div data-i18n="medicines">الأدوية</div>
            </a>
        </li>
        @endcan
        @can('view','App\\Models\Supplier')
        <li class="menu-item {{ request()->is('suppliers/*') || request()->is('suppliers') ? 'active' : '' }}">
            <a href="{{ route('dashboard.suppliers.index') }}" class="menu-link">
                <i class="fa-solid fa-truck me-2"></i>
                <div data-i18n="suppliers">الموردين</div>
            </a>
        </li>
        @endcan
        @can('view','App\\Models\Category')
        <li class="menu-item {{ request()->is('categories/*') || request()->is('categories') ? 'active' : '' }}">
            <a href="{{ route('dashboard.categories.index') }}" class="menu-link">
                <i class="fa-solid fa-layer-group me-2"></i>
                <div data-i18n="categories">الأصناف</div>
            </a>
        </li>
        @endcan

        @can('view','App\\Models\Expense')
        <li class="menu-item {{ request()->is('expense/*') || request()->is('expense') ? 'active' : '' }}">
            <a href="{{ route('dashboard.expense.index') }}" class="menu-link">
            <i class="fa-solid fa-money-check-dollar"></i>
                <div data-i18n="expense">المصاريف</div>
            </a>
        </li>
        @endcan
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Apps &amp; Pages">إدارة النظام</span>
        </li>
        @if (Auth::user()->can('view','App\\Models\User') || Auth::user()->can('view','App\\Models\ActivityLog') || Auth::user()->can('view','App\\Models\Constant') || Auth::user()->can('view','App\\Models\Currency'))
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="fa-solid fa-gear me-2"></i>
                <div data-i18n="settings">الإعدادات</div>
            </a>
            <ul class="menu-sub">
                @can('view','App\\Models\User')
                <li class="menu-item {{ request()->is('users/*') || request()->is('users') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.users.index') }}" class="menu-link">
                        <i class="fa-solid fa-users me-2"></i>
                        <div data-i18n="users">المستخدمين</div>
                    </a>
                </li>
                @endcan
                @can('view','App\\Models\ActivityLog')
                <li class="menu-item {{ request()->is('logs/*') || request()->is('logs') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.logs.index') }}" class="menu-link">
                        <i class="fa-solid fa-calendar-days me-2"></i>
                        <div data-i18n="logs">الأحداث</div>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endif
        {{-- <li class="menu-item">
            <a href="page-2.html" class="menu-link">
                <i class="menu-icon tf-icons ti ti-app-window"></i>
                <i class="fa-solid fa-house me-2"></i>
                <div data-i18n="Page 2">Page 2</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboards">Dashboards</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="index.html" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-chart-pie-2"></i>
                        <div data-i18n="Analytics">Analytics</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="dashboards-crm.html" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-3d-cube-sphere"></i>
                        <div data-i18n="CRM">CRM</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="app-ecommerce-dashboard.html" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-shopping-cart"></i>
                        <div data-i18n="eCommerce">eCommerce</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="app-logistics-dashboard.html" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-truck"></i>
                        <div data-i18n="Logistics">Logistics</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="app-academy-dashboard.html" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-book"></i>
                        <div data-i18n="Academy">Academy</div>
                    </a>
                </li>
            </ul>
        </li> --}}
    </ul>
    <div class="text-body text-white text-center my-3">
        ©
        2025
        , تم الإنشاء ❤️ بواسطة <a href="https://saeyd-jamal.github.io/My_Portfolio/" target="_blank"
            class="footer-link">م . السيد الاخرسي</a>
    </div>
</aside>