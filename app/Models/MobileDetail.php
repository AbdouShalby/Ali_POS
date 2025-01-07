<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
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
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
