<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'customer_id',
        'product_id',
        'amount',
        'paid',
        'status',
        'note',
    ];

    protected $appends = ['remaining'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getRemainingAttribute()
    {
        return $this->amount - $this->payments()->sum('amount');
    }

}
