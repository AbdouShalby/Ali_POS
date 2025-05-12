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
        'brand_id',
        'category_id',
        'is_mobile',
    ];

    protected $casts = [
        'cost' => 'float',
        'price' => 'float',
        'wholesale_price' => 'float',
        'min_sale_price' => 'float',
        'is_mobile' => 'boolean',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the brand that owns the product.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the mobile detail associated with the product.
     */
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
            // Check stock in each warehouse and create notification if below alert level
            foreach ($product->warehouses as $warehouse) {
                if ($warehouse->pivot->stock <= $warehouse->pivot->stock_alert) {
                    // Ensure Notification class is correctly referenced or imported if not already.
                    Notification::create([
                        'title' => 'Stock Alert', // English translation
                        'message' => "Product {$product->name} has reached the minimum stock level ({$warehouse->pivot->stock_alert}) in warehouse {$warehouse->name}.", // English translation
                        'type' => 'stock_alert',
                        'product_id' => $product->id
                    ]);
                }
            }

            // If the product is a mobile and has details,
            // we might need to trigger a QR code regeneration if product data (e.g., name, price) changes.
            // This logic will be handled in ProductController for now, or could be an event/listener.
        });
    }
}
