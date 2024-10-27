<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'description',
        'amount',
        'purchase_date',
    ];
}
