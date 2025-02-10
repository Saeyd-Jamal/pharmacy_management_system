<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseInvoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'total_amount',
        'supplier_id',
        'supplier_name',
        'created_by',
        'created_by_name',
    ];


    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'purchase_invoice_items')->as('items')->withPivot('quantity', 'unit_price','total_price');
    }
}
