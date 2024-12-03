<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'quantity',
        'min_sale_quantity',
        'stock_alert',
        'brand_id',
        'category_id',
        'is_device',
        'color',
        'storage',
        'battery_health',
        'ram',
        'gpu',
        'cpu',
        'condition',
        'device_description',
        'has_box',
        'customer_type',
        'customer_id',
        'supplier_id',
        'payment_method',
        'seller_name',
        'scan_id',
        'scan_documents'
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
        return $this->belongsToMany(Warehouse::class)->withPivot('stock', 'stock_alert');
    }
}
