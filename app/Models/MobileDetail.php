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
        'storage',
        'battery_health',
        'ram',
        'gpu',
        'cpu',
        'condition',
        'device_description',
        'has_box',
        'qrcode',
        'scan_id',
        'scan_documents',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'battery_health' => 'float',
        'has_box' => 'boolean',
    ];

    /**
     * Get the product that owns the mobile detail.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    // Optional: Consider adding an event listener (Observer) for updating QR code 
    // if relevant data in MobileDetail or associated Product changes.
}
