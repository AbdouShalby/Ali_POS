<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'type',
        'product_id',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function createStockAlert($product)
    {
        return self::create([
            'title' => __('notifications.stock_alert'),
            'message' => __('notifications.low_stock_message', [
                'product_name' => $product->name,
                'alert_level' => $product->stock_alert_level
            ]),
            'type' => 'stock_alert',
            'product_id' => $product->id,
            'is_read' => false
        ]);
    }

    public function markAsRead()
    {
        $this->update(['is_read' => true]);
        return $this;
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
} 