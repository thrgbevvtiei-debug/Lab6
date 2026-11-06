<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Кондиціонер',
            'Клімат-контроль',
            'Шкіряний салон',
            'Камера заднього виду',
            'Підігрів сидінь',
            'Люк',
            'Парктронік',
            'Круїз-контроль',
        ];

        foreach ($names as $name) {
            Feature::firstOrCreate(['name' => $name]);
        }
    }
}
