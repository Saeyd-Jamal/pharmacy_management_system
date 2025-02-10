<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'date',
        'total_amount',
        'created_by',
        'created_by_name',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'sale_invoice_items')->as('items')->withPivot('quantity', 'unit_price','total_price');;
    }
}
