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
        
    ];


    public function saleinvoiceitem()
    {
        return $this->hasMany(SaleInvoiceItem::class);
    }

}
