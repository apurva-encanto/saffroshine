<?php

namespace Database\Seeders;

use App\Models\Lab;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LabTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Lab::create([
            'lab_name' => 'Lab 1',
            'parent_lab' => 0,
            'members' => 0,
            'status' => 1,
            'is_delete' => 0,
        ]);

        Lab::create([
            'lab_name' => 'Lab 2',
            'parent_lab' => 0,
            'members' => 0,
            'status' => 1,
            'is_delete' => 0,
        ]);


        Lab::create([
            'lab_name' => 'Wax Room',
            'parent_lab' => 0,
            'members' => 0,
            'status' => 1,
            'is_delete' => 0,
        ]);

        Lab::create([
            'lab_name' => 'Linear Contraction',
            'parent_lab' => 0,
            'members' => 0,
            'status' => 1,
            'is_delete' => 0,
        ]);


    }
}
