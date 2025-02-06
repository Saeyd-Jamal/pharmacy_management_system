<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;
   

    protected $fillable = [
        'name',
        'email',
        'contact_person',
        'address',
        'phone_number',
    ];

    // public function invoice()
    // {
    //     return $this->hasMany(Invoice::class);
    // }

    public function medicine()
    {
        return $this->hasMany(Medicine::class);
    }

    public function purchaseinvoice()
    {
        return $this->hasMany(PurchaseInvoice::class);
    }
}
