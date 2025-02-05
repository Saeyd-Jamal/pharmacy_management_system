<?php

namespace Database\Seeders;

use App\Models\Constant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConstantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $constants = [
            //
        ];
        foreach ($constants as $key => $value) {
            Constant::create([  
                'key' => $key,
                'value' => json_encode($value),
            ]);
        }
    }
}
