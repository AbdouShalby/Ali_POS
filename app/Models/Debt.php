<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = ['supplier_id', 'product_id', 'amount', 'note'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function remainingAmount()
    {
        $totalPayments = $this->payments->sum('amount');
        return $this->amount - $totalPayments;
    }

}
