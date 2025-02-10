<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Medicine extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'slug',
        'qr_code',
        'image',
        'status',
        'description',
        'price',
        'unit_price',
        'quantity',
        'production_date',
        'explry_date',
        'created_by',
        'supplier_id',
        'supplier_name',
        'category_id',
        'category_name',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($medicine) {
            $medicine->slug = Str::slug($medicine->name);
        });

        static::updating(function ($medicine) {
            $medicine->slug = Str::slug($medicine->name);
        });
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }


    // Relationships
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

    public function purchaseInvoice()
    {
        return $this->belongsToMany(PurchaseInvoice::class, 'purchase_invoice_items')->as('purchase_invoice_items');
    }

    public function saleInvoice()
    {
        return $this->belongsToMany(SaleInvoice::class, 'sale_invoice_items')->as('sale_invoice_items');
    }
}
