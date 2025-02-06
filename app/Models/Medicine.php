<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicine extends Model
{
    use HasFactory;
   

    protected $fillable = [
        'name',
        'image',
        'status',
        'description',
        'price',
        'unit_price',
        'stock_quantity',
        'explry_date',
        'created_by',
        'supplier_id',
        'category_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseinvoiceitem()
    {
        return $this->hasMany(PurchaseInvoiceItem::class);
    }

    public function saleinvoiceitem()
    {
        return $this->hasMany(SaleInvoiceItem::class);
    }

    
}
