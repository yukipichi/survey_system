<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ages')->insert([
            ['id' => 1, 'age' => '10代以下', 'sort' => 1],
            ['id' => 2, 'age' => '20代', 'sort' => 2],
            ['id' => 3, 'age' => '30代', 'sort' => 3],
            ['id' => 4, 'age' => '40代', 'sort' => 4],
            ['id' => 5, 'age' => '50代', 'sort' => 5],
            ['id' => 6, 'age' => '60代', 'sort' => 6],
        ]);
    }
}
