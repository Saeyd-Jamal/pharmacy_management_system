<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

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


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });

        static::updating(function ($category) {
            $category->slug = Str::slug($category->name);
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

    public function medicine()
    {
        return $this->hasMany(Medicine::class);
    }
}
