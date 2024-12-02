<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a class="fs-1 fw-bold m-auto text-danger" href="{{ route('home') }}">
            {{ env('APP_NAME') }}
        </a>
    </div>
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6 text-primary" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">

                    <div class="menu-item">
                        <a class="menu-link {{ isset($activePage) && $activePage == 'dashboard' ? 'active' : '' }}" href="{{ route('home') }}">
                            <span class="menu-icon">
                                <i class="ki-solid ki-category fs-1 text-primary"></i>
                            </span>
                            <span class="menu-title {{ isset($activePage) && $activePage == 'dashboard' ? 'text-primary' : '' }}">{{ __('sidebar.Dashboard') }}</span>
                        </a>
                    </div>

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link {{ isset($activePage) && ($activePage == 'products' || $activePage == 'products.create' || $activePage == 'categories' || $activePage == 'brands') ? 'active' : '' }}">
                            <span class="menu-icon">
                                <i class="ki-solid ki-shop fs-1 text-primary"></i>
                            </span>
                            <span class="menu-title {{ isset($activePage) && ($activePage == 'products' || $activePage == 'products.create' || $activePage == 'categories' || $activePage == 'brands') ? 'text-primary' : '' }}">{{ __('sidebar.Products') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'products' ? 'active' : '' }}" href="{{ route('products.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'products' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'products' ? 'text-primary' : '' }}">{{ __('sidebar.All Products') }}</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'products.create' ? 'active' : '' }}" href="{{ route('products.create') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'products.create' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'products.create' ? 'text-primary' : '' }}">{{ __('sidebar.Create Product') }}</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'categories' ? 'active' : '' }}" href="{{ route('categories.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'categories' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'categories' ? 'text-primary' : '' }}">{{ __('sidebar.Categories') }}</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'brands' ? 'active' : '' }}" href="{{ route('brands.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'brands' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'brands' ? 'text-primary' : '' }}">{{ __('sidebar.Brands') }}</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'warehouses' ? 'active' : '' }}" href="{{ route('warehouses.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'warehouses' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'warehouses' ? 'text-primary' : '' }}">{{ __('sidebar.Warehouses') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link {{ isset($activePage) && ($activePage == 'suppliers' || $activePage == 'suppliers.create') ? 'active' : '' }}">
                            <span class="menu-icon">
                                <i class="ki-solid ki-delivery fs-1 text-primary"></i>
                            </span>
                            <span class="menu-title {{ isset($activePage) && ($activePage == 'suppliers' || $activePage == 'suppliers.create') ? 'text-primary' : '' }}">{{ __('sidebar.Suppliers') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'suppliers' ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'suppliers' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'suppliers' ? 'text-primary' : '' }}">{{ __('sidebar.All Suppliers') }}</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'suppliers.create' ? 'active' : '' }}" href="{{ route('suppliers.create') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'suppliers.create' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'suppliers.create' ? 'text-primary' : '' }}">{{ __('sidebar.Create Supplier') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link {{ isset($activePage) && ($activePage == 'customers' || $activePage == 'customers.create') ? 'active' : '' }}">
                            <span class="menu-icon">
                                <i class="ki-solid ki-user-tick fs-1 text-primary"></i>
                            </span>
                            <span class="menu-title {{ isset($activePage) && ($activePage == 'customers' || $activePage == 'customers.create') ? 'text-primary' : '' }}">{{ __('sidebar.Customers') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'customers' ? 'active' : '' }}" href="{{ route('customers.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'customers' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'customers' ? 'text-primary' : '' }}">{{ __('sidebar.All Customers') }}</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'customers.create' ? 'active' : '' }}" href="{{ route('customers.create') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'customers.create' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'customers.create' ? 'text-primary' : '' }}">{{ __('sidebar.Create Customer') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link {{ isset($activePage) && ($activePage == 'sales' || $activePage == 'sales.create' || $activePage == 'sales.history') ? 'active' : '' }}">
                            <span class="menu-icon">
                                <i class="ki-solid ki-cheque fs-1 text-primary"></i>
                            </span>
                            <span class="menu-title {{ isset($activePage) && ($activePage == 'sales' || $activePage == 'sales.create' || $activePage == 'sales.history') ? 'text-primary' : '' }}">{{ __('sidebar.Sales') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'sales' ? 'active' : '' }}" href="{{ route('sales.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'sales' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'sales' ? 'text-primary' : '' }}">{{ __('sidebar.All Sales') }}</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'sales.create' ? 'active' : '' }}" href="{{ route('sales.create') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'sales.create' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'sales.create' ? 'text-primary' : '' }}">{{ __('sidebar.Create Sale') }}</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'sales.history' ? 'active' : '' }}" href="{{ route('sales.history') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'sales.history' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'sales.history' ? 'text-primary' : '' }}">{{ __('sidebar.Sales History') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link {{ isset($activePage) && ($activePage == 'purchases' || $activePage == 'purchases.create' || $activePage == 'purchases.history') ? 'active' : '' }}">
                            <span class="menu-icon">
                                <i class="ki-solid ki-handcart fs-1 text-primary"></i>
                            </span>
                            <span class="menu-title {{ isset($activePage) && ($activePage == 'purchases' || $activePage == 'purchases.create' || $activePage == 'purchases.history') ? 'text-primary' : '' }}">{{ __('sidebar.Purchases') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'purchases' ? 'active' : '' }}" href="{{ route('purchases.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'purchases' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'purchases' ? 'text-primary' : '' }}">{{ __('sidebar.All Purchases') }}</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'purchases.create' ? 'active' : '' }}" href="{{ route('purchases.create') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'purchases.create' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'purchases.create' ? 'text-primary' : '' }}">{{ __('sidebar.Create Purchase') }}</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'purchases.history' ? 'active' : '' }}" href="{{ route('purchases.history') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'purchases.history' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'purchases.history' ? 'text-primary' : '' }}">{{ __('sidebar.Purchase History') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link {{ isset($activePage) && ($activePage == 'external_purchases' || $activePage == 'external_purchases.create') ? 'active' : '' }}">
                            <span class="menu-icon">
                                <i class="ki-solid ki-handcart fs-1 text-primary"></i>
                            </span>
                            <span class="menu-title {{ isset($activePage) && ($activePage == 'external_purchases' || $activePage == 'external_purchases.create') ? 'text-primary' : '' }}">{{ __('sidebar.External Purchases') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'external_purchases' ? 'active' : '' }}" href="{{ route('external_purchases.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'external_purchases' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'external_purchases' ? 'text-primary' : '' }}">{{ __('sidebar.All External Purchases') }}</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'external_purchases.create' ? 'active' : '' }}" href="{{ route('external_purchases.create') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'external_purchases.create' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'external_purchases.create' ? 'text-primary' : '' }}">{{ __('sidebar.Create External Purchases') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link {{ isset($activePage) && ($activePage == 'crypto_gateways' || $activePage == 'crypto_transactions' || $activePage == 'crypto_gateways.create' || $activePage == 'crypto_transactions.history') ? 'active' : '' }}">
                            <span class="menu-icon">
                                <i class="ki-solid ki-bitcoin fs-1 text-primary"></i>
                            </span>
                            <span class="menu-title {{ isset($activePage) && ($activePage == 'crypto_gateways' || $activePage == 'crypto_transactions' || $activePage == 'crypto_gateways.create' || $activePage == 'crypto_transactions.history') ? 'text-primary' : '' }}">{{ __('sidebar.Cryptocurrencies') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'crypto_gateways' ? 'active' : '' }}" href="{{ route('crypto_gateways.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'crypto_gateways' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'crypto_gateways' ? 'text-primary' : '' }}">{{ __('sidebar.Gateways') }}</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'crypto_transactions' ? 'active' : '' }}" href="{{ route('crypto_transactions.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'crypto_transactions' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'crypto_transactions' ? 'text-primary' : '' }}">{{ __('sidebar.Daily Transactions') }}</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'crypto_transactions.history' ? 'active' : '' }}" href="{{ route('crypto_transactions.history') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'crypto_transactions.history' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'crypto_transactions.history' ? 'text-primary' : '' }}">{{ __('sidebar.Transactions History') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link {{ isset($activePage) && ($activePage == 'users' || $activePage == 'users.create') ? 'active' : '' }}">
                            <span class="menu-icon">
                                <i class="ki-solid ki-profile-circle fs-1 text-primary"></i>
                            </span>
                            <span class="menu-title {{ isset($activePage) && ($activePage == 'users' || $activePage == 'users.create') ? 'text-primary' : '' }}">{{ __('sidebar.Users') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'users' ? 'active' : '' }}" href="{{ route('users.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'users' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'users' ? 'text-primary' : '' }}">{{ __('sidebar.All Users') }}</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'users.create' ? 'active' : '' }}" href="{{ route('users.create') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'users.create' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'users.create' ? 'text-primary' : '' }}">{{ __('sidebar.Create User') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link {{ isset($activePage) && ($activePage == 'maintenances' || $activePage == 'maintenances.create') ? 'active' : '' }}">
                            <span class="menu-icon">
                                <i class="ki-solid ki-data fs-1 text-primary"></i>
                            </span>
                            <span class="menu-title {{ isset($activePage) && ($activePage == 'maintenances' || $activePage == 'maintenances.create') ? 'text-primary' : '' }}">{{ __('sidebar.Maintenance') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'maintenances' ? 'active' : '' }}" href="{{ route('maintenances.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'maintenances' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'maintenances' ? 'text-primary' : '' }}">{{ __("Maintenance List") }}</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'maintenances.create' ? 'active' : '' }}" href="{{ route('maintenances.create') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'maintenances.create' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'maintenances.create' ? 'text-primary' : '' }}">{{ __("Maintenance Create") }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link {{ isset($activePage) && ($activePage == 'devices' || $activePage == 'devices.create') ? 'active' : '' }}">
                            <span class="menu-icon">
                                <i class="ki-solid ki-phone fs-1 text-primary"></i>
                            </span>
                            <span class="menu-title {{ isset($activePage) && ($activePage == 'devices' || $activePage == 'devices.create') ? 'text-primary' : '' }}">{{ __('sidebar.Phones Details') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'devices' ? 'active' : '' }}" href="{{ route('devices.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'devices' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'devices' ? 'text-primary' : '' }}">{{ __('sidebar.All Phones') }}</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ isset($activePage) && $activePage == 'devices.create' ? 'active' : '' }}" href="{{ route('devices.create') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot {{ isset($activePage) && $activePage == 'devices.create' ? 'bg-primary' : '' }}"></span>
                                    </span>
                                    <span class="menu-title {{ isset($activePage) && $activePage == 'devices.create' ? 'text-primary' : '' }}">{{ __('sidebar.Create Phone') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
