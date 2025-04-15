<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'sale_date',
        'total_amount',
        'notes',
        'user_id',
        'discount',
        'tax',
        'tax_percent',
        'payment_method',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_items', 'sale_id', 'product_id');
    }
}
