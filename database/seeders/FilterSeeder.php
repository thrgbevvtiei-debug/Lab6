<?php

namespace Database\Seeders;

use App\Models\Filter;
use Illuminate\Database\Seeder;

class FilterSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Новини салону',
            'Тест-драйв',
            'Поради покупцям',
            'Кредит і лізинг',
            'Електромобілі',
            'Догляд за авто',
        ];

        foreach ($names as $name) {
            Filter::firstOrCreate(['filter_name' => $name]);
        }
    }
}
