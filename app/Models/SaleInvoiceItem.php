<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleInvoiceItem extends Model
{
    use HasFactory;

    protected $table = 'sale_invoice_items';

    protected $fillable = [
        'quantity',
        'unit_price',
        'total_price',
        'sale_invoice_id',
        'medicine_id',
    ];


    // Relationships
    public function saleInvoice()
    {
        return $this->belongsTo(SaleInvoice::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
