<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name' => 'Romance'
            ],
            [
                'name' => 'Action'
            ],
            [
                'name' => 'Cartoon'
            ],
        ];
        
        DB::table('genres')->insert($datas);
    }
}
