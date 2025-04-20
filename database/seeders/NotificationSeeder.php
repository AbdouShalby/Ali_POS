<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\Product;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        // Create a stock alert notification
        $product = Product::first();
        if ($product) {
            Notification::create([
                'title' => 'تنبيه المخزون',
                'message' => "المنتج {$product->name} وصل إلى الحد الأدنى للمخزون",
                'type' => 'stock_alert',
                'product_id' => $product->id,
                'is_read' => false
            ]);
        }

        // Create some test notifications
        Notification::create([
            'title' => 'مرحباً بك في النظام',
            'message' => 'تم تسجيل دخولك بنجاح إلى نظام إدارة المتجر',
            'type' => 'info',
            'is_read' => false
        ]);

        Notification::create([
            'title' => 'تحديث النظام',
            'message' => 'تم تحديث النظام إلى الإصدار الجديد',
            'type' => 'success',
            'is_read' => false
        ]);

        Notification::create([
            'title' => 'تنبيه أمني',
            'message' => 'تم تسجيل دخول جديد من جهاز غير معروف',
            'type' => 'warning',
            'is_read' => false
        ]);
    }
} 