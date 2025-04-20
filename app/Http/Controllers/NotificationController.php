<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        try {
            \Log::info('Loading notifications index');
            
            $query = Notification::with('product')
                ->orderBy('created_at', 'desc');

            // Apply filters
            if ($request->has('type')) {
                $query->ofType($request->type);
            }

            if ($request->has('read_status')) {
                $query->where('is_read', $request->read_status === 'read');
            }

            if ($request->has('days')) {
                $query->recent($request->days);
            }

            $notifications = $query->paginate(20);
            
            \Log::info('Notifications loaded successfully', [
                'total' => $notifications->total(),
                'current_page' => $notifications->currentPage(),
                'per_page' => $notifications->perPage()
            ]);

            return response()->json($notifications);
        } catch (\Exception $e) {
            \Log::error('Error loading notifications index', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => 'Failed to load notifications'], 500);
        }
    }

    public function unread()
    {
        try {
            \Log::info('Fetching unread notifications');
            
            $notifications = Notification::with('product')
                ->unread()
                ->orderBy('created_at', 'desc')
                ->get();
                
            \Log::info('Unread notifications fetched successfully', [
                'count' => $notifications->count(),
                'notifications' => $notifications->toArray()
            ]);

            return response()->json([
                'success' => true,
                'notifications' => $notifications
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching unread notifications', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to fetch notifications'
            ], 500);
        }
    }

    public function markAsRead($notification)
    {
        try {
            \Log::info('Marking notification as read', ['notification_id' => $notification]);
            
            $notification = Notification::findOrFail($notification);
            $notification->markAsRead();
            
            \Log::info('Successfully marked notification as read', [
                'notification_id' => $notification->id,
                'notification' => $notification->toArray()
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Failed to mark notification as read', [
                'notification_id' => $notification,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false, 
                'message' => 'Failed to mark notification as read'
            ], 500);
        }
    }

    public function markAllAsRead()
    {
        try {
            \Log::info('Marking all notifications as read');
            
            $count = Notification::unread()->count();
            Notification::unread()->update(['is_read' => true]);
            
            \Log::info('Successfully marked all notifications as read', [
                'notifications_count' => $count
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Failed to mark all notifications as read', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false, 
                'message' => 'Failed to mark all notifications as read'
            ], 500);
        }
    }

    public function getUnreadCount()
    {
        $count = Notification::unread()->count();
        return response()->json(['count' => $count]);
    }

    public function getRecentNotifications()
    {
        $notifications = Notification::with('product')
            ->recent(7)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notifications);
    }

    public function createTestNotifications()
    {
        try {
            \Log::info('Starting to create test notifications');
            
            $notifications = [];
            
            // Create a stock alert notification
            $product = Product::first();
            if ($product) {
                \Log::info('Found product for stock alert', [
                    'product_id' => $product->id,
                    'product_name' => $product->name
                ]);
                
                $stockAlert = Notification::create([
                    'title' => __('notifications.stock_alert'),
                    'message' => __('notifications.low_stock_message', [
                        'product_name' => $product->name,
                        'alert_level' => $product->stock_alert_level
                    ]),
                    'type' => 'stock_alert',
                    'product_id' => $product->id,
                    'is_read' => false
                ]);
                
                \Log::info('Stock alert notification created', [
                    'notification' => $stockAlert->toArray()
                ]);
                
                $notifications[] = $stockAlert;
            } else {
                \Log::warning('No products found for stock alert notification');
            }

            // Create a test notification
            \Log::info('Creating test notification');
            
            $testNotification = Notification::create([
                'title' => __('notifications.test_notification_title'),
                'message' => __('notifications.test_notification_message'),
                'type' => 'info',
                'is_read' => false
            ]);
            
            \Log::info('Test notification created', [
                'notification' => $testNotification->toArray()
            ]);
            
            $notifications[] = $testNotification;

            \Log::info('All test notifications created successfully', [
                'count' => count($notifications)
            ]);

            return response()->json([
                'success' => true,
                'message' => __('notifications.test_notifications_created'),
                'notifications' => $notifications
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to create test notifications', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => __('notifications.failed_to_create_test_notifications')
            ], 500);
        }
    }
} 