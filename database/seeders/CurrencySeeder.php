<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Currency::create([  
            'name' => 'الدولار', 
            'code' => 'USD',
            'value' =>  3.6
        ]);
        Currency::create([  
            'name' => 'الدينار', 
            'code' => 'JOD',
            'value' =>  4.6
        ]);
    }
}
