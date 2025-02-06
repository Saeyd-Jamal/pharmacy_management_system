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
        
    ];

    

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseinvoiceitem()
    {
        return $this->hasMany(PurchaseInvoiceItem::class);
    }
}
