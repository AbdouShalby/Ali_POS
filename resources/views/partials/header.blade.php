<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-2 fs-md-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
        </div>
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="{{ route('home') }}" class="d-lg-none">
                <img alt="Logo" src="{{ asset('media/logos/default-small.svg') }}" class="h-30px" />
            </a>
        </div>
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">
                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item here show menu-here-bg menu-lg-down-accordion me-0 me-lg-2">

                    </div>
                </div>
            </div>
            <div class="app-navbar flex-shrink-0">
                <div class="app-navbar-item ms-1 ms-md-4">
                    <a href="{{ route('pos.fullscreen') }}" target="_blank" class="btn btn-primary">
                        <i class="ki-duotone ki-basket fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i>
                        {{ __('pos.point_of_sale') }}
                    </a>
                </div>
                <div class="app-navbar-item ms-1 ms-md-3">
                    <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px w-md-40px h-md-40px position-relative" 
                         id="kt_drawer_chat_toggle">
                        <i class="ki-duotone ki-notification fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <span class="bullet bullet-dot bg-danger h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink unread-count" 
                              id="unread-notifications-count" style="display: none;"></span>
                    </div>
                </div>
                <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
                    <div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <img src="{{ asset('media/avatars/300-3.jpg') }}" class="rounded-3" alt="user" />
                    </div>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <div class="symbol symbol-50px me-5">
                                    <img alt="Logo" src="{{ asset('media/avatars/300-3.jpg') }}" />
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">{{ Auth::user()->name }}</div>
                                    <span class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::user()->email }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="separator my-2"></div>
                        <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                            <a href="#" class="menu-link px-5">
                                <span class="menu-title position-relative">{{ __('general.language') }}
                                <span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">
                                    @if(app()->getLocale() == 'ar')
                                        {{ __('general.arabic') }}
                                        <img class="w-15px h-15px rounded-1 ms-2" src="{{ asset('media/flags/egypt.svg') }}" alt="" />
                                    @else
                                        {{ __('general.english') }}
                                        <img class="w-15px h-15px rounded-1 ms-2" src="{{ asset('media/flags/united-states.svg') }}" alt="" />
                                    @endif
                                </span></span>
                            </a>
                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                <div class="menu-item px-3">
                                    <a href="{{ route('language.switch', 'en') }}" class="menu-link d-flex px-5 {{ app()->getLocale() == 'en' ? 'active' : '' }}">
                                        <span class="symbol symbol-20px me-4">
                                            <img class="rounded-1" src="{{ asset('media/flags/united-states.svg') }}" alt="" />
                                        </span>{{ __('general.english') }}</a>
                                </div>
                                <div class="menu-item px-3">
                                    <a href="{{ route('language.switch', 'ar') }}" class="menu-link d-flex px-5 {{ app()->getLocale() == 'ar' ? 'active' : '' }}">
                                        <span class="symbol symbol-20px me-4">
                                            <img class="rounded-1" src="{{ asset('media/flags/egypt.svg') }}" alt="" />
                                        </span>{{ __('general.arabic') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="menu-item px-5">
                            <a href="{{ route('logout') }}"
                               class="menu-link px-5"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Sign out') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
                    <div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px" id="kt_app_header_menu_toggle">
                        <i class="ki-duotone ki-element-4 fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notifications Drawer -->
<div id="kt_drawer_chat" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="chat" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'md': '500px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_drawer_chat_toggle" data-kt-drawer-close="#kt_drawer_chat_close">
    <div class="card w-100 rounded-0" id="kt_drawer_chat_messenger">
        <div class="card-header pe-5" id="kt_drawer_chat_messenger_header">
            <div class="card-title">
                <div class="d-flex justify-content-center flex-column me-3">
                    <span class="fs-4 fw-bold text-gray-900 me-1 mb-2">{{ __('notifications.notifications') }}</span>
                    <span class="text-muted fs-7" id="notifications-count"></span>
                </div>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-2" id="create-test-notifications">
                    <i class="ki-duotone ki-plus fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </button>
                <button type="button" class="btn btn-sm btn-icon btn-active-light-primary" id="kt_drawer_chat_close">
                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </div>
        </div>
        <div class="card-body" id="kt_drawer_chat_messenger_body">
            <div class="scroll-y me-n5 pe-5" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-dependencies="#kt_drawer_chat_messenger_header, #kt_drawer_chat_messenger_footer" data-kt-scroll-wrappers="#kt_drawer_chat_messenger_body" data-kt-scroll-offset="0px">
                <!-- Notifications will be loaded here -->
            </div>
        </div>
        <div class="card-footer pt-4" id="kt_drawer_chat_messenger_footer">
            <button type="button" class="btn btn-primary w-100" id="mark-all-as-read">
                {{ __('notifications.mark_all_as_read') }}
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
// إعداد CSRF token لجميع طلبات Ajax
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});

function formatTimeAgo(date) {
    const now = moment();
    const notificationDate = moment(date);
    const diffMinutes = now.diff(notificationDate, 'minutes');
    const diffHours = now.diff(notificationDate, 'hours');
    const diffDays = now.diff(notificationDate, 'days');

    if (diffMinutes < 1) {
        return '{{ __("notifications.just_now") }}';
    } else if (diffMinutes < 60) {
        return '{{ __("notifications.minutes_ago") }}'.replace(':minutes', diffMinutes);
    } else if (diffHours < 24) {
        return '{{ __("notifications.hours_ago") }}'.replace(':hours', diffHours);
    } else {
        return '{{ __("notifications.days_ago") }}'.replace(':days', diffDays);
    }
}

function loadNotifications() {
    console.log('Starting to load notifications...');
    
    const notificationsContainer = document.querySelector('#kt_drawer_chat_messenger_body .scroll-y');
    const unreadCountBadge = document.querySelector('#unread-notifications-count');
    const notificationsCount = document.querySelector('#notifications-count');
    
    if (!notificationsContainer || !unreadCountBadge || !notificationsCount) {
        console.error('Required DOM elements not found');
        return;
    }

    // Show loading state
    notificationsContainer.innerHTML = `
        <div class="text-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">{{ __("notifications.loading") }}</span>
            </div>
            <div class="mt-3">{{ __("notifications.loading_notifications") }}</div>
        </div>
    `;

    // Use Fetch API with proper error handling
    fetch('/notifications/unread', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Notifications data:', data);
        
        if (!data.success) {
            throw new Error(data.error || 'Failed to load notifications');
        }

        const notifications = data.notifications || [];
        
        // Update UI with notifications
        if (notifications.length > 0) {
            unreadCountBadge.style.display = 'inline-block';
            unreadCountBadge.textContent = notifications.length;
            notificationsCount.textContent = `{{ __("notifications.unread_notifications") }}: ${notifications.length}`;
            
            notificationsContainer.innerHTML = notifications.map(notification => `
                <div class="d-flex flex-stack py-4 notification-item ${notification.is_read ? 'read' : 'unread'}" 
                     data-id="${notification.id}" 
                     onclick="markNotificationAsRead(${notification.id})">
                    <div class="d-flex align-items-center w-100">
                        <div class="symbol symbol-45px symbol-circle">
                            <span class="symbol-label bg-light-${notification.type === 'stock_alert' ? 'danger' : 'primary'} 
                                  text-${notification.type === 'stock_alert' ? 'danger' : 'primary'} fs-6 fw-bolder">
                                ${notification.type === 'stock_alert' ? '!' : 'i'}
                            </span>
                        </div>
                        <div class="ms-5 w-100">
                            <div class="d-flex flex-stack mb-2">
                                <span class="fs-5 fw-bold text-gray-900">${notification.title}</span>
                                <span class="text-muted fs-7">${formatTimeAgo(notification.created_at)}</span>
                            </div>
                            <div class="fw-semibold text-muted">${notification.message}</div>
                            ${notification.product_id ? `
                                <div class="mt-2">
                                    <a href="/products/${notification.product_id}" 
                                       class="btn btn-sm btn-light-primary"
                                       onclick="event.stopPropagation();">
                                        {{ __("notifications.view_product") }}
                                    </a>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `).join('');
        } else {
            unreadCountBadge.style.display = 'none';
            notificationsCount.textContent = '{{ __("notifications.no_new_notifications") }}';
            notificationsContainer.innerHTML = `
                <div class="text-center text-muted pt-5">
                    <i class="ki-duotone ki-notification-off fs-2x mb-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <div>{{ __("notifications.no_new_notifications") }}</div>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error loading notifications:', error);
        notificationsContainer.innerHTML = `
            <div class="text-center text-danger pt-5">
                <i class="ki-duotone ki-cross-circle fs-2x mb-3">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <div>{{ __("notifications.failed_to_load_notifications") }}</div>
            </div>
        `;
        
        if (typeof toastr !== 'undefined') {
            toastr.error('{{ __("notifications.failed_to_load_notifications") }}');
        }
    });
}

function showError(message) {
    const notificationsContainer = document.querySelector('#kt_drawer_chat_messenger_body .scroll-y');
    if (notificationsContainer) {
        notificationsContainer.innerHTML = `
            <div class="text-center text-danger pt-5">
                <i class="ki-duotone ki-cross-circle fs-2x text-danger">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <div class="mt-3">${message}</div>
            </div>
        `;
    }
    if (typeof toastr !== 'undefined') {
        toastr.error(message);
    }
}

function markNotificationAsRead(id) {
    if (!id) {
        console.error('Invalid notification ID');
        return;
    }

    fetch(`/notifications/${id}/mark-as-read`, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Notification marked as read:', data);
        loadNotifications();
    })
    .catch(error => {
        console.error('Failed to mark notification as read:', error);
        showError('{{ __("notifications.failed_to_mark_notification") }}');
    });
}

// تحميل الإشعارات عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    console.log('Document ready, initializing notifications...');
    loadNotifications();
    
    // إعادة تحميل الإشعارات كل 30 ثانية
    setInterval(loadNotifications, 30000);
    
    // تحديد جميع الإشعارات كمقروءة
    const markAllAsReadButton = document.querySelector('#mark-all-as-read');
    if (markAllAsReadButton) {
        markAllAsReadButton.addEventListener('click', function() {
            fetch('{{ route("notifications.markAllAsRead") }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('All notifications marked as read:', data);
                loadNotifications();
            })
            .catch(error => {
                console.error('Failed to mark all notifications as read:', error);
                showError('{{ __("notifications.failed_to_mark_all_notifications") }}');
            });
        });
    }
    
    // إنشاء إشعارات تجريبية
    const createTestButton = document.querySelector('#create-test-notifications');
    if (createTestButton) {
        createTestButton.addEventListener('click', function() {
            fetch('{{ route("notifications.test") }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Test notifications created:', data);
                if (data.success) {
                    if (typeof toastr !== 'undefined') {
                        toastr.success(data.message);
                    }
                    loadNotifications();
                } else {
                    showError(data.message);
                }
            })
            .catch(error => {
                console.error('Failed to create test notifications:', error);
                showError('{{ __("notifications.failed_to_create_test_notifications") }}');
            });
        });
    }
});
</script>

<style>
.notification-item {
    border-bottom: 1px solid #f5f8fa;
    transition: all 0.3s ease;
    cursor: pointer;
}

.notification-item:hover {
    background-color: #f5f8fa;
}

.notification-item.unread {
    background-color: #f8f9fa;
}

.notification-item.read {
    opacity: 0.8;
}
</style>
@endpush
