<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DesignationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $designations = [
            ['name' => 'Professor'],
            ['name' => 'Associate Professor'],
            ['name' => 'Assistant Professor'],
            ['name' => 'Lecturer'],
            ['name' => 'Head of Department'],
            ['name' => 'Lab Assistant'],
            ['name' => 'Network Assistant'],

        ];

        // Use the DB facade to insert the data
        foreach ($designations as $designation) {
            Designation::create($designation);
        }
    }
}
