<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'type',
        'date',
        'category',
        'notes',
        'amount',
        'payment_status',
        'payment_method',
        'created_by',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
