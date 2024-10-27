<nav id="sidebar" class="bg-light border-end">
    <div class="sidebar-header p-3">
        <h3>نظام الإدارة</h3>
    </div>
    <ul class="list-unstyled components">
        <li>
            <a href="{{ route('home') }}"><i class="bi bi-house"></i> الرئيسية</a>
        </li>
        <li>
            <a href="#productSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="bi bi-box-seam"></i> المنتجات
            </a>
            <ul class="collapse list-unstyled" id="productSubmenu">
                <li>
                    <a href="{{ route('products.index') }}">قائمة المنتجات</a>
                </li>
                <li>
                    <a href="{{ route('products.create') }}">إضافة منتج جديد</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#categorySubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="bi bi-grid"></i> الأقسام
            </a>
            <ul class="collapse list-unstyled" id="categorySubmenu">
                <li>
                    <a href="{{ route('categories.index') }}">قائمة الأقسام</a>
                </li>
                <li>
                    <a href="{{ route('categories.create') }}">إضافة قسم جديد</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#brandSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="bi bi-tags"></i> العلامات التجارية
            </a>
            <ul class="collapse list-unstyled" id="brandSubmenu">
                <li>
                    <a href="{{ route('brands.index') }}">قائمة العلامات التجارية</a>
                </li>
                <li>
                    <a href="{{ route('brands.create') }}">إضافة علامة تجارية جديدة</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#unitSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="bi bi-rulers"></i> الوحدات
            </a>
            <ul class="collapse list-unstyled" id="unitSubmenu">
                <li>
                    <a href="{{ route('units.index') }}">قائمة الوحدات</a>
                </li>
                <li>
                    <a href="{{ route('units.create') }}">إضافة وحدة جديدة</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#supplierSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="bi bi-truck"></i> الموردين
            </a>
            <ul class="collapse list-unstyled" id="supplierSubmenu">
                <li>
                    <a href="{{ route('suppliers.index') }}">قائمة الموردين</a>
                </li>
                <li>
                    <a href="{{ route('suppliers.create') }}">إضافة مورد جديد</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#customerSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="bi bi-people"></i> العملاء
            </a>
            <ul class="collapse list-unstyled" id="customerSubmenu">
                <li>
                    <a href="{{ route('customers.index') }}">قائمة العملاء</a>
                </li>
                <li>
                    <a href="{{ route('customers.create') }}">إضافة عميل جديد</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#purchaseSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="bi bi-bag-plus"></i> المشتريات
            </a>
            <ul class="collapse list-unstyled" id="purchaseSubmenu">
                <li>
                    <a href="{{ route('purchases.index') }}">قائمة المشتريات</a>
                </li>
                <li>
                    <a href="{{ route('purchases.create') }}">إضافة عملية شراء جديدة</a>
                </li>
                <li>
                    <a href="{{ route('purchases.history') }}">سجل المشتريات</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#externalPurchaseSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="bi bi-bag-plus"></i> المشتريات الخارجية
            </a>
            <ul class="collapse list-unstyled" id="externalPurchaseSubmenu">
                <li>
                    <a href="{{ route('external_purchases.index') }}">قائمة المشتريات</a>
                </li>
                <li>
                    <a href="{{ route('external_purchases.create') }}">إضافة عملية شراء جديدة</a>
                </li>
                <li>
                    <a href="{{ route('purchases.history') }}">سجل المشتريات</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#saleSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="bi bi-bag-check"></i> المبيعات
            </a>
            <ul class="collapse list-unstyled" id="saleSubmenu">
                <li>
                    <a href="{{ route('sales.index') }}">قائمة المبيعات</a>
                </li>
                <li>
                    <a href="{{ route('sales.create') }}">إضافة عملية بيع جديدة</a>
                </li>
                <li>
                    <a href="{{ route('sales.history') }}">سجل المبيعات</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#cryptoGatewaysSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="bi bi-cash-coin"></i> العملات المشفرة
            </a>
            <ul class="collapse list-unstyled" id="cryptoGatewaysSubmenu">
                <li>
                    <a href="{{ route('crypto_gateways.index') }}">البوابات</a>
                </li>
                <li>
                    <a href="{{ route('crypto_transactions.index') }}">عمليات اليوم</a>
                </li>
                <li>
                    <a href="{{ route('crypto_transactions.history') }}">السجل</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#userSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="bi bi-person"></i> المستخدمين
            </a>
            <ul class="collapse list-unstyled" id="userSubmenu">
                <li>
                    <a href="{{ route('users.index') }}">قائمة المستخدمين</a>
                </li>
                <li>
                    <a href="{{ route('users.create') }}">إضافة مستخدم جديدة</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#maintenanceSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="bi bi-wrench"></i> الصيانة
            </a>
            <ul class="collapse list-unstyled" id="maintenanceSubmenu">
                <li>
                    <a href="{{ route('maintenances.index') }}">قائمة الصيانة</a>
                </li>
                <li>
                    <a href="{{ route('users.create') }}">إضافة مستخدم جديدة</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#deviceSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="bi bi-phone"></i> تفاصيل الهواتف
            </a>
            <ul class="collapse list-unstyled" id="deviceSubmenu">
                <li>
                    <a href="{{ route('devices.index') }}">كل الهواتف</a>
                </li>
                <li>
                    <a href="{{ route('devices.create') }}">إضافة هاتف جديدة</a>
                </li>
            </ul>
        </li>
{{--        <li>--}}
{{--            <a href="{{ route('settings.index') }}" aria-expanded="false">--}}
{{--                <i class="bi bi-gear"></i> الاعدادات--}}
{{--            </a>--}}
{{--        </li>--}}
    </ul>
</nav>
