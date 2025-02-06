<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
   

    protected $fillable = [
        'name',
        'image',
        'description',
        'slug',
        'created_by',
    ];

    public function medicine()
    {
        return $this->hasMany(Medicine::class);
    }
}
