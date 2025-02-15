<?php

namespace App\Models;

use App\Models\Medicine;
use Illuminate\Database\Eloquent\Model;

class MedicineSize extends Model
{
    protected $fillable = [
        'medicine_id',
        'size',
        'price',
        'quantity',
        
    ];


    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
