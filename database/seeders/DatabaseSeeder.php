<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(AuditorSeeder::class);
        $this->call(StandardSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(FacultySeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(ProgramSeeder::class);
    }
}