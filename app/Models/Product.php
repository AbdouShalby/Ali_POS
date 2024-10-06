<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'image',
        'cost',
        'price',
        'wholesale_price',
        'min_sale_price',
        'quantity',
        'min_sale_quantity',
        'stock_alert',
        'unit_id',
        'sale_unit_id',
        'purchase_unit_id',
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
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function saleUnit()
    {
        return $this->belongsTo(Unit::class, 'sale_unit_id');
    }

    public function purchaseUnit()
    {
        return $this->belongsTo(Unit::class, 'purchase_unit_id');
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
}
