<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'barcode',
        'description',
        'image',
        'cost',
        'price',
        'wholesale_price',
        'min_sale_price',
        'stock_alert',
        'brand_id',
        'category_id',
        'is_mobile',
        'color',
        'imei',
        'storage',
        'battery_health',
        'ram',
        'gpu',
        'cpu',
        'condition',
        'device_description',
        'has_box',
        'client_type',
        'customer_id',
        'supplier_id',
        'payment_method',
        'seller_name',
        'scan_id',
        'scan_documents',
        'qrcode'
    ];

    protected $casts = [
        'price' => 'float',
        'cost' => 'float',
        'wholesale_price' => 'float',
        'min_sale_price' => 'float',
        'is_mobile' => 'boolean',
        'has_box' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function mobileDetail()
    {
        return $this->hasOne(MobileDetail::class);
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class)->withPivot('stock', 'stock_alert')->withTimestamps();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%");
        })
            ->when($filters['category'] ?? null, function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->when($filters['brand'] ?? null, function ($query, $brand) {
                $query->where('brand_id', $brand);
            })
            ->when($filters['min_price'] ?? null, function ($query, $minPrice) {
                $query->where('price', '>=', $minPrice);
            })
            ->when($filters['max_price'] ?? null, function ($query, $maxPrice) {
                $query->where('price', '<=', $maxPrice);
            })
            ->when($filters['barcode'] ?? null, function ($query, $barcode) {
                $query->where('barcode', 'like', "%{$barcode}%");
            })
            ->when($filters['selling_price'] ?? null, function ($query, $sellingPrice) {
                $query->where('price', $sellingPrice);
            });
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($product) {
            // تحقق من المخزون في كل مستودع
            foreach ($product->warehouses as $warehouse) {
                if ($warehouse->pivot->stock <= $warehouse->pivot->stock_alert) {
                    Notification::create([
                        'title' => 'تنبيه المخزون',
                        'message' => "المنتج {$product->name} وصل إلى الحد الأدنى للمخزون ({$warehouse->pivot->stock_alert}) في مستودع {$warehouse->name}",
                        'type' => 'stock_alert',
                        'product_id' => $product->id
                    ]);
                }
            }
        });
    }
}
