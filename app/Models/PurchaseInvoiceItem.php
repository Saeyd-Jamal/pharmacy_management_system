<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseInvoiceItem extends Model
{
    use HasFactory;

    protected $table = 'purchase_invoice_items';

    protected $fillable = [
        'quantity',
        'unit_price',
        'total_price',
        'purchase_invoice_id',
        'medicine_id',
    ];


    // Relationship
    public function purchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoice::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
